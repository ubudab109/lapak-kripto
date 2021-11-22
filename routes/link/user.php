<?php

Route::group(['prefix'=>'user','namespace'=>'user','middleware'=> ['auth','user', 'lang']],function () {

    Route::get('dashboard', 'DashboardController@userDashboard')->name('userDashboard');
    Route::get('show-notification', 'DashboardController@showNotification')->name('showNotification');
    Route::get('faq', 'DashboardController@userFaq')->name('userFaq');
    Route::get('profile', 'ProfileController@userProfile')->name('userProfile');
    Route::post('nid-upload', 'ProfileController@nidUpload')->name('nidUpload');
    Route::post('pass-upload', 'ProfileController@passUpload')->name('passUpload');
    Route::post('driving-licence-upload', 'ProfileController@driveUpload')->name('driveUpload');
    Route::get('referral', 'ReferralController@myReferral')->name('myReferral');
    Route::get('setting', 'SettingController@userSetting')->name('userSetting');
    Route::get('setting-bank', 'SettingController@bankSetting')->name('bankSetting');
    Route::post('add-bank', 'SettingController@addNewBank')->name('addNewBank');
    Route::post('update-bank/{id}', 'SettingController@updateBank')->name('updateBank');
    Route::get('detail-bank/{id}', 'SettingController@detailBank')->name('detailBank');
    Route::get('my-pocket', 'WalletController@myPocket')->name('myPocket');
    Route::get('withdraw', 'WalletController@withdraw')->name('withdraw');
    Route::get('withdraw-history', 'WalletController@withdrawHistory')->name('withdrawHistory');
    Route::post('withdraw-process', 'WalletController@withdrawProcess')->name('withdrawProcess');

    Route::post('g2f-secret-save', 'SettingController@g2fSecretSave')->name('g2fSecretSave');
    Route::post('google-login-enable', 'SettingController@googleLoginEnable')->name('googleLoginEnable');
    Route::post('save-preference', 'SettingController@savePreference')->name('savePreference');

    Route::get('/generate/new-address', 'WalletController@generateNewAddress')->name('generateNewAddress');
    Route::get('/qrcode/generate', 'WalletController@qrCodeGenerate')->name('qrCodeGenerate');
    Route::get('/make-account-default-{account_id}', 'WalletController@makeDefaultAccount')->name('makeDefaultAccount');
    Route::any('/Wallet-create', 'WalletController@createWallet')->name('createWallet');
    Route::get('/wallet-details-{id}', 'WalletController@walletDetails')->name('walletDetails');
    Route::post('/Withdraw/balance', 'WalletController@WithdrawBalance')->name('WithdrawBalance');
    Route::get('transaction-histories', 'WalletController@transactionHistories')->name('transactionHistories');
    Route::get('topup', 'WalletController@topup')->name('topup');
    Route::post('topup-process', 'WalletController@processTopup')->name('processTopup');
    Route::post('withdraw-coin-rate', 'WalletController@withdrawCoinRate')->name('withdrawCoinRate');


    Route::get('buy-coin', 'CoinController@buyCoinPage')->name('buyCoin');
    Route::post('buy-coin-rate', 'CoinController@buyCoinRate')->name('buyCoinRate');
    Route::get('bank-details', 'CoinController@bankDetails')->name('bankDetails');
    Route::get('bank-details-users', 'CoinController@bankDetailsUser')->name('bankDetailsUser');
    Route::post('buy-coin', 'CoinController@buyCoin')->name('buyCoinProcess');
    Route::post('buy-coins', 'CoinController@buyCoins')->name('buyCoinsProcess');
    Route::get('buy-coin-by-{address}', 'CoinController@buyCoinByAddress')->name('buyCoinByAddress');
    Route::get('buy-coin-history', 'CoinController@buyCoinHistory')->name('buyCoinHistory');
    Route::get('getAddress/{walletName}', 'CoinController@getAddressPocket')->name('getAddressPocket');
    Route::get('getRates/{pair}', 'CoinController@getRates')->name('ind.getRates');

    Route::get('my-membership', 'ClubController@myMembership')->name('myMembership');
    Route::get('membership-club-plans', 'ClubController@membershipClubPlan')->name('membershipClubPlan');
    Route::post('transfer-coin-to-club', 'ClubController@transferCoinToClub')->name('transferCoinToClub');
    Route::post('transfer-coin-to-wallet', 'ClubController@transferCoinToWallet')->name('transferCoinToWallet');

    
    Route::get('va-transaction', 'TopupHistoryController@vaHistory')->name('vaHistory');
    Route::get('va-transaction-show/{id}', 'TopupHistoryController@showTopupHistory')->name('showTopupHistory');
    Route::get('ewallet-transaction', 'TopupHistoryController@eWalletHistory')->name('eWalletHistory');
    Route::get('retail-transaction', 'TopupHistoryController@retailHistory')->name('retailHistory');
    Route::get('qris-transaction', 'TopupHistoryController@qrisHistory')->name('qrisHistory');
    Route::get('bank-transaction', 'TopupHistoryController@bankDepoHistory')->name('bankDepoHistory');

    
});

Route::group(['middleware'=> ['auth', 'lang']], function () {
    Route::post('/upload-profile-image', 'user\ProfileController@uploadProfileImage')->name('uploadProfileImage');
    Route::post('/user-profile-update', 'user\ProfileController@userProfileUpdate')->name('userProfileUpdate');
    Route::post('/phone-verify', 'user\ProfileController@phoneVerify')->name('phoneVerify');
    Route::get('/send-sms-for-verification', 'user\ProfileController@sendSMS')->name('sendSMS');
    Route::post('change-password-save', 'user\ProfileController@changePasswordSave')->name('changePasswordSave');
});
