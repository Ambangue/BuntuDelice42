<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable=['driver_id','model','number','license_number','license_image','color'];
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
