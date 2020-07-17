<?php

namespace App;

use App\User;
use App\Nutritionist;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Patient extends Model
{
    use QueryCacheable;

    public $cacheFor = 3600; // cache time, in seconds

    /* relation with User */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /* relation with Nutritionist */
    public function nutriologist() {
        return $this->belongsTo(Nutriologist::class);
    }
}
