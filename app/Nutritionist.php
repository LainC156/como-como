<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nutritionist extends Model
{
    public function patient() {
        return $this->hasMany(Patient::class);
    }
}
