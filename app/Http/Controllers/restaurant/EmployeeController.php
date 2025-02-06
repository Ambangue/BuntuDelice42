<?php

namespace App\Http\Controllers\restaurant;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $name=auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();
        $employees=$restaurant->employees;
        return view('restaurant.employee.index')->with('employees', $employees);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('restaurant.employee.create');
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
            'name' => 'required|string|max:191',
            'email'=>'required|string|unique:employees',
            'phone'=>'required|string|unique:employees',
            'password'=>'required|string|min:6|max:191',
            'image'=>'nullable|image|mimes:jpeg,png,jpg',
            'address'=>'required|string',
        ]);
        $request['password'] = bcrypt($request->password);
        $alert = [];
        $name=auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();
        $employee=$restaurant->employees()->create($request->all());
        $image = $request->image;
        $destination = 'images/employee_images';
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
            $employee->image = $filename;
            $employee->save();
        }
        $alert['type'] = 'success';
        $alert['message'] = 'employee Created Successfully';
        return redirect()->route('employee.index')->with('alert', $alert);
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
    public function edit(Employee $employee)
    {
        return view('restaurant.employee.edit')->with('employee', $employee);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'image'=>'nullable|image|mimes:jpeg,png,jpg',
            'address'=>'required|string',
        ]);
        if ($request->phone)
            if ($request->phone != $employee->phone) {
                $request->validate([
                    'phone' => 'required|string|max:191|unique:employees',
                ]);
            } else
                $request->request->remove('phone');
        if ($request->old_password)
            if (password_verify($request->old_password, $employee->password)) {
                $request->validate([
                    'password' => 'required|string|min:6|max:191'
                ]);
                $request['password'] = bcrypt($request->password);
            } else
                $request->request->remove('password');
        $employee->update($request->all());
        $alert = [];
        $image = $request->image;
        $destination = 'images/employee_images';
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
            $employee->image = $filename;
            $employee->update();
        }
        $alert['type'] = 'success';
        $alert['message'] = 'employee Updated Successfully';
        return redirect()->route('employee.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Employee $employee)
    {
        if ($employee->image)
            Storage::delete($employee->image);
        $employee->delete();
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'employee successfully deleted';

        return redirect()->route('employee.index')->with('alert', $alert);
    }
}
