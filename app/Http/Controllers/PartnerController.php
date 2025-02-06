<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PartnerController extends Controller
{

    public function partner()
    {
        return view('frontend.restaurant');
    }
    
    public function partnerRegistration(Request $request)
    {
   $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|unique:restaurants',
            'password' => 'required|string|min:6|max:191',
            'slogan' => 'required|string|max:191',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'city' => 'required|string|max:191',
             'address' => 'required|string|max:191',
             'phone' => 'required|string|max:191|unique:restaurants',
             'account_name'=>'required|string',
             'account_number'=>'required|string',
             'bank_name'=>'required',
             'branch_number'=>'required',
        ]);
         //dd($request->all());
        $request['password'] = bcrypt($request->password);
        $request['services'] = 'both';
        $request['type'] = 'restaurant';
        $alert = [];
        $user = User::create($request->all());
        if ($user->type === 'restaurant'){
            $restaurant = $user->restaurant()->create($request->all());
            
        }
        $cover_image = $request->cover_image;
        $logo = $request->logo;
        $destination = 'images/restaurant_images';
        if ($request->hasFile('cover_image')) {
            $filename = strtolower(
                pathinfo($cover_image->getClientOriginalName(), PATHINFO_FILENAME)
                . '-'
                . uniqid()
                . '.'
                . $cover_image->getClientOriginalExtension()
            );
            $cover_image->move($destination, $filename);
            str_replace(" ", "-", $filename);
            $restaurant->cover_image = $filename;
            $restaurant->save();
        }
        if ($request->hasFile('logo')) {
            $file = strtolower(
                pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME)
                . '-'
                . uniqid()
                . '.'
                . $logo->getClientOriginalExtension()
            );
            $logo->move($destination, $file);
            str_replace(" ", "-", $file);
            $restaurant->logo = $file;
            $restaurant->save();
        }
        $data = array(
            'name' => $restaurant->name,
            'email' => $restaurant->email,
        );
            $message="Dear User, Your signup was successfully received. We value you as our customer, and we welcome your order requests, as You Shop, We Drop. It is our aim to fill as many orders as we possible can and at the same time to provide exceptional customer service. So during the process, feel free to let us know how we are doing, and where you would like to see us improve. Thank you for signing up and being apart of The Drop. Regards, The Drop Team";
            //sending email
            Mail::to($request->email)->send(new RegisterEmail($data));
        $alert['type'] = 'success';
        $alert['message'] = 'Restaurant Account Created Successfully!';
        return redirect()->back()->with('alert', $alert);
    }
   
}
