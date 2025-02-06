<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function extras()
    {
        return $this->hasMany(Extra::class);
    }
}
