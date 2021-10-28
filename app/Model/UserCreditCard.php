<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserCreditCard extends Model
{
    protected $table = 'users_cc';
    protected $fillable = [
        'user_id',
        'card_number',
        'card_exp_month',
        'card_exp_year',
        'card_cvn',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
