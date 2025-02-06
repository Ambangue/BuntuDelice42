<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['restaurant_id','name','discount','start_date','end_date'];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
