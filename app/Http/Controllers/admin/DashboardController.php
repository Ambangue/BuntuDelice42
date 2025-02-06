<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\CompletedOrder;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $order = DB::table('orders')->get();
        $restaurants = DB::table('restaurants')->get();
        $res_earnings = null;
        foreach ($restaurants as $key => $value) {
            $res_earnings[$key]['restaurant'] = $value->id;
            $res_earnings[$key]['earning'] = $order->where('restaurant_id',$value->id)->sum('restaurant_commission');
        }
        $res_latlng = null;
        foreach ($restaurants as $key => $value) {
            $res_latlng[$key]['lat'] = $value->latitude;
            $res_latlng[$key]['lng'] = $value->longitude;
        }
        
        $orders=CompletedOrder::select(DB::raw("(COUNT(*)) as count"),DB::raw('SUM(total) as totals'),DB::raw("MONTHNAME(created_at) as monthname"))
       ->whereYear('created_at', date('Y'))
       ->groupBy('monthname')
       ->get();
       
       $lastYearorders=CompletedOrder::select(DB::raw("(COUNT(*)) as count"),DB::raw('SUM(total) as totals'),DB::raw("MONTHNAME(created_at) as monthname"))
       ->whereYear('created_at',date('Y', strtotime('-1 year')))
       ->groupBy('monthname')
       ->get();
       
       
       
       $months=$orders->pluck('monthname')->toArray();
       $monthstring =$result = "'" . implode ( "', '", $months ) . "'";
       $counts=$orders->pluck('count')->toArray();
       $count = implode(', ',$counts);
       $totals=$orders->pluck('totals')->toArray();
       $total = implode(', ',$totals);
       
       $tota=$lastYearorders->pluck('totals')->toArray();
       $lasttotal = implode(', ',$tota);
        return view('admin.home',compact('count','monthstring','order','res_earnings','res_latlng','total', 'lasttotal'));
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
}
