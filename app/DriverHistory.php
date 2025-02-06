<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverHistory extends Model
{
    protected $fillable=['driver_id','start_date','end_date'];
}
