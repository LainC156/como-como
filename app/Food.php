<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Food extends Model
{
    use QueryCacheable;

    public $cacheFor = 3600; // cache time, in seconds

    protected $fillable = [
        'name', 'group', 'subgroup', 'kcal', 'kj', 'water', 'dietary_fiber', 'carbohydrates', 'proteins', 'total_lipids', 'saturated_lipids', 'monosaturated_lipids', 'polysaturated_lipids', 'cholesterol', 'calcium', 'phosphorus', 'iron', 'magnesium', 'sodium', 'potassium', 'zinc', 'potassium', 'zinc', 'vitamin_a', 'ascorbic_acid', 'thiamin', 'rivoflavin', 'niacin', 'pyridoxine', 'folic_acid', 'cobalamin', 'edible_percentage',
    ];
}
