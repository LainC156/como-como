<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Menu extends Model
{
    use QueryCacheable;

    public $cacheFor = 3600; // cache time, in seconds

    protected $fillable = [
        'name', 'description', 'user_id', 'food_id', 'food_weight', 'kind_of_food', 'kind_of_menu',
        'status',
    ];
}
