<?php

namespace App\Http\Controllers\admin;

use App\Driver;
use App\Http\Controllers\Controller;
use App\Order;
use App\Restaurant;
use Illuminate\Http\Request;
use DB;

class PayoutController extends Controller
{
    public function restaurant_payout()
    {
        
        $requests=DB::table('restaurants')
        ->join('restaurant_payments', 'restaurants.id', '=', 'restaurant_payments.restaurant_id')
        ->select('restaurant_payments.id as request_id', 'restaurant_payments.status', 'restaurant_payments.payout_amount', 'restaurant_payments.created_at as date', 'restaurants.phone', 'restaurants.name')
        ->where('restaurant_payments.status','pending')
        ->get();
        
        $history=DB::table('restaurants')
        ->join('restaurant_payments', 'restaurants.id', '=', 'restaurant_payments.restaurant_id')
        ->select('restaurant_payments.id as request_id', 'restaurant_payments.status', 'restaurant_payments.payout_amount', 'restaurant_payments.transaction_id',  'restaurant_payments.created_at as date', 'restaurants.phone', 'restaurants.email','restaurants.address', 'restaurants.name')
        ->where('restaurant_payments.status','paid')
        ->get();
        
        return view('admin.payouts.restaurant_payout', compact('requests', 'history'));
    }

    public function driver_payout()
    {

        $requests=DB::table('drivers')
        ->join('driver_payments', 'drivers.id', '=', 'driver_payments.driver_id')
        ->select('driver_payments.id as request_id', 'driver_payments.status', 'driver_payments.payout_amount', 'driver_payments.created_at as date', 'drivers.phone', 'drivers.name')
        ->where('driver_payments.status','pending')
        ->get();
        
        $history=DB::table('drivers')
        ->join('driver_payments', 'drivers.id', '=', 'driver_payments.driver_id')
        ->select('driver_payments.id as request_id', 'driver_payments.transaction_id', 'driver_payments.status', 'driver_payments.payout_amount', 'driver_payments.created_at as date', 'drivers.phone', 'drivers.name', 'drivers.address', 'drivers.email')
        ->where('driver_payments.status','paid')
        ->get();
        return view('admin.payouts.driver_payout', compact('requests', 'history'));
    }

    public function restaurant_pay(Request $request)
    {
        $affected = DB::table('restaurant_payments')
        ->where('id', $request->request_id)
        ->update(['transaction_id' => $request->transaction_id, 'status' => 'paid']);

        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'Request Sent successfully!';
        return redirect()->back()->with('alert', $alert);
    }
    
     public function driver_pay(Request $request)
    {
        $affected = DB::table('driver_payments')
        ->where('id', $request->request_id)
        ->update(['transaction_id' => $request->transaction_id, 'status' => 'paid']);

        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'Request Sent successfully!';
        return redirect()->back()->with('alert', $alert);
    }
}
