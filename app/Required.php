<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Required extends Model
{
    protected $table="requireds";
    protected $fillable=['title','product_id','add_on_title_id','price'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function carts(){
        return $this->belongsToMany(Cart::class);
    }
}
