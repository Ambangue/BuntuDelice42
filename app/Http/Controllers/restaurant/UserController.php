<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $restaurant=User::where('type','restaurant')->first();
        return view('restaurant.profile')->with('restaurant',$restaurant);
    }
    public function profile_update(Request $request)
    {

        $request->validate([
            'name'=>'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);
        $admin=User::where('type','admin')->first();
        if ($request->phone)
            if ($request->phone != $admin->phone) {
                $request->validate([
                    'phone' => 'required|string|max:191|unique:users',
                ]);
            } else
                $request->request->remove('phone');
        if ($request->old_password)
            if (password_verify($request->old_password, $admin->password)) {
                $request->validate([
                    'password' => 'required|string|min:6|max:191'
                ]);
                $request['password'] = bcrypt($request->password);
            } else
                $request->request->remove('password');
        $admin->update($request->all());
        $image = $request->image;
        $destination = 'images/user_images';
        if ($request->hasFile('image')) {
            $filename = strtolower(
                pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)
                . '-'
                . uniqid()
                . '.'
                . $image->getClientOriginalExtension()
            );
            $image->move($destination, $filename);
            str_replace(" ", "-", $filename);
            $admin->image = $filename;
            $admin->update();
        }
        $alert['type'] = 'success';
        $alert['message'] = 'Profile updated Successfully';
        return redirect()->route('profile')->with('alert', $alert);

    }
}
