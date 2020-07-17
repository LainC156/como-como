<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Role extends Model
{
    use QueryCacheable;

    public $cacheFor = 3600; // cache time, in seconds
    /**
     * Relation with User model
     *
     */
    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
