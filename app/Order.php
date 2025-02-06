<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['restaurant_id','user_id','product_id','qty','price','latitude','longitude','offer_discount','tax','delivery_charges','sub_total','total','admin_commission','restaurant_commission','driver_tip','delivery_address','scheduled_date','ordered_time','delivered_time'];
    
   public function restaurant()
   {
       return $this->belongsTo(Restaurant::class);
   }
   public function product()
   {
       return $this->belongsTo(Product::class);
   }
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
