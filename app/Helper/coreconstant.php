<?php


// User Role Type

const USER_ROLE_SUPERADMIN = 1;
const USER_ROLE_USER = 2;
const USER_ROLE_ADMIN = 3;



// Status
const STATUS_PENDING = 0;
const STATUS_ACCEPTED = 1;
const STATUS_REJECTED = 2;
const STATUS_SUCCESS = 1;
const STATUS_SUSPENDED = 4;
const STATUS_DELETED = 5;
const STATUS_ALL = 6;
const STATUS_COMPLETED = "COMPLETED";
const STATUS_SUCCEEDED = "SUCCEEDED";


const STATUS_ACTIVE = 1;
const STATUS_DEACTIVE = 0;

const BTC = 1;
const CARD = 2;
const PAYPAL = 3;
const BANK_DEPOSIT = 4;
const XENDIT = 5;
const BALANCE_IDR = 6;

const VA_CHANNELS = 1;
const EWALLET_CHANNELS = 2;
const RETAIL_CHANNELS = 3;
const QRIS_CHANNELS = 4;
const CC_CHANNELS = 5;

const ALFAMART_QR_TEST = 'https://retail-outlet-barcode-dev.xendit.co/alfamart';
const ALFAMART_QR_LIVE = 'https://retail-outlet-barcode.xendit.co/alfamart';


const  SEND_FEES_FIXED  = 1;
const  SEND_FEES_PERCENTAGE  = 2;

const XENDIT_KEY_DEVELOPMENT = 'xnd_development_Kihevv2GDcxR0SP8smz74kVN75LEXGfFE65L6Ks2hXEbJ6oRaXngTMTWwMlAWq';
const XENDIT_KEY_PRODUCTION = 'key here';
const XENDIT_CALLBACK_TOKEN = '9arGkpx5OWS0Ztqv1KxQJkdmNZlnQrrl0V6OpC8t73jVCdXe';

//Varification send Type
const Mail = 1;
const PHONE = 2;


const IOS = 1;
const ANDROIND = 2;

// User Activity
const ADDRESS_TYPE_EXTERNAL = 1;
const ADDRESS_TYPE_INTERNAL = 2;

const IMG_PATH = 'uploaded_file/uploads/';
const IMG_VIEW_PATH = 'uploaded_file/uploads/';

const IMG_USER_PATH = 'uploaded_file/users/';
const IMG_SLEEP_PATH = 'uploaded_file/sleep/';
const IMG_USER_VIEW_PATH = 'uploaded_file/users/';
const IMG_SLEEP_VIEW_PATH = 'uploaded_file/sleep/';
const IMG_USER_VERIFICATION_PATH = 'users/verifications/';
const IMG_TOPUP_PATH = 'uploaded_file/topup/';

const DISCOUNT_TYPE_FIXED = 1;
const DISCOUNT_TYPE_PERCENTAGE = 2;

const DEPOSIT = 1;
const WITHDRAWAL = 2;

const PAYMENT_TYPE_BTC = 1;
const PAYMENT_TYPE_USD = 2;
const PAYMENT_TYPE_ETH = 3;
const PAYMENT_TYPE_LTC = 4;
const PAYMENT_TYPE_LTCT = 5;
const PAYMENT_TYPE_DOGE = 6;
const PAYMENT_TYPE_BCH = 7;
const PAYMENT_TYPE_DASH = 8;

// plan bonus
const PLAN_BONUS_TYPE_FIXED = 1;
const PLAN_BONUS_TYPE_PERCENTAGE = 2;

//
const CREDIT = 1;
const DEBIT = 2;

//User Activity
const USER_ACTIVITY_LOGIN=1;
const USER_ACTIVITY_MOVE_COIN=2;
const USER_ACTIVITY_WITHDRAWAL=3;
const USER_ACTIVITY_CREATE_WALLET=4;
const USER_ACTIVITY_CREATE_ADDRESS=5;
const USER_ACTIVITY_MAKE_PRIMARY_WALLET=6;
const USER_ACTIVITY_PROFILE_IMAGE_UPLOAD=7;
const USER_ACTIVITY_UPDATE_PASSWORD=8;
const USER_ACTIVITY_UPDATE_EMAIL=12;
const USER_ACTIVITY_ACTIVE=9;
const USER_ACTIVITY_HALF_ACTIVE=10;
const USER_ACTIVITY_INACTIVE=11;
const USER_ACTIVITY_LOGOUT=12;
const USER_ACTIVITY_PROFILE_UPDATE=13;



