<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'trial_status', 'active', 'payment_status', 'recurring_id', 'price', 'currency_unit', 'payment_method', 'payment_date', 'expiration_date'
    ];

    protected $dates = [
        'expiration_date'  => 'date:d-m-y',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
