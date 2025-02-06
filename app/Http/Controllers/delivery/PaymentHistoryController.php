<?php

namespace App\Http\Controllers\delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PaymentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant_id = auth()->user()->restaurant()->first()->id;
        $Total_Earning = DB::table('orders')->where('restaurant_id',$restaurant_id)->sum('total');
        $today_earning = DB::table('orders')->where('restaurant_id',$restaurant_id)->where('created_at',Now())->sum('total');
        $this_week_earning = DB::table('orders')->where('restaurant_id',$restaurant_id)->where('created_at','>', Now()->day-7)->sum('total');
        //dd($this_week_earning);
        return view('restaurant.payment_history.index',compact('Total_Earning','this_week_earning','today_earning'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant_id = auth()->user()->restaurant()->first()->id;
        $Total_Earning = DB::table('orders')->where('restaurant_id',$restaurant_id)->sum('total');
        $today_earning = DB::table('orders')->where('restaurant_id',$restaurant_id)->where('created_at',Now()->day)->sum('total');
        $this_week_earning = DB::table('orders')->where('restaurant_id',$restaurant_id)->where('created_at','>', Now()->day-7)->sum('total');
        //dd($this_week_earning);
        return view('restaurant.payment_history.history',compact('Total_Earning','this_week_earning','today_earning'));
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
}
