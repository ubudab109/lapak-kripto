<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TopupTransaction;
use App\Model\Wallet;
use App\Services\XenditService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Xendit\Xendit;

class XenditApiController extends Controller
{
    public $service;

    public function __construct(XenditService $service)
    {
        $this->service = $service;
    }

    /**
     * List payment channels
     */
    public function listPaymentChannels()
    {
        return response()->json($this->service->PaymentChannels(), 200);
    }
    
    /**
     * Create fixed VA
     * User $id
     */
    public function createFixedVa(Request $request, $id)
    {
        $customerName = User::find($id);
        DB::beginTransaction();
        try {
            $createVa = $this->service->CreateFixedVA('LAPAK-TOPUP-'.time(),$request->bank_code, $customerName->first_name.' '.$customerName->last_name, $request->amount);
            TopupTransaction::create([
                'user_id'                   => $customerName->id,
                'external_id'               => $createVa['external_id'],
                'total_topup'               => $request->amount,
                'payment_type'              => XENDIT,
                'payment_channels'          => VA_CHANNELS,
                'payment_merchant'          => $createVa['bank_code'],
                'virtual_account_number'    => $createVa['account_number'],
                'status'                    => $createVa['status'],
                'expired_at'                => $createVa['expiration_date'],
            ]);
            DB::commit();
            return response()->json($createVa, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);

        }
        
    }

