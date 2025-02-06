<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login_view()
    {
        if (auth()->check())
            return redirect('/');
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:191',
            'password' => 'required|string|max:191',
        ]);
        $user = User::where('email',$request->email)->first();
        if (!$user) {
            $alert['type'] = 'danger';
            $alert['heading'] = 'login failed';
            $alert['message'] = 'invalid email or password';
            return redirect()->back()->with('alert', $alert);
        }
        if (!auth()->loginUsingId((password_verify($request->password, $user->password)) ? $user->id : 0)) {
            $alert['type'] = 'danger';
            $alert['heading'] = 'login failed';
            $alert['message'] = 'invalid email or password';
            return redirect()->back()->with('alert', $alert);
        }
        if (auth()->check() and auth()->user()->type === 'admin')
        return redirect('/admin');
        if (auth()->check() and auth()->user()->type === 'restaurant')
        return redirect('/restaurant');
        if (auth()->check() and auth()->user()->type === 'user')
        return redirect('/');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('login');
    }
}
