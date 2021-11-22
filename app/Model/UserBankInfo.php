<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserBankInfo extends Model
{
    protected $table = 'user_bank_info';
    protected $fillable = [
        'user_id',
        'account_holder_name',
        'account_holder_address',
        'bank_name',
        'bank_address',
        'country',
        'swift_code',
        'iban',
        'note',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function withdrawHistory()
    {
        return $this->hasMany(WithdrawBalanceUser::class, 'user_id', 'id');
    }
}
