<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function delivery_boundary()
    {
        $name=auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();
        return view('restaurant.delivery_boundary')->with('restaurant', $restaurant);
    }
}
