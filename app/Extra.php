<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function types()
    {
        return $this->belongsTo(Type::class);
    }
}
