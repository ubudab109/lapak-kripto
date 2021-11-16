<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TopupTransaction extends Model
{
    protected $table = 'topup_transaction';

    protected $fillable = [
        'user_id',
        'external_id',
        'dollar_topup',
        'total_topup',
        'status',
        'payment_type',
        'payment_channels',
        'payment_merchant',
        'payout_web_link',
        'payout_mobile_link',
        'virtual_account_number',
        'payment_code',
        'media',
        'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
