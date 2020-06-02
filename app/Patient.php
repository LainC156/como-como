<?php

namespace App;

use App\User;
use App\Nutritionist;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /* relation with User */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /* relation with Nutritionist */
    public function nutriologist() {
        return $this->belongsTo(Nutriologist::class);
    }
}
