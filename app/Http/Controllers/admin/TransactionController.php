<?php

namespace App\Http\Controllers\admin;

use App\Http\Services\TransactionService;
use App\Model\DepositeTransaction;
use App\Model\Wallet;
use App\Model\WithdrawHistory;
use App\Repository\AffiliateRepository;
use App\Services\CoinPaymentsAPI;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\WithdrawBalanceUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function foo\func;

class TransactionController extends Controller
{
    // all wallet list
    public function adminWalletList(Request $request)
    {
        $data['title'] = __('Pocket List');
        if($request->ajax()){
            $data['wallets'] = Wallet::join('users','users.id','=','wallets.user_id')
                ->select(
                    'wallets.name'
                    ,'wallets.balance'
                    ,'wallets.referral_balance'
                    ,'wallets.created_at'
                    ,'users.first_name'
                    ,'users.last_name'
                    ,'users.email'
                );

            return datatables()->of($data['wallets'])
                ->addColumn('user_name',function ($item){return $item->first_name.' '.$item->last_name;})
                ->make(true);
        }

        return view('admin.wallet.index',$data);
    }

    // ADMIN: USER TOPUP HISTORY
    public function adminTopupList()
    {
        $data['title'] = __('Topup Transaction');

        return view('admin.wallet.topup-history',$data);
    }

    // transaction  history
    public function adminTransactionHistory(Request $request)
    {
        $data['title'] = __('Transaction History');
        if ($request->ajax()) {
            $deposit = DepositeTransaction::select('deposite_transactions.address'
                , 'deposite_transactions.amount'
                , 'deposite_transactions.fees'
                , 'deposite_transactions.transaction_id'
                , 'deposite_transactions.confirmations'
                , 'deposite_transactions.address_type as addr_type'
                , 'deposite_transactions.created_at'
                , 'deposite_transactions.sender_wallet_id'
                , 'deposite_transactions.receiver_wallet_id'
                , 'deposite_transactions.status'
            );

            return datatables()->of($deposit)
                ->addColumn('address_type', function ($dpst) {
                    if ($dpst->addr_type == 'internal_address') {
                        return 'External';
                    } else {
                        return addressType($dpst->addr_type);
                    }

                })
                ->addColumn('status', function ($dpst) {
                    return deposit_status($dpst->status);
                })
                ->addColumn('sender', function ($dpst) {
                    return isset($dpst->senderWallet->user) ? $dpst->senderWallet->user->first_name . ' ' . $dpst->senderWallet->user->last_name : '';
                })
                ->addColumn('receiver', function ($dpst) {
                    return isset($dpst->receiverWallet->user) ? $dpst->receiverWallet->user->first_name . ' ' . $dpst->receiverWallet->user->last_name : '';
                })
                ->make(true);
        }

        return view('admin.transaction.all-transaction', $data);
    }

