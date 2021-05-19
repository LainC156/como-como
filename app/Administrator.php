<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Administrator extends Model
{
    use QueryCacheable;

    public $cacheFor = 3600; // cache time, in seconds
}
