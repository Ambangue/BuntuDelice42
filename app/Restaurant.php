<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable=['user_id','name','email','password','city','address','phone','description','user_name','slogan','logo','cover_image',
        'latitude','longitude','min_order','avg_delivery_time',
        'services','account_name','account_number','bank_name','branch_name'];
    public function cuisines()
    {
        return $this->belongsToMany(Cuisine::class);
    }
    
    /**
     * Check if resturant has cuisines.
     *
     * @return bool
     */
    public function hasCuisine($cuisineId)
    {
        return in_array($cuisineId, $this->cuisines->pluck('id')->toArray());
    }
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function payments()
    {
        return $this->hasMany(RestaurantPayment::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function working_hours()
    {
        return $this->hasMany(WorkingHour::class);
    }
     public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
     public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
