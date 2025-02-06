<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\RestaurantPayment;


class PaymentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pre=20/100;
        $restaurant_id = auth()->user()->restaurant()->first()->id;
        $withdrwan=DB::table('restaurant_payments')->where('restaurant_id',$restaurant_id)->where('status','paid')->sum('payout_amount');
        $Total_Earning = DB::table('completed_orders')->where('restaurant_id',$restaurant_id)->sum('total');
        $total=$Total_Earning-$pre * $Total_Earning;
        $today_earning = DB::table('completed_orders')->where('restaurant_id',$restaurant_id)->where('created_at',Now()->day)->sum('total');
        $this_week_earning = DB::table('completed_orders')->where('restaurant_id',$restaurant_id)->where('created_at','>', Now()->day-7)->sum('total');
        $history=RestaurantPayment::where('restaurant_id',$restaurant_id)->get();
        //dd($this_week_earning);
        return view('restaurant.payment_history.index',compact('history','Total_Earning','pre','total','this_week_earning','today_earning', 'withdrwan'));
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
        $payment = new RestaurantPayment;

        $payment->restaurant_id = $request->restaurant_id;
        $payment->payout_amount = $request->amount;
        $payment->save();

        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'Request Sent successfully!';
        return redirect()->back()->with('alert', $alert);
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