    /**
     * Calbback for paid VA
     */
    public function callbackVaPaid(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->headers->set('X-CALLBACK-TOKEN', XENDIT_CALLBACK_TOKEN);
            $getVa = TopupTransaction::where('external_id', $request->external_id)->exists();
            if (!$getVa) {
                return response()->json(false, 403, [
                    'messages' => 'Payment Not Found'
                ]);
            }
            $updateVa = TopupTransaction::where('external_id', $request->external_id)->first();
            if ($updateVa->expired_at < Date::now()) {
                return response()->json(false, 403, [
                    'messages' => 'Payment Expired'
                ]);
            }

            $wallet = Wallet::where('user_id', $updateVa->user_id)->where('name', 'IDR')->first();
            $wallet->increment('balance', $updateVa->total_topup);
    
            $updateVa->update([
                'status' => 'COMPLETED',
            ]);
            DB::commit();
            return response()->json($getVa, 200,[
                    'messages' => 'Payment Sucessfully Updated'
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }
    }

    /**
     * Calbback for created VA
     */
    public function callbackVaCreated(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->headers->set('X-CALLBACK-TOKEN', XENDIT_CALLBACK_TOKEN);
            $getVa = TopupTransaction::where('external_id', $request->external_id)->exists();
            if (!$getVa) {
                return response()->json(false, 403, [
                    'messages' => 'Payment Not Found'
                ]);
            }
            $updateVa = TopupTransaction::where('external_id', $request->external_id)->first();
            $updateVa->update([
                'status' => $request->status,
            ]);
            DB::commit();
            return response()->json($getVa, 200,[
                    'messages' => 'Payment Sucessfully Updated'
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }
    }

    /**
     * Callback for created VA
     */
    public function callbackCreatedVa(Request $request)
    {
        DB::beginTransaction();
        try {
            Xendit::setApiKey(XENDIT_KEY_DEVELOPMENT);
            $request->headers->set('X-CALLBACK-TOKEN', XENDIT_CALLBACK_TOKEN);
            $getHistory = TopupTransaction::where('external_id', $request->external_id)->exists();
            if (!$getHistory) {
                return response()->json(false, 404, [
                    'messages' => 'Payment Not Found'
                ]);
            }

            $updatePayment = TopupTransaction::where('external_id', $request->external_id)->first();
            $updatePayment->update([
                'status'    => $request->status,
            ]);
            DB::commit();
            return response()->json($getHistory, 200,[
                'messages' => 'Payment Sucessfully Created'
            ]);
            
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json(false, 500,[
                'messages' => $err->getMessage(),
            ]);
        }
    }

    /**
     * Create EWallet Charge
     * User $id
     */
    public function createEwalletCharge(Request $request, $id)
    {
        $customerName = User::find($id);
        DB::beginTransaction();
        try {
            if ($request->channelCode == 'ID_OVO') {
                $ewalletCharge = $this->service->CreateChargesEWallet('LAPAK-TOPUP-'.time(), $request->amount, 'ID_OVO', $request->phone_number);
                TopupTransaction::create([
                    'user_id'                   => $customerName->id,
                    'external_id'               => $ewalletCharge['reference_id'],
                    'total_topup'               => $request->amount,
                    'payment_type'              => XENDIT,
                    'payment_channels'          => EWALLET_CHANNELS,
                    'payment_merchant'          => 'OVO',
                    'virtual_account_number'    => $ewalletCharge['channel_properties']['mobile_number'],
                    'status'                    => $ewalletCharge['status'],
                ]);
            }

            if ($request->channelCode == 'ID_DANA' || $request->channelCode == 'ID_LINKAJA') {
                $ewalletCharge = $this->service->CreateChargesEWallet('LAPAK-TOPUP-'.time(), $request->amount, $request->channelCode);
                TopupTransaction::create([
                    'user_id'               => $customerName->id,
                    'external_id'           => $ewalletCharge['reference_id'],
                    'total_topup'           => $request->amount,
                    'payment_type'          => XENDIT,
                    'payment_channels'      => EWALLET_CHANNELS,
                    'payment_merchant'      => $ewalletCharge['channel_code'] == 'ID_DANA' ? 'DANA' : ($ewalletCharge['channel_code'] == 'ID_LINKAJA' ? 'LINKAJA' : ''),
                    'payout_web_link'       => $ewalletCharge['actions']['desktop_web_checkout_url'],
                    'payout_mobile_link'    => $ewalletCharge['actions']['mobile_web_checkout_url'],
                    'status'                => $ewalletCharge['status'],
                ]);
            }

            
            DB::commit();
            return response()->json($ewalletCharge, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }
    }


    /**
     * Get Status For OVO
     */
    public function chargeStatus(Request $request)
    {
        $status = $this->service->EWalletStatus($request->id);
        $wallet = TopupTransaction::where('external_id', $status['reference_id'])->first();
        $balance = Wallet::where('user_id', $wallet->user_id)->where('name','IDR')->first();
        $balance->increment('balance', $status['capture_amount']);
        $wallet->update([
            'status'    => $status['status']
        ]);
        return response()->json($status, 200);
    }

    /**
     * CALLBACK CHARGE PAYMENT E WALLET FOR DANA AND LINKAJA
     */
    public function callbackEWallet()
    {
        $xenditXCallbackToken = XENDIT_CALLBACK_TOKEN;
        $reqHeaders = getallheaders();
        $xIncomingCallbackTokenHeader = isset($reqHeaders['X-Callback-Token']) ? $reqHeaders['X-Callback-Token'] : "";
        if ($xIncomingCallbackTokenHeader === $xenditXCallbackToken) {
            $rawRequestInput = file_get_contents("php://input");
            $arrRequestInput = json_decode($rawRequestInput, true);
            $data = TopupTransaction::where('external_id',$arrRequestInput['data']['reference_id'])->first();
            $wallet = Wallet::where('user_id', $data->user_id)->where('name','IDR')->first();
            $wallet->increment('balance', $data['total_topup']);
            $data->update([
                'status'    => $arrRequestInput['data']['status']
            ]);
            return response()->json($arrRequestInput, 200);
        } else {
            return response()->json(null, 403);
        }

    }
    
    /**
     * REDIRECT AFTER PAYMENT SUCCESS
     */
    public function redirectSuccessEwallet()
    {
        return view('user.buy_coin.ewallet.success-payment');
    }

    /**
     * REDIRECT IF PAYMENT FAILED
     */
    public function redirectFailedEwallet()
    {
        return view('user.buy_coin.ewallet.failure-payment');
    }


    /**
     * PROSES CREATE RETAIL PAYMENT
     */
    public function createRetailPayment(Request $request, $id) 
    {
        $customerName = User::find($id);
        DB::beginTransaction();
        try {
            $createRetail = $this->service->CreateRetailPayment('LAPAK-TOPUP-'.time(), $request->retail_name, $customerName->first_name.' '.$customerName->last_name, $request->amount);
            TopupTransaction::create([
                'user_id'                   => $customerName->id,
                'external_id'               => $createRetail['external_id'],
                'total_topup'               => $request->amount,
                'payment_type'              => XENDIT,
                'payment_channels'          => RETAIL_CHANNELS,
                'payment_merchant'          => $createRetail['retail_outlet_name'],
                'payment_code'              => $createRetail['payment_code'],
                'status'                    => $createRetail['status'],
                'expired_at'                => $createRetail['expiration_date'],
            ]);
            DB::commit();
            return response()->json($createRetail, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);

        }
    }

    /**
     * CALLBACK RETAIL PAID
     */
    public function retailPaymentCallback(Request $request)
    {
        DB::beginTransaction();
        try {
            Xendit::setApiKey(XENDIT_KEY_DEVELOPMENT);
            $request->headers->set('X-CALLBACK-TOKEN', XENDIT_CALLBACK_TOKEN);
            $getHistory = TopupTransaction::where('external_id', $request->external_id)->exists();
            if (!$getHistory) {
                return response()->json(false, 403, [
                    'messages' => 'Payment Not Found'
                ]);
            }

            $updatePayment = TopupTransaction::where('external_id', $request->external_id)->first();
            $balanceUser = Wallet::where('user_id', $updatePayment->user_id)->where('name','IDR')->first();
            $balanceUser->increment('balance', $updatePayment->total_topup);
            $updatePayment->update([
                'status'    => $request->status,
            ]);
            DB::commit();
            return response()->json($getHistory, 200,[
                'messages' => 'Payment Sucessfully Created'
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }
    }

    /**
     * PROCESS QRIS PAYMENT
     */
    public function qrCodePayment(Request $request, $id) 
    {
        $customerName = User::find($id);
        DB::beginTransaction();
        try {
            $qrCreate = $this->service->QRISGenerate('LAPAK-TOPUP-'.time(),'http://2266-8-30-234-79.ngrok.io/api/xendit/ewallet/callback-qris', $request->amount);
            TopupTransaction::create([
                'user_id'                   => $customerName->id,
                'external_id'               => $qrCreate['external_id'],
                'total_topup'               => $request->amount,
                'payment_type'              => XENDIT,
                'payment_channels'          => QRIS_CHANNELS,
                'payment_merchant'          => 'QRIS',
                'payment_code'              => $qrCreate['qr_string'],
                'status'                    => $qrCreate['status'],
            ]);
            DB::commit();
            return response()->json($qrCreate, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }
    }

    /**
     * CALLBACK QRIS PAID
     */
    public function qrCodeCallback(Request $request)
    {
        $xenditXCallbackToken = XENDIT_CALLBACK_TOKEN;
        $reqHeaders = getallheaders();
        $xIncomingCallbackTokenHeader = isset($reqHeaders['X-Callback-Token']) ? $reqHeaders['X-Callback-Token'] : "";
        if ($xIncomingCallbackTokenHeader === $xenditXCallbackToken) {
            $rawRequestInput = file_get_contents("php://input");
            $arrRequestInput = json_decode($rawRequestInput, true);
            $data = TopupTransaction::where('external_id',$arrRequestInput['qr_code']['external_id'])->first();
            $wallet = Wallet::where('user_id', $data->user_id)->where('name','IDR')->first();
            $wallet->increment('balance', $data['total_topup']);
            $data->update([
                'status'    => $arrRequestInput['status']
            ]);
            return response()->json($arrRequestInput, 200);
        } else {
            return response()->json(null, 403);
        }
    }
    
}
