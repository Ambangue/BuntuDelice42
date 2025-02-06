<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=['restaurant_id','user_id','product_id','product_name','qty','price','description'];


    public function optionals()
   {
       return $this->belongsToMany(Optional::class);
   }
    /**
     * Check if cart has optionals.
     *
     * @return bool
     */
    public function hasOptional($optionalId)
    {
        return in_array($optionalId, $this->optionals->pluck('id')->toArray());
    }


    public function requireds()
   {
       return $this->belongsToMany(Required::class);
   }
    /**
     * Check if cart has requrieds.
     *
     * @return bool
     */
    public function hasRequired($requiredId)
    {
        return in_array($requiredId, $this->requireds->pluck('id')->toArray());
    }

    public function products()
   {
       return $this->hasMany(Product::class);
   }

   public function restaurants()
   {
       return $this->belongsToMany(Restaurant::class);
   }
}
