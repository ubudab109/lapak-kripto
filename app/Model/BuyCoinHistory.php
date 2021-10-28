<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BuyCoinHistory extends Model
{
    protected $fillable = [
        'address',
        'type',
        'confirmations',
        'user_id',
        'coin',
        'btc',
        'transaction_id',
        'admin_confirmation',
        'bank_sleep',
        'bank_id',
        'status',
        'coin_type',
        'doller'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id','id');
    }
}
