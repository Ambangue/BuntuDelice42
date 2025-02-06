<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public static function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' .$search. '%');
    }
}
