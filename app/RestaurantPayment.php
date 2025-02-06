<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantPayment extends Model
{
    protected $fillable=['restaurant_id','payout_amount','transaction_id','status'

    ];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
