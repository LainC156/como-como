<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name', 'description', 'user_id', 'food_id', 'food_weight', 'kind_of_food', 'kind_of_menu',
        'status',
    ];
}
