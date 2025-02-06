<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        if (!auth()->check())
            return redirect('login');
        elseif ( auth()->user()->type === 'admin')
            return redirect('/admin');
        else if (auth()->user()->type === 'restaurant')
            return redirect('/restaurant');
        else
            return redirect('login');
    }
    
    public function index()
    {
        if (!auth()->check())
            return redirect('/');
        elseif ( auth()->user()->type === 'user')
         return redirect('/cart');
         elseif (auth()->check())
        return redirect('/');
    }
}