    // Accep Withdraw Balance Version 2
    public function acceptWithdraw(Request $request, $id)
    {
        $request->validate([
            'admin_approval_picture' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $wdUser = WithdrawBalanceUser::find($id);
            $wdUser->update([
                'status'                    => STATUS_ACCEPTED,
                'admin_approval_picture'    => uploadFile($request->file('admin_approval_picture'), IMG_WD_PATH),
            ]);
            DB::commit();
            return redirect()->route('adminPendingWithdrawal')->with('success', __('Pending Withdrawal accepted Successfully!'));
        } catch (\Exception $err) {
            DB::rollBack();
            return redirect()->route('adminPendingWithdrawal')->with('dismiss', __('Something went wrong! Please try again!'));
        }
    }

    // Accep Withdraw Balance Version 2
    public function rejectWithdraw($id)
    {
        DB::beginTransaction();
        try {
            $wdUser = WithdrawBalanceUser::where('transaction_id',$id)->first();;
            $wdUser->update([
                'status'                    => STATUS_REJECTED,
            ]);
            $walletUser = Wallet::where('user_id', $wdUser->user_id)->first();
            $walletUser->increment('balance',$wdUser->dollar_amount);
            DB::commit();
            return redirect()->route('adminPendingWithdrawal')->with('success', __('Pending Withdrawal rejected Successfully!'));
        } catch (\Exception $err) {
            DB::rollBack();
            return redirect()->route('adminPendingWithdrawal')->with('dismiss', __('Something went wrong! Please try again!'));
        }
    }


    // pending withdrawal list
    public function adminPendingWithdrawal(Request $request)
    {
        $data['title'] = __('Withdrawal');
        if ($request->ajax()) {
            $withdrawal = WithdrawBalanceUser::where(['status' => STATUS_PENDING])->get();

            return datatables()->of($withdrawal)
                ->editColumn('status',function($row) {
                    $html = "<span class='badge ".status_badge($row->status)."'>".deposit_status($row->status)."</span>";
                    return $html;
                })
                ->editColumn('media', function($row) {
                    if ($row->admin_approval_picture != null) {
                        $html = "<a href='#' data-toggle='modal' data-target='#receipt' onclick='showReceipt(".$row->admin_approval_picture.")'>Receipt from Admin</a>";
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
                ->addColumn('actions', function ($wdrl) {
                    $action = '<ul>';
                    $action .= '<li class="deleteuser"><a title="Accept" href="#" onclick="openModalAccept('.$wdrl->id.')" data-toggle="modal" data-target="#accept_modal"><span class=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>
                    </span></a> </li>';
                    $action .= reject_wd_html($wdrl->transaction_id);
                    $action .= '<ul>';

                    return $action;
                })
                ->rawColumns(['actions','status','media','bank','total_wd'])
                ->make(true);
        }
        return view('admin.transaction.pending-withdrawal', $data);
    }

    // rejected withdrawal list
    public function adminRejectedWithdrawal(Request $request)
    {
        $data['title'] = __('Rejected Withdrawal');
        if ($request->ajax()) {
            $withdrawal = WithdrawBalanceUser::where(['status' => STATUS_REJECTED])->get();

            return datatables()->of($withdrawal)
                ->editColumn('status',function($row) {
                    $html = "<span class='badge ".status_badge($row->status)."'>".deposit_status($row->status)."</span>";
                    return $html;
                })
                ->editColumn('media', function($row) {
                    return 'Rejected';
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

        return view('admin.transaction.pending-withdrawal', $data);
    }

    // active withdrawal list
    public function adminActiveWithdrawal(Request $request)
    {
        $data['title'] = __('Active Withdrawal');
        if ($request->ajax()) {
            $withdrawal = WithdrawBalanceUser::where(['status' => STATUS_ACCEPTED])->get();

            return datatables()->of($withdrawal)
                ->editColumn('status',function($row) {
                    $html = "<span class='badge ".status_badge($row->status)."'>".deposit_status($row->status)."</span>";
                    return $html;
                })
                ->editColumn('media', function($row) {
                    if ($row->admin_approval_picture != null) {
                        $html = "<a href='#' data-toggle='modal' data-target='#receipt' onclick='showReceipt(".$row->admin_approval_picture.")'>Receipt from Admin</a>";
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

        return view('admin.transaction.pending-withdrawal', $data);
    }

    // accept process of pending withdrawal
    public function adminAcceptPendingWithdrawal($id)
    {
        if (isset($id)) {
            try {
                $wdrl_id = decrypt($id);
            } catch (\Exception $e) {
                return redirect()->back();
            }
            $transaction = WithdrawHistory::with('wallet')->with('users')->where(['id' => $wdrl_id, 'status' => STATUS_PENDING])->firstOrFail();
            $affiliate_servcice = new AffiliateRepository();
            if (!empty($transaction)) {
                if ($transaction->address_type == ADDRESS_TYPE_INTERNAL) {

                    $deposit = DepositeTransaction::where(['transaction_id' =>$transaction->transaction_hash, 'address' => $transaction->address])->update(['status' => STATUS_SUCCESS]);

                    Wallet::where(['id' => $transaction->receiver_wallet_id])->increment('balance', $transaction->amount);
                    $transaction->status = STATUS_SUCCESS;
                    $transaction->save();

                    return redirect()->back()->with('success', 'Pending withdrawal accepted Successfully.');

                } elseif ($transaction->address_type == ADDRESS_TYPE_EXTERNAL) {
                    $btc_service = new CoinPaymentsAPI();

                    $currency =  env('APP_ENV') == 'production' ? allsetting('base_coin_type') : 'LTCT';

                    $coinpayment = new CoinPaymentsAPI();
                    $api_rate = $coinpayment->GetRates('');

                     $dollerAmmount = bcmul($transaction->amount,settings()['coin_price'],8);
                     $btcAmmount = converts_currency($dollerAmmount, $currency,$api_rate);

                    $response = $btc_service->CreateWithdrawal($btcAmmount,$currency,$transaction->address);


                    if (is_array($response) && isset($response['error']) && ($response['error'] == 'ok') ) {
                        $transaction->transaction_hash = $response['result']['id'];
                        $transaction->status = STATUS_SUCCESS;
                        $transaction->update();
                        $bonus = $affiliate_servcice->storeAffiliationHistory($transaction);
                        return redirect()->back()->with('success', __('Pending withdrawal accepted Successfully.'));

                    }else{
                        return redirect()->back()->with('dismiss', $response['error']);
                    }


                }
            }

            return redirect()->back()->with('dismiss', __('Something went wrong! Please try again!'));
        }
    }

    // pending withdrawal reject process
    public function adminRejectPendingWithdrawal($id)
    {
        if (isset($id)) {
            try {
                $wdrl_id = decrypt($id);
            } catch (\Exception $e) {
                return redirect()->back();
            }
            $transaction = WithdrawHistory::where(['id' => $wdrl_id, 'status' => STATUS_PENDING])->firstOrFail();

            if (!empty($transaction)) {
                if ($transaction->address_type == ADDRESS_TYPE_INTERNAL) {

                    Wallet::where(['id' => $transaction->wallet_id])->increment('balance', $transaction->amount);
                    $transaction->status = STATUS_REJECTED;
                    $transaction->update();

                    $deposit = DepositeTransaction::where(['transaction_id' =>$transaction->transaction_hash, 'address' => $transaction->address])->update(['status' => STATUS_REJECTED]);

                    return redirect()->back()->with('success', 'Pending withdrawal rejected Successfully.');
                } elseif ($transaction->address_type == ADDRESS_TYPE_EXTERNAL) {
                    Wallet::where(['id' => $transaction->wallet_id])->increment('balance', $transaction->amount);
                    $transaction->status = STATUS_REJECTED;

                    $transaction->update();

                    return redirect()->back()->with('success', __('Pending Withdrawal rejected Successfully.'));
                }
            }

            return redirect()->back()->with('dismiss', __('Something went wrong! Please try again!'));
        }
    }

   
}
