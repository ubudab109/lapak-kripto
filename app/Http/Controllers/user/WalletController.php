<?php

namespace App\Http\Controllers\user;

use App\Http\Requests\withDrawRequest;
use App\Http\Services\TransactionService;
use App\Jobs\Withdrawal;
use App\Model\DepositeTransaction;
use App\Model\Wallet;
use App\Model\WalletAddressHistory;
use App\Model\WithdrawHistory;
use App\Services\CoinPaymentsAPI;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminSetting;
use App\Model\Bank;
use App\Model\TopupTransaction;
use App\Model\UserBankInfo;
use App\Model\VerificationDetails;
use App\Model\WithdrawBalanceUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PragmaRX\Google2FA\Google2FA;


class WalletController extends Controller
{

    
    // my pocket
    public function myPocket()
    {   
        $data['wallets'] = Wallet::where('user_id',Auth::id())->where('name','DOLLAR')->first();
        $data['nid_front'] = VerificationDetails::where('user_id',Auth::id())->where('field_name','nid_front')->first();
        $data['nid_back'] = VerificationDetails::where('user_id',Auth::id())->where('field_name','nid_back')->first();
        $data['selfie'] = VerificationDetails::where('user_id',Auth::id())->where('field_name','selfie')->first();
        // dd($data);
        $data['settings'] = allsetting();
        $data['title'] = __('My Pocket');
        return view('user.pocket.index',$data);
    }
    
    // Top up IDR
    public function topup()
    {
        $data['settings'] = allsetting();
        $data['banks'] = Bank::where(['status' => STATUS_ACTIVE])->get();
        $valFees = AdminSetting::where('slug','topup_fee_percentage')->first();
        $data['value_fees'] = $valFees->value / 100;
        $data['fees'] = $valFees->value;
        $data['minimum'] = AdminSetting::where('slug','topup_minimum')->first()->value;
        return view('user.pocket.topup', $data);
    }

