<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users=User::where('type','user')->get();
        return view('admin.user.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function change_block_status(User $user)
    {
        if ($user->blocked)
            $user->blocked = false;
        else
            $user->blocked = true;

        $user->save();
        return redirect()->back();
    }
    public function profile()
    {
        $id=auth()->user()->id;
        $admin=User::where('id',$id)->where('type','admin')->first();
        return view('admin.profile')->with('admin',$admin);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    // public function destroy(user $user)
    // {
    //     if ($driver->image)
    //         Storage::delete($user->cover_image);
    //     $driver->delete();
    //     $alert = [];
    //     $alert['type'] = 'success';
    //     $alert['message'] = 'user successfully deleted';

    //     return redirect()->route('user.index')->with('alert', $alert);
    // }
    // public function change_driver_active_status(Driver $user)
    // {
    //     if ($user->approved)
    //         $user->approved = false;
    //     else
    //         $user->approved = true;
    //     $user->save();
    //     $alert = [];
    //     $alert['type'] = 'success';
    //     $alert['message'] = 'user status successfully updated';
    //     return redirect()->back()->with('alert', $alert);
    // }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function passwordUpdate(Request $request)
    {

        $request->validate([
                'current_password'=>'required',
                'new_password' => 'required',
        ]);
            
        $data=$request->all();
        $current_password=$data['current_password'];
        $email_login=auth()->user()->email;
        //dd($email_login);
        $check_password=User::where(['email'=>$email_login])->first();
        if(Hash::check($current_password,$check_password->password)){
            $password=bcrypt($data['new_password']);
            User::where('email',$email_login)->update(['password'=>$password]);
            
        $alert['type'] = 'success';
        $alert['message'] = 'Profile updated Successfully';
        return redirect()->back()->with('alert', $alert);
            
        }else{
            $alert['type'] = 'success';
        $alert['message'] = 'Incorrect Current Password';
        return redirect()->back()->with('alert', $alert);
        }
        

    }
}
