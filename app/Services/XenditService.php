<?php

namespace App\Services;

use Carbon\Carbon;
use Xendit\Xendit;


class XenditService {

  public function __construct()
  {
    Xendit::setApiKey(XENDIT_KEY_DEVELOPMENT);
  }

  public function PaymentChannels()
  {
    return \Xendit\PaymentChannels::list();
  }

  // NOT IMPLEMENTED YET
  // public function CreateTokenCC($amount, $cardNumber, $cardExpMonth, $cardExpYear, $cvn) 
  // {

  // }
  
  /**
   * Procress to create VA
   */
  public function CreateFixedVA($externalId, $bankCode, $customerName, $amount)
  {
    $param = [
      'external_id'     => $externalId,
      'bank_code'       => $bankCode,
      'name'            => $customerName,
      'is_closed'       => true,
      'is_single_use'   => true,
      'expected_amount' => $amount,
      'expiration_date' => Carbon::now()->addHours(24),
    ];

    return \Xendit\VirtualAccounts::create($param);
  }

  /**
   * Process create payment with retail
   */
  public function CreateRetailPayment($externalId, $retailName, $customerName, $amount) 
  {
    $param = [
      'external_id'           => $externalId,
      'retail_outlet_name'    => $retailName,
      'name'                  => $customerName,
      'expected_amount'       => $amount,
      'expiration_date'       => Carbon::now()->addHours(12),
      'is_single_use'         => true,
    ];

    return \Xendit\Retail::create($param);
  }

  /**
   * Process crete payment with ewallet
   */
  public function CreateChargesEWallet($referenceId, $amount, $channelCode, $phoneNumber = null)
  {
    if ($channelCode == 'ID_OVO') {
      $channelProperties = [
        'mobile_number' => $phoneNumber,
        'success_redirect_url'  => route('ewallet.success'),
        'failure_redirect_url'  => route('ewallet.failed')
      ];
    } else {
      $channelProperties = [
        'success_redirect_url'  => route('ewallet.success'),
        'failure_redirect_url'  => route('ewallet.failed')
      ];
    }

    $param = [
      'reference_id'        => $referenceId,
      'currency'            => 'IDR',
      'channel_code'        => $channelCode,
      'amount'              => (float)$amount,
      'checkout_method'     => 'ONE_TIME_PAYMENT',
      'channel_properties'  => $channelProperties
    ];

    return \Xendit\EWallets::createEWalletCharge($param);
  }

  /**
   * Get ewallet payment status
   */
  public function EWalletStatus($charge_id)
  {
    $getEWalletChargeStatus = \Xendit\EWallets::getEWalletChargeStatus($charge_id);
    return $getEWalletChargeStatus;
  }

  public function QRISGenerate($externalId, $callback, $amount)
  {
    $param = [
      'external_id'   => $externalId,
      'type'          => 'DYNAMIC',
      'callback_url'  => $callback,
      'amount'        => $amount,
    ];

    return \Xendit\QRCode::create($param);
  }

}