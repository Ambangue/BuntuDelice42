<?php

namespace App\Http\Controllers\admin;

use App\Driver;
use App\Http\Controllers\Controller;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('admin.vehicle.index')->with('vehicles', $vehicles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.vehicle.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|integer,',
            'model' => 'required|string|',
            'number' => 'required|string|unique:vehicles',
            'color' => 'required|string',
            'license_image' => 'required|image|mimes:jpeg,png,jpg',
            'license_number' => 'required|string|unique:vehicles'

        ]);
        $alert = [];
        $driver = Driver::find($request->driver_id);
        if ($driver->approved == true) {
            $vehicle = $driver->vehicle()->create($request->all());
            $license_image = $request->license_image;
            $destination = 'images/vehicle_images';
            if ($request->hasFile('license_image')) {
                $filename = strtolower(
                    pathinfo($license_image->getClientOriginalName(), PATHINFO_FILENAME)
                    . '-'
                    . uniqid()
                    . '.'
                    . $license_image->getClientOriginalExtension()
                );
                $license_image->move($destination, $filename);
                str_replace(" ", "-", $filename);
                $vehicle->license_image = $filename;
                $vehicle->save();
            }
            $alert['type'] = 'success';
            $alert['message'] = 'vehicle Created Successfully';
        }
        $alert['type'] = 'danger';
        $alert['message'] = 'you are not allowed to add ';
        return redirect()->route('vehicle.index')->with('alert', $alert);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public
    function edit(Vehicle $vehicle)
    {
        return view('admin.vehicle.edit')->with('vehicle', $vehicle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'driver_id' => 'required|integer,',
            'model' => 'required|string|',
            'number' => 'required|string|unique:vehicles',
            'color' => 'required|string',
            'license_image' => 'required|image|mimes:jpeg,png,jpg',
            'license_number' => 'required|string|unique:vehicles'
        ]);
        $alert = [];
        $vehicle->update($request->all());
        $license_image = $request->license_image;
        $destination = 'images/vehicle_images';
        if ($request->hasFile('license_image')) {
            $filename = strtolower(
                pathinfo($license_image->getClientOriginalName(), PATHINFO_FILENAME)
                . '-'
                . uniqid()
                . '.'
                . $license_image->getClientOriginalExtension()
            );
            $license_image->move($destination, $filename);
            str_replace(" ", "-", $filename);
            $vehicle->license_image = $filename;
            $vehicle->update();
        }
        $alert['type'] = 'success';
        $alert['message'] = 'vehicle updated Successfully';
        return redirect()->route('vehicle.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    function destroy(Vehicle $vehicle)
    {
        if ($vehicle->license_image)
            Storage::delete($vehicle->license_image);
        $vehicle->delete();
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'vehicle successfully deleted';

        return redirect()->route('vehicle.index')->with('alert', $alert);
    }
}
