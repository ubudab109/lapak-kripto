<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class WithdrawBalanceUser extends Model
{
    protected $table = 'withdraw_user';
    protected $fillable = [
        'transaction_id',
        'user_id',
        'bank_id',
        'total_wd',
        'status',
        'admin_approval_picture',
        'dollar_amount',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bankUser()
    {
        return $this->belongsTo(UserBankInfo::class, 'bank_id', 'id');
    }
}
