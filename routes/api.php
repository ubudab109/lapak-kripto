<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/coin-payment-notifier','Api\WalletNotifier@coinPaymentNotifier')->name('coinPaymentNotifier');
Route::get('/rates/{x}','Api\WalletNotifier@getRates')->name('getRates');
Route::post('/createTs','Api\WalletNotifier@createTs')->name('createTs');
Route::get('/price/{price}','Api\WalletNotifier@getPriceCoin')->name('getPriceCoin');
Route::get('/getCurrency','Api\WalletNotifier@getCurrency')->name('getCurrency');
Route::get('/getListAccounts','Api\WalletNotifier@getListAccounts')->name('getListAccounts');
Route::get('/getAuth','Api\WalletNotifier@getAuth')->name('getAuth');

Route::group(['prefix' => 'xendit'], function(){
  Route::get('payment-channels', 'Api\XenditApiController@listPaymentChannels')->name('listPaymentChannels');
  Route::post('create-va/{id}', 'Api\XenditApiController@createFixedVa')->name('createFixedVa');
  Route::post('ewallet-charge/{id}', 'Api\XenditApiController@createEwalletCharge')->name('createEwalletCharge');
  Route::post('retail-charge/{id}', 'Api\XenditApiController@createRetailPayment')->name('createRetailPayment');
  Route::post('qr-charge/{id}', 'Api\XenditApiController@qrCodePayment')->name('qrCodePayment');
  Route::group(['prefix' => 'ewallet'], function() {
    Route::get('success', 'Api\XenditApiController@redirectSuccessEwallet')->name('ewallet.success');
    Route::get('failed', 'Api\XenditApiController@redirectFailedEwallet')->name('ewallet.failed');
    Route::get('status', 'Api\XenditApiController@chargeStatus')->name('ewallet.status');
    Route::post('callback', 'Api\XenditApiController@callbackEWallet')->name('ewallet.callback');
    Route::post('callback-va', 'Api\XenditApiController@callbackVaPaid')->name('ewallet.callback-va');
    Route::post('callback-va-created', 'Api\XenditApiController@callbackVaCreated')->name('ewallet.callback-va-created');
    Route::post('callback-retail', 'Api\XenditApiController@retailPaymentCallback')->name('ewallet.callback-retail');
    Route::post('callback-qris', 'Api\XenditApiController@qrCodeCallback')->name('ewallet.callback-qr');
  });
});

