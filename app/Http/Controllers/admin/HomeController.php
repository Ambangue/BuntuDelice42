<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    public function home()
    {
        return view('admin.home');
    }
    
    public function totalPro()
    {
        $products=Product::all();
        return view('admin.product.index',compact('products'));
    }
}
