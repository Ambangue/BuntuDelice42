<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
protected $fillable=[
'driver_id',
'user_id',
'rating',
'reviews',
];
}
