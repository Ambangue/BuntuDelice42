<?php

namespace App\Http\Controllers\admin;

use App\Driver;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $drivers = Driver::all();
        return view('admin.driver.index')->with('drivers', $drivers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.driver.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
                'name'=>'required',
                'email' => 'required|email|max:255|unique:drivers',
                'password' => 'required',
                'phone'=>'required|unique:drivers',
                'address'=>'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
                'account_name'=>'nullable',
                'account_number' => 'required',
                'bank_name'=>'required',
                'branch_name'=>'required',
                'branch_address'=>'required',
                'licence_image' => 'required|image|mimes:jpeg,png,jpg',

        ]);
        $request['password'] = bcrypt($request->password);
        $alert = [];
        
        $driver=Driver::create($request->all());


        $licence_image = $request->licence_image;
        $image = $request->image;
        $destination = 'images/driver_images';
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
            $driver->image = $filename;
            $driver->save();
        }
        
        $destination = 'images/driver_images';
        if ($request->hasFile('licence_image')) {
            $file = strtolower(
                pathinfo($licence_image->getClientOriginalName(), PATHINFO_FILENAME)
                . '-'
                . uniqid()
                . '.'
                . $licence_image->getClientOriginalExtension()
            );
            $licence_image->move($destination, $file);
            str_replace(" ", "-", $file);
            $driver->licence_image = $file;
            $driver->save();
        }
        $alert['type'] = 'success';
        $alert['message'] = 'driver Created Successfully';
        return redirect()->route('driver.index')->with('alert', $alert);
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Driver $driver)
    {
        return view('admin.driver.edit')->with('driver', $driver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Driver $driver)
    {
        $request->validate([
        'name'=>'required',
                
                'address'=>'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
                'account_name'=>'nullable',
                'account_number' => 'required',
                'bank_name'=>'required',
                'branch_name'=>'required',
                'branch_address'=>'required',
                'licence_image' => 'image|mimes:jpeg,png,jpg',

        ]);
        if($request->password !='')
        {
           $request['password'] = bcrypt($request->password); 
        }
        else{
            $request['password'] = $driver->password;
        }
        
        $alert = [];
        if ($request->email)
             if ($request->email != $driver->email) {
                 $request->validate([
                     'email' => 'required|email|max:255|unique:drivers',
                 ]);
             } else
                 $request->request->remove('email');
         if ($request->phone)
             if ($request->phone != $driver->phone) {
                 $request->validate([
                     'phone' => 'required|string|max:191|unique:drivers',
                 ]);
             } else
                 $request->request->remove('phone');
        
        $driver->update($request->all());
        
        $image = $request->image;
        $destination = 'images/driver_images';
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
            $driver->image = $filename;
            $driver->update();
        }
        else{
            $driver->image = $driver->image;
            $driver->update();
        }
        
        
        $licence_image = $request->licence_image;
        $destination = 'images/driver_images';
        if ($request->hasFile('licence_image')) {
            $filename = strtolower(
                pathinfo($licence_image->getClientOriginalName(), PATHINFO_FILENAME)
                . '-'
                . uniqid()
                . '.'
                . $licence_image->getClientOriginalExtension()
            );
            $licence_image->move($destination, $filename);
            str_replace(" ", "-", $filename);
            $driver->licence_image = $filename;
            $driver->update();
        }
        else{
            $driver->licence_image = $driver->licence_image;
            $driver->update();
        }
        
        $alert['type'] = 'success';
        $alert['message'] = 'driver updated Successfully';
        return redirect()->route('driver.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Driver $driver)
    {
        if ($driver->image)
            Storage::delete($driver->cover_image);
        $driver->delete();
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'driver successfully deleted';

        return redirect()->route('driver.index')->with('alert', $alert);
    }
    public function change_driver_active_status(Driver $driver)
    {
        if ($driver->approved)
            $driver->approved = false;
        else
            $driver->approved = true;
        $driver->save();
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'driver status successfully updated';
        return redirect()->back()->with('alert', $alert);
    }
    public function get_hourly_pay(Driver $driver)
    {
        return view('admin.driver.set_hourly_pay')->with('driver', $driver);

    }
    public function set_hourly_pay(Driver $driver , Request $request)
    {
        $request->validate([
            'hourly_pay'=>'required',
        ]);
        $pay=$request->hourly_pay;
        Driver::where('id',$driver->id)->update(array('hourly_pay'=>$pay));
        $alert['type'] = 'success';
        $alert['message'] = 'driver  successfully updated';
        return redirect()->route('driver.index')->with('alert', $alert);
    }
}
