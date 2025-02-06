<?php

namespace App\Http\Controllers\restaurant;

use App\Voucher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$vouchers = DB::table('vouchers')->where('restaurant_id',auth()->user()->restaurant->id)->get();
        // dd($vouchers);
        return view('restaurant.vouchers.index',compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.vouchers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
        	'name'=>'required',
        	'discount'=>'required',
        	'start_date'=>'required',
        	'end_date'=>'required',
        ]);
        $request['restaurant_id'] = auth()->user()->restaurant->id;
        Voucher::create($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'Voucher Created Successfully';
        return redirect()->route('voucher.index')->with('alert', $alert);
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
    public function edit(Voucher $voucher)
    {
        return view('restaurant.vouchers.edit',compact('voucher'));
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
         // dd($request,$id);
        $request->validate([
        	'name'=>'required',
        	'discount'=>'required',
        	'start_date'=>'required',
        	'end_date'=>'required',
        ]);
        $request['restaurant_id'] = auth()->user()->restaurant->id;
        DB::table('vouchers')->where('id',$id)
        ->update([
        	'name' => $request->name,
        	'discount'=>$request->discount,
        	'start_date'=>$request->start_date,
        	'end_date'=>$request->end_date
        ]);
        $alert['type'] = 'success';
        $alert['message'] = 'Voucher Updated Successfully';
        return redirect()->route('voucher.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        DB::table('vouchers')->where('id',$id)->delete();
        $alert['type'] = 'success';
        $alert['message'] = 'Voucher Deleted Successfully';
        return redirect()->route('voucher.index')->with('alert', $alert);
    }
}
