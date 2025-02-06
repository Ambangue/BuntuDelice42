<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Order;
use App\CompletedOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    
    public function index()
    {
        $restaurant_id = auth()->user()->restaurant->id;
        $totalorders = DB::table('orders')->where('restaurant_id', $restaurant_id)->get()->unique('order_no')->count();
        $categories = DB::table('categories')->where('restaurant_id', $restaurant_id)->get();
        $subscriptions = DB::table('orders')->where('restaurant_id', $restaurant_id)->where('status','assign')->get()->unique('order_no');
        $products = DB::table('products')->where('restaurant_id', $restaurant_id)->get();
        $orders=CompletedOrder::select(DB::raw("(COUNT(*)) as count"),DB::raw('SUM(total) as totals'),DB::raw("MONTHNAME(created_at) as monthname"))->where('restaurant_id', $restaurant_id)
->whereYear('created_at', date('Y'))
->groupBy('monthname')
->get();
$OrdersByYear=CompletedOrder::select(DB::raw("(COUNT(*)) as count"),DB::raw('SUM(total) as totals'),DB::raw("YEAR(created_at) as year"))->where('restaurant_id', $restaurant_id)
->groupBy('year')
->get();

//for donat chart
$getPendings=DB::table('orders')->where('status','pending')->where('restaurant_id', $restaurant_id)->get()->unique('order_no')->count();
$getComleted=DB::table('completed_orders')->where('status','completed')->where('restaurant_id', $restaurant_id)->get()->unique('order_no')->count();
$getCancel=DB::table('completed_orders')->where('status','cancelled')->where('restaurant_id', $restaurant_id)->get()->unique('order_no')->count();

$totalorders=$getPendings+$getComleted+$getCancel;
if($totalorders>0){
 $getPendingAvg=intval($getPendings/$totalorders*100);
$getCompletedAvg=intval($getComleted/$totalorders*100);
$getCanceledAvg=intval($getCancel/$totalorders*100);
}
else{
    $getPendingAvg=0;
$getCompletedAvg=0;
$getCanceledAvg=0;
}


$months=$orders->pluck('monthname')->toArray();
$monthstring =$result = "'" . implode ( "', '", $months ) . "'";
$counts=$orders->pluck('count')->toArray();
$count = implode(', ',$counts);
$totals=$orders->pluck('totals')->toArray();
$total = implode(', ',$totals);

$years=$OrdersByYear->pluck('year')->toArray();
$yearstring =$result = "'" . implode ( "', '", $years ) . "'";
$totalsByYear=$OrdersByYear->pluck('totals')->toArray();
$totalYearBy = implode(', ',$totalsByYear);
///dd($totalYearBy);
       
        return view('restaurant.home',compact('totalorders','categories','subscriptions','products', 'yearstring', 'totalYearBy', 'monthstring','count', 'total','getPendingAvg','getCompletedAvg','getCanceledAvg','getPendings','getComleted'));
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
    
    public function notifications($id){
        $orders = Order::where('restaurant_id',$id)->where('status','pending')->groupBy('order_no')->select('id','order_no','created_at')->get();
        $count = $orders->count();
        $new = false;
        foreach ($orders as $key => $value) {
            $value['time'] = Carbon::parse($value->created_at)->diffForhumans();
            $time = Carbon::parse($value->created_at)->diffInSeconds();
            if($time < 10){
                $new = true;
            }
            
        }
        
        return response()->json([
            'status'=>true,
            'orders'=>$orders,
            'count'=>$count,
            'new'=>$new
        ]);
    }
}
