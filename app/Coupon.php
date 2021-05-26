<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Coupon extends Model
{
    use QueryCacheable;

    public $cacheFor = 3600; // cache time, in seconds

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identificator', 'name', 'description', 'code', 'used', 'days', 'user_id', 'account_type',
        'created_at', 'updated_at',
    ];
}
