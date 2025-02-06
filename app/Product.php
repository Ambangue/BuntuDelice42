<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=['restaurant_id','category_id','name','image',
        'price','discount_price','description','size'
    ];

    public function extras()
    {
        return $this->hasMany(Extra::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function restaurants()
    {
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }
    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
