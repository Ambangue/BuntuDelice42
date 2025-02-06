<?php

namespace App\Http\Controllers\admin;

use App\Charge;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $charge = Charge::find(1);
        
        return view('admin.charge.index',compact('charge'));
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
        $request->validate([
            'service_fee' => 'required|string|max:191',
            'tax' => 'required|string|max:191',
            'delivery_fee' => 'required|string|max:191',
        ]);
       // dd($request);
        Charge::create($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'Charges Created Successfully';
        return redirect()->route('charge.index')->with('alert', $alert);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function show(Charge $charge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function edit(Charge $charge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Charge $charge)
    {
        //dd($request,$charge);
        $request->validate([
            'service_fee' => 'required|string|max:191',
            'tax' => 'required|string|max:191',
            'delivery_fee' => 'required|string|max:191',
        ]);
         $charge->update($request->all());
        // $affected = DB::table('charges')
        //       ->where('id', 1)
        //       ->update(['service_fee' => $request->service_fee, 'tax'=>$request->tax, 'delivery_fee'=>$request->delivery_fee,'pickup_fee'=>$request->pickup_fee]);
        //$charge->update($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'Charges Updated Successfully';
        return redirect()->route('charge.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Charge  $charge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Charge $charge)
    {
        $charge->delete();
        $alert['type'] = 'success';
        $alert['message'] = 'Charges Deleted Successfully';
        return redirect()->route('charge.index')->with('alert', $alert);
    }
}
