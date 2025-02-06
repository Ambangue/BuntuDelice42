<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverToken extends Model
{
    protected $table='driver_tokens';
    protected $fillable=['driver_id','device_tokens'];
}
