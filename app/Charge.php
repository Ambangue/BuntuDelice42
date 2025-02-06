<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable=['delivery_charges','tax','service_charges','pickup_fee'];
    
}
