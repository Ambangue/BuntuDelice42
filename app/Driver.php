<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Driver extends Model
{
     use Notifiable,HasApiTokens;
    use Authenticatable;
    protected $fillable=['restaurant_id','name','hourly_pay','email','cnic','password','phone','image','address','account_name','account_number','bank_name','branch_name','branch_address','licence_image','hours','vehicle','days'];
    
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function payouts()
    {
        return $this->hasMany(DriverPayment::class);
    }
}