    // Process topup idr
    public function processTopup(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'bank_code'         => 'required',
                'amount'            => 'required|numeric',
                'sleep'             => 'required|mimes:png,jpeg,jpg|max:2048'
            ]);
            $bank = Bank::where('id', $request->bank_id)->first();

            $data = [
                'user_id'                   => Auth::id(),
                'external_id'               => 'LAPAK-TOPUP-'.time(),
                'payment_type'              => BANK_DEPOSIT,
                'payment_merchant'          => $request->bank_code,
                'dollar_topup'              => $request->amount,
                'total_topup'               => $request->total_topup,
                'virtual_account_number'    => $bank->bank_address,
                'media'                     => uploadFile($request->file('sleep'), IMG_TOPUP_PATH),
                'status'                    => 'PENDING',
            ];  
    
            TopupTransaction::create($data);
            DB::commit();
            return response()->json(true, 200);

        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }


    }

    // Withdraw Form
    public function withdraw()
    {
        $data['banks'] = UserBankInfo::where('user_id', Auth::id())->get();
        $feesType = AdminSetting::where('slug','send_fees_type')->first();
        if ($feesType->value == SEND_FEES_PERCENTAGE) {
            $valFees = AdminSetting::where('slug','send_fees_percentage')->first();
            $data['value_fees'] = $valFees->value / 100;
        } else if ($feesType->value == SEND_FEES_FIXED) {
            $valFees = AdminSetting::where('slug','send_fees_fixed')->first();
            $data['value_fees'] = $valFees->value;
        }
        $data['fees'] = get_fees_wd($feesType->value, $valFees->value);
        $data['max_wd'] = AdminSetting::where('slug','maximum_withdrawal_amount')->first()->value;
        $data['min_wd'] = AdminSetting::where('slug','minimum_withdrawal_amount')->first()->value;
        
        
        return view('user.pocket.withdraw', $data);
    }

    // Withdraw Process
    public function withdrawProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_id'       => 'required|integer',
            'total_wd'      => 'required',
            'dollar_amount' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message'  => 'Harap Periksa Semua Form'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['user_id']           = Auth::id();
            $input['transaction_id']    = 'LAPAK-WITHDRAW-'.time();
            $user = Wallet::where('user_id', Auth::id())->first();
            if ($input['dollar_amount'] > $user->balance) {
                return response()->json([
                    'message' => 'Balance Tidak Mencukupi'
                ],400);
            }
            WithdrawBalanceUser::create($input);
            $user->decrement('balance', $input['dollar_amount']);
            DB::commit();
            return response()->json(true,200);
        } catch(\Exception $err) {
            DB::rollBack();
            return response()->json([
                'message' => $err->getMessage().''.$err->getLine()
            ], 500);
        }
    }


    // Withdraw History
    public function withdrawHistory(Request $request)
    {
        if ($request->ajax()) {
            $data = WithdrawBalanceUser::where('user_id', Auth::id())->get();
            return datatables($data)
            ->editColumn('status',function($row) {
                $html = "<span class='badge ".status_badge($row->status)."'>".deposit_status($row->status)."</span>";
                return $html;
            })
            ->editColumn('media', function($row) {
                if ($row->admin_approval_picture != null) {
                    $html = receipt_wd_html(imageSrc($row->admin_approval_picture,IMG_WD_PATH));
                } else {
                    $html = "<span>Receipt is still Pending</span>";
                }
                return $html;
            })
            ->editColumn('bank', function($row) {
                $html = "<span>".$row->bankUser->bank_name." | ".$row->bankUser->account_holder_address." | ".$row->bankUser->account_holder_name."</span>";

                return $html;
                
            })
            ->editColumn('total_wd', function($row) {
                return 'Rp. '.number_format($row->total_wd, 0);
            })
            ->rawColumns(['status','media','bank','total_wd'])
            ->make(true);
        }

        return view('user.pocket.withdraw-history');
    }
    

    // make default account
    public function makeDefaultAccount($account_id)
    {
        Wallet::where('user_id',Auth::id())->update(['is_primary'=>0]);
        Wallet::updateOrCreate(['id'=>$account_id],['is_primary'=>1]);

        return redirect()->back()->with('success',__('Default set successfully'));
    }

    // create new wallet
    public function createWallet(Request $request)
    {
        if (!empty($request->wallet_name)) {
            $wallet = new Wallet();
            $wallet->user_id = Auth::id();
            $wallet->name = $request->wallet_name;
            $wallet->status = STATUS_SUCCESS;
            $wallet->balance = 0;
            $wallet->save();

            return redirect()->back()->with('success',__("Pocket created successfully"));
        }
        return redirect()->back()->with('dismiss',__("Pocket name can't be empty"));
    }

    // wallet details
    public function walletDetails(Request $request,$id)
    {
        $payment_type = (env('APP_ENV') != "production") ? paymentTypes(PAYMENT_TYPE_LTC) : allsetting('base_coin_type');
        $exists = WalletAddressHistory::where('wallet_id',$id)->orderBy('created_at','desc')->first();
        $data['address'] = (!empty($exists)) ? $exists->address : 'Please Generate new Address';
        $data['wallet_id'] = $id;
        $data['wallet'] = Wallet::find($id);
        $data['wallet_name'] = $data['wallet']->name;
        $data['address_histories'] = WalletAddressHistory::where('wallet_id',$id)->get();
        $data['histories'] = DepositeTransaction::where('receiver_wallet_id',$id)->get();
        $data['withdraws'] = WithdrawHistory::where('wallet_id',$id)->get();
        $data['active'] = $request->q;
        $data['title'] = $request->q;

        // if (empty($exists)) {
        //     $history = new \App\Services\wallet();
        //     $history->AddWalletAddressHistory($id,  $data['address']);
        // }
        return view('user.pocket.wallet_details',$data);
    }

    // generate new wallet address
    public function generateNewAddress(Request $request)
    {
        try {
            $wallet = new \App\Services\wallet();
            $payment_type = (env('APP_ENV') != "production") ? paymentTypes(PAYMENT_TYPE_LTC) : allsetting('base_coin_type');
            $address = get_coin_payment_address($request->wallet_name);

            if (!empty($address)) {
                $wallet->AddWalletAddressHistory($request->wallet_id,$address);
                return redirect()->back()->with(['success'=>__('Address generated successfully')]);
            } else {
                return redirect()->back()->with(['dismiss'=>__('Address not generated ')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', $e->getMessage());
        }

    }

    // generate qr code
    public function qrCodeGenerate(Request $request)
    {
        $image = QRCode::text($request->address)->png();
        return response($image)->header('Content-type','image/png');
    }

    // withdraw balance
    public function WithdrawBalance(withDrawRequest $request) {
        $wallet = Wallet::find($request->wallet_id);
        $NodeDetails = new \App\Services\wallet();

        $address = $request->address;
        $user = $wallet->user;
        if ($request->ajax()) {
            if ($wallet->balance >= $request->amount) {

                if ( filter_var($address, FILTER_VALIDATE_EMAIL) ) {
                    $receiverUser = User::where('email', $address)->first();
                    if ( empty($receiverUser) ) {
                        return response()->json(['success'=>false,'message'=> __('Not a valid email address to send amount!')]);
                    }
                    if ( $user->id == $receiverUser->id ) {
                        return response()->json(['success'=>false,'message'=> __('You can\'t send to your own wallet!')]);
                    }
                    $fees = 0;

                } else {
                    $walletAddress = $this->isInternalAddress($address);
                    if ($walletAddress) {
                        $fees = 0;
                        $receiverUser = $walletAddress->wallet->user;
                        if ( $user->id == $receiverUser->id ) {
                            return response()->json(['success'=>false,'message'=> __('You can\'t send to your own wallet!')]);
                        }
                    } else {
                        $fees = calculate_fees($request->amount, settings('send_fees_type'));
                        if ($wallet->balance < ($request->amount + $fees)) {
                            return response()->json(['success'=>false,'message'=>__('Wallet has no enough balance')]);
                        }
                    }
                }

                if (($request->amount + $fees) < settings('minimum_withdrawal_amount') ) {
                    $message = __('Minimum withdrawal amount ') . settings('minimum_withdrawal_amount') . ' '.settings('coin_name');
                    return response()->json(['success'=>false,'message'=> $message]);
                }
                if (($request->amount + $fees) > settings('maximum_withdrawal_amount') ) {
                    $message = __('Maximum withdrawal amount ') . settings('maximum_withdrawal_amount') . ' '.settings('coin_name');
                    return response()->json(['success'=>false,'message'=> $message]);
                }
                    return response()->json(['success'=>true]);
            //                    return response()->json(['success'=>false,'message'=>__('Address is not valid')]);

            } else {
                return response()->json(['success'=>false,'message'=>__('Wallet has no enough balance')]);
            }

        } else {
            if ( filter_var($address, FILTER_VALIDATE_EMAIL) ) {

                $receiverUser = User::where('email', $address)->first();

                if ( empty($receiverUser) ) {
                    return redirect()->back()->with('dismiss', __('Not a valid email address to send amount!'));
                }
                if ( $user->id == $receiverUser->id ) {
                    return redirect()->back()->with('dismiss', __('You can\'t send to your own wallet!'));
                }
                $fees = 0 ;

            } else {
                $walletAddress = $this->isInternalAddress($address);
                if ($walletAddress) {
                    $fees = 0;
                    $receiverUser = $walletAddress->wallet->user;
                    if ( $user->id == $receiverUser->id ) {
                        return redirect()->back()->with('dismiss', __('You can\'t send to your own wallet!'));
                    }
                }  else {

                    $fees = calculate_fees($request->amount, settings('send_fees_type'));
                    if ($wallet->balance < ($request->amount + $fees)) {
                        return response()->json(['success'=>false,'message'=>__('Wallet has no enough balance')]);
                    }
                }
            }
            if (($request->amount + $fees) < settings('minimum_withdrawal_amount') ) {
                $message = __('Minimum withdrawal amount ') . settings('minimum_withdrawal_amount') . ' '.settings('coin_name');
                return response()->json(['success'=>false,'message'=> $message]);
            }
            if (($request->amount + $fees) > settings('maximum_withdrawal_amount') ) {
                $message = __('Maximum withdrawal amount ') . settings('maximum_withdrawal_amount') . ' '.settings('coin_name');
                return response()->json(['success'=>false,'message'=> $message]);
            }

            $user = Auth::user();
            $google2fa = new Google2FA();
            if(empty($request->code)) {
                return redirect()->back()->with('dismiss',__('Verify code is required'));
            }
            $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code);

            $data = $request->all();
            $data['user_id'] = Auth::id();
            $request = new Request();
            $request = $request->merge($data);

            if ($valid) {
                if ($wallet->balance >= $request->amount) {
                    //                    $request =$request->all();
                    //
                    //                    $trans = new TransactionService();
                    //                    $response = $trans->send($request['wallet_id'],$request['address'],$request['amount'],'','',$request['user_id'],$request['message']);
                    //                    return $response;
                    dispatch(new Withdrawal($request->all()))->onQueue('withdrawal');
                    return redirect()->back()->with('success',__('Withdrawal placed successfully'));
                } else
                    return redirect()->back()->with('dismiss',__('Wallet has no enough balance'));
            } else
                return redirect()->back()->with('dismiss',__('Google two factor authentication is invalid'));
        }
    }

    //check internal address
    private function isInternalAddress($address)
    {
        return WalletAddressHistory::where('address', $address)->with('wallet')->first();
    }

    // transaction history
    public function transactionHistories(Request $request)
    {
        if ($request->ajax()){
            $tr = new TransactionService();
            if ($request->type == 'deposit') {
                $histories = $tr->depositTransactionHistories(Auth::id())->get();
            } else {
                $histories = $tr->withdrawTransactionHistories(Auth::id())->get();
            }
            return datatables( $histories)
                ->addColumn('address', function ($item) {
                    return $item->address;
                })
                ->addColumn('amount', function ($item) {
                    return $item->amount;
                })
                ->addColumn('hashKey', function ($item) use ($request){
                    if ($request->type == 'deposit')
                        return (!empty($item)) ? $item->transaction_id : '';
                    else
                        return (!empty($item)) ? $item->transaction_hash : '';
                })
                ->addColumn('status', function ($item) {
                    return statusAction($item->status);
                })
                ->rawColumns(['user'])
                ->make(true);
        }
    }

    // withdraw rate
    public function withdrawCoinRate(Request $request)
    {
        if ($request->ajax()) {
            $data['amount'] = isset($request->amount) ? $request->amount : 0;

            if(env('APP_ENV') != "production") {
                $data['coin_type'] = paymentTypes(PAYMENT_TYPE_LTC);
            } else {
                $data['coin_type'] = allsetting('base_coin_type');
            }

            $data['coin_price'] = bcmul(settings('coin_price'),$request->amount);
            $coinpayment = new CoinPaymentsAPI();
            $api_rate = $coinpayment->GetRates('');

            $data['btc_dlr'] = converts_currency($data['coin_price'], $data['coin_type'],$api_rate);
            $data['btc_dlr'] = custom_number_format($data['btc_dlr']);

            return response()->json($data);
        }
    }

}
