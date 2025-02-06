<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuisine extends Model
{
    protected $fillable=['name','image'];

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class);
    }
}
