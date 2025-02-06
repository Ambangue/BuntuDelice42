<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddOnTitle extends Model
{
    protected $table="add_ons_titles";
    protected $fillable=['title','product_id','restaurant_id'];
    public function requireds()
    {
        return $this->hasMany(Required::class);
    }

    public function optionals()
    {
        return $this->hasMany(Optional::class);
    }
}
