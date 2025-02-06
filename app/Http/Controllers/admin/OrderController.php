<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\CompletedOrder;
use App\Restaurant;
use App\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function notification( $body,$title,$device_token,$key,$user_id)
    {
       
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = $device_token;
        $notification = [
            'title' => $title,
            'body' => $body,
            'sound' => true,
        ];
        $extraNotificationData = ["key" => $key, "user_id" =>$user_id];
        $fcmNotification = [
            //'registration_ids' => $tokenList, //multiple token array
            'to' => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key= AAAAGem_t_Q:APA91bHTc5fzslTffQuZgnw2bq9Wk8bG1eFZxbAvSvdC_64s5oJz245iRZolu56XgtHbh8KvrzOkFW_Gw0ZT3PIcSyLZL-nl9UGuw_MNBOJdzcwlt7k-Rvd8RPW8G7cNHeyyyYE8--1I',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return response()->json(['data' => 'notification sent', 'action' => $result], 200);
    }
    
    public function userNotification( $body,$title,$device_token,$key,$user_id)
    {
       
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $tokenList = $device_token;
        $notification = [
            'title' => $title,
            'body' => $body,
            'sound' => true,
        ];
        $extraNotificationData = ["key" => $key, "user_id" =>$user_id];
        $fcmNotification = [
            'registration_ids' => $tokenList, //multiple token array
            //'to' => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key= AAAAGem_t_Q:APA91bHTc5fzslTffQuZgnw2bq9Wk8bG1eFZxbAvSvdC_64s5oJz245iRZolu56XgtHbh8KvrzOkFW_Gw0ZT3PIcSyLZL-nl9UGuw_MNBOJdzcwlt7k-Rvd8RPW8G7cNHeyyyYE8--1I',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return response()->json(['data' => 'notification sent', 'action' => $result], 200);
    }
    public function all_orders(Request $request)
    {
        $nearby_drivers = null;

        if($request->has('date')) {
            $arr = explode("-", $request->date, 2);
            $start = $arr[0];
            $end = $arr[1];

            $timestamp1 = strtotime($start);
            $start = date('Y-m-d H:i:s', $timestamp1);

            $timestamp = strtotime($end);
            $end = date('Y-m-d H:i:s', $timestamp);
            $orders=Order::whereBetween('created_at', [$start, $end])->latest()->get()->unique('order_no');
        }else{
            $orders=Order::latest()->get()->unique('order_no');
        }
        return view('admin.order.all_orders',compact('nearby_drivers','orders'));
    }
    public function complete_orders(Request $request)
    {
        if($request->has('date')) {
            $arr = explode("-", $request->date, 2);
            $start = $arr[0];
            $end = $arr[1];

            $timestamp1 = strtotime($start);
            $start = date('Y-m-d H:i:s', $timestamp1);

            $timestamp = strtotime($end);
            $end = date('Y-m-d H:i:s', $timestamp);
            $orders=CompletedOrder::where('status','completed')->whereBetween('created_at', [$start, $end])->latest()->get()->unique('order_no');
        }else{
            $orders=CompletedOrder::where('status','completed')->latest()->get()->unique('order_no');
        }
        return view('admin.order.complete_orders')->with('orders',$orders);
    }
    public function pending_orders(Request $request)
    {
        if($request->has('date')) {
            $arr = explode("-", $request->date, 2);
            $start = $arr[0];
            $end = $arr[1];

            $timestamp1 = strtotime($start);
            $start = date('Y-m-d H:i:s', $timestamp1);

            $timestamp = strtotime($end);
            $end = date('Y-m-d H:i:s', $timestamp);
            $orders=Order::with('user')->where('status','pending')->whereBetween('created_at', [$start, $end])->latest()->get()->unique('order_no');
        }else{
            $orders=Order::with('user')->where('status','pending')->latest()->get()->unique('order_no');
        }
        return view('admin.order.pending_orders')->with('orders',$orders);
    }
    public function cancel_orders(Request $request)
    {
        if($request->has('date')) {
            $arr = explode("-", $request->date, 2);
            $start = $arr[0];
            $end = $arr[1];

            $timestamp1 = strtotime($start);
            $start = date('Y-m-d H:i:s', $timestamp1);

            $timestamp = strtotime($end);
            $end = date('Y-m-d H:i:s', $timestamp);
            $orders=Order::with('user')->where('status','cancelled')->whereBetween('created_at', [$start, $end])->latest()->get()->unique('order_no');
        }else{
            $orders=Order::with('user')->where('status','cancelled')->latest()->get()->unique('order_no');
        }
        return view('admin.order.cancel_orders')->with('orders',$orders);
    }
    public function prepaire_orders()
    {
        $orders=Order::where('status','prepairing')->get()->unique('order_no');
        return view('admin.order.prepaire_orders')->with('orders',$orders);
    }
    public function schedule_orders()
    {
        $current_date = Carbon::now();
        $orders=Order::where('scheduled_date','!=',$current_date)->orwhere('status','scheduled')->get();
        return view('admin.order.schedule_orders')->with('orders',$orders);

    }
    public function show_order($id)
    {
        $order=Order::with('driver')->where('order_no',$id)->first();
        $products=Order::with('product')->where('order_no',$id)->get();
        //dd($products);
        return view('admin.order.show_orders', compact('order','products'));
    }
    public function show_completed_order($id)
    {
        $order=CompletedOrder::with('driver')->find($id);;
        //dd($order->driver);
        return view('admin.order.show_orders')->with('order',$order);
    }
    // public function prepaire_order(Request $request)
    // {
    //     $ids=$request->id;
    //     $users=DB::table('orders')
    //     ->whereIn('id', $ids)->get();
        
    //     $userOrderId=$users->pluck('user_id')->toArray();
    //     $Ids=array_unique($userOrderId);
        
    //     $getTokens=UserToken::whereIn('user_id',$Ids)->get();
    //     $device_token=$getTokens->pluck('device_tokens')->toArray();
    //     ///notification
    //     $body='You Order is Preparing Now!';
    //     $title='Preparing';
    //     $key='newOrder';
    //     $user_id=$Ids;
    //     $update=DB::table('orders')
    //     ->whereIn('id', $ids)
    //     ->update(['status' => 'prepairing']);
    //     if($update){
    //       $data=$this->userNotification($body,$title,$device_token,$key,$user_id); 
    //     }
    //     //dd($data);
    //     $alert = [];
    //     $alert['type'] = 'success';
    //     $alert['message'] = 'Order status successfully updated';
    //     return redirect()->back()->with('alert', $alert);
    // }
    
    // public function deliver_order(Order $order)
    // {
    //     $order->status = 'completed';
    //     $order->save();
    //     $alert = [];
    //     $alert['type'] = 'success';
    //     $alert['message'] = 'Order Delivered successfully';
    //     return redirect()->route('admin.all_orders')->with('alert', $alert);
        
    // }
    // public function assign_order(Order $order)
    // {
    //   //dd($order);
    //     $order->status = 'assign';
    //     $order->save();
    //     $alert = [];
    //     $alert['type'] = 'success';
    //     $alert['message'] = 'Order status successfully updated';
    //     return redirect()->route('admin.all_orders')->with('alert', $alert);
        
    // }
    // public function assign_driver(Request $request)
    // {
    //     $request->validate([
    //         'id'=>'required',
    //     ]);
        
    //     $restuarantId=auth()->user()->name;
        
    //     $restaurant=Restaurant::where('name',$restuarantId)->first();
    //     $latitude=$restaurant->latitude;
    //     $longitude=$restaurant->longitude;
    //     $radius=6371;
    //     $drivers = Driver::selectRaw("id, name, address, latitude, longitude,device_token,
        
    //                  ( 6371 * acos( cos( radians(?) ) *
    //                   cos( radians( latitude ) )
    //                   * cos( radians( longitude ) - radians(?)
    //                   ) + sin( radians(?) ) *
    //                   sin( radians( latitude ) ) )
    //                  ) AS distance", [$latitude, $longitude, $latitude])
    //     ->where('id', '=', 32)->where('status', '=', 'online')
    //     ->having("distance", "<", $radius)
    //     ->orderBy("distance",'asc')
    //     ->first();
        
    //     $orders=Order::whereIn('id',$request->id)->get();
    //     $cartOrderNo=$orders->pluck('order_no')->toArray();
    //     $Ids=array_unique($cartOrderNo);
            
    //     $getorderData['orders']=Order::whereIn('order_no',$Ids)->with('user')->take(count($Ids))->get();
        
   
        
    //     //Notification for New Ride

    //     $body='You Have A New Order';
    //     $title='New Order';
    //     $key='newOrder';
    //     $user_id=$drivers->id;
    //     //$getDriver=Driver::where('id',$vehicle->driver_id)->latest()->first();
    //     $device_token=$drivers->device_token;
    //     $data=$this->notification($body,$title,$device_token,$key,$user_id);
        
    //     dd($data);
    //     $alert = [];
    //     $alert['type'] = 'success';
    //     $alert['message'] = 'Driver assigned successfully';
    //     return redirect()->back()->with('alert', $alert);
        
    // }
    public function cancel_order(Order $order, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:191',
        ]);
        //dd($order, $request);
        $user=auth()->user();
        $user->cancellation_reasons()->create($request->all());
        $order->status = 'cancelled';
        $order->cancel_by = 'Admin';
        $order->save();
        $alert['type'] = 'success';
        $alert['message'] = 'Order cancelled Successfully';
        return redirect()->route('admin.all_orders')->with('alert', $alert);
        
    }
}
