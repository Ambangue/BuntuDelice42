<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table="contactus";
    protected $fillable=['name','email','phone','message'];

}
