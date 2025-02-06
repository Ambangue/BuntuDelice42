<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable=[
'restaurant_id',
'user_id',
'rating',
'reviews',
];
    public function restaurants()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
