<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $table='user_address';
    protected $fillable=['title','user_id','building_no','street_no','area','floor','latitude','longitude','complete_address'];
   
}
