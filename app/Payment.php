<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Payment extends Model
{
    use QueryCacheable;

    public $cacheFor = 3600; // cache time, in seconds

    protected $fillable = ['user_id', 'trial_status', 'active', 'payment_status', 'recurring_id', 'amount', 'currency_unit', 'payment_method', 'current_date', 'expiration_date'
    ];

    protected $dates = [
        'expiration_date'  => 'date:d-m-y',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
