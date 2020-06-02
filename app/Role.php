<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Relation with User model
     *
     */
    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
