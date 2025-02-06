<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Order;
use App\CompletedOrder;
use App\Driver;
use App\Restaurant;
use Carbon\Carbon;
use App\UserToken;
use http\Exception;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'Authorization: key= AAAAU6vnK2I:APA91bH9FiIKziwh9o2eyWAb9sMmERkNpZWMqC1jMSD3dXQOdS45Fu7_x74N3ryYmv0U3fvOnlnXYYdLncGautnTziZFAbWB79rDHbdZVkHNOdkequvbPiey8u27b99-3NUtE_7LTzSu',
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
            'Authorization: key= AAAAU6vnK2I:APA91bH9FiIKziwh9o2eyWAb9sMmERkNpZWMqC1jMSD3dXQOdS45Fu7_x74N3ryYmv0U3fvOnlnXYYdLncGautnTziZFAbWB79rDHbdZVkHNOdkequvbPiey8u27b99-3NUtE_7LTzSu',
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
    function getDistance($latitude2, $longitude2, $latitude1, $longitude1)
    {
        $earth_radius = 6356 ;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
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
    
    public function all_orders(Request $request)
    {
        $restuarantId=auth()->user()->id;
        
        $restaurant=Restaurant::where('user_id',$restuarantId)->first();
        if($request->has('date')) {
            $arr = explode("-", $request->date, 2);
            $start = $arr[0];
            $end = $arr[1];

            $timestamp1 = strtotime($start);
            $start = date('Y-m-d H:i:s', $timestamp1);

            $timestamp = strtotime($end);
            $end = date('Y-m-d H:i:s', $timestamp);
            $orders=Order::where([
                ['restaurant_id',$restaurant->id],
                ['status','pending']
            ])->whereBetween('created_at', [$start, $end])->latest()->get()->unique('order_no');
        }else{
            $orders=Order::where([
                ['restaurant_id',$restaurant->id],
                ['status','pending']
            ])->latest()->get()->unique('order_no');
        }
         //dd($restuarantId);
        return view('restaurant.order.all_orders',compact('orders'));
    }
    public function complete_orders(Request $request)
    {
        $name=auth()->user()->id;
        $restaurant=Restaurant::where('user_id',$name)->first();
        if($request->has('date')) {
            $arr = explode("-", $request->date, 2);
            $start = $arr[0];
            $end = $arr[1];

            $timestamp1 = strtotime($start);
            $start = date('Y-m-d H:i:s', $timestamp1);

            $timestamp = strtotime($end);
            $end = date('Y-m-d H:i:s', $timestamp);
            $orders=Order::where([
                ['restaurant_id',$restaurant->id],
                ['status','completed']
            ])->whereBetween('created_at', [$start, $end])->latest()->get()->unique('order_no');
        }else{
            $orders=Order::where('status','completed')->where('restaurant_id',$restaurant->id)->latest()->get()->unique('order_no');
        }

        return view('restaurant.order.complete_orders')->with('orders',$orders);
    }
    public function pending_orders(Request $request)
    {
        $name=auth()->user()->id;
        $restaurant=Restaurant::where('user_id',$name)->first();
        if($request->has('date')) {
            $arr = explode("-", $request->date, 2);
            $start = $arr[0];
            $end = $arr[1];

            $timestamp1 = strtotime($start);
            $start = date('Y-m-d H:i:s', $timestamp1);

            $timestamp = strtotime($end);
            $end = date('Y-m-d H:i:s', $timestamp);
            $orders=Order::where([
                ['restaurant_id',$restaurant->id],
                ['status','assign']
            ])->whereBetween('created_at', [$start, $end])->latest()->get()->unique('order_no');
        }else {
            $orders = Order::where('status', 'assign')->where('restaurant_id', $restaurant->id)->latest()->get()->unique('order_no');
        }
        return view('restaurant.order.pending_orders')->with('orders',$orders);
    }
    public function cancel_orders(Request $request)
    {
        $name=auth()->user()->id;
        $restaurant=Restaurant::where('user_id',$name)->first();
        if($request->has('date')) {
            $arr = explode("-", $request->date, 2);
            $start = $arr[0];
            $end = $arr[1];

            $timestamp1 = strtotime($start);
            $start = date('Y-m-d H:i:s', $timestamp1);

            $timestamp = strtotime($end);
            $end = date('Y-m-d H:i:s', $timestamp);
            $orders=Order::where([
                ['restaurant_id',$restaurant->id],
                ['status','cancelled']
            ])->whereBetween('created_at', [$start, $end])->latest()->get()->unique('order_no');
        }else {
            $orders = Order::where('status', 'cancelled')->where('restaurant_id', $restaurant->id)->get()->unique('order_no');
        }
        return view('restaurant.order.cancel_orders')->with('orders',$orders);
    }
    public function getPreparingOrders()
    {
        $name=auth()->user()->id;
        $restaurant=Restaurant::where('user_id',$name)->first();
        $orders=Order::where('status','prepairing')->where('restaurant_id',$restaurant->id)->get();
        return view('restaurant.order.prepaire_orders')->with('orders',$orders);
    }
    public function cancel_order($order)
    {
        
        $order=Order::where('order_no',$order)->update(['status' => 'cancelled', 'cancel_by' => 'Restaurant']);
        Session::flash('success','Order Cancelled Successfully!!');
        return redirect()->back();
    }
    public function schedule_orders()
    {
        $current_date = Carbon::now();
        $orders=Order::where('scheduled_date','!=',$current_date)->orwhere('status','scheduled')->get();
        return view('restaurant.order.schedule_orders')->with('orders',$orders);

    }
    public function prepaire_order(Request $request)
    {
      
        $ids=$request->id;
        $users=DB::table('orders')
        ->whereIn('order_no', $ids)->get();
        //dd($users);
        $userOrderId=$users->pluck('user_id')->toArray();
        $Ids=array_unique($userOrderId);
        
        $getTokens=UserToken::whereIn('user_id',$Ids)->get();
        $device_token=$getTokens->pluck('device_tokens')->toArray();
        ///notification
        $body='You Order is Preparing Now!';
        $title='Preparing';
        $key='orderPreparing';
        $user_id=$Ids;
        $update=DB::table('orders')
        ->whereIn('order_no', $ids)
        ->update(['status' => 'prepairing']);
        $data=$this->userNotification($body,$title,$device_token,$key,$user_id);
        ///dd($data);
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'Order status successfully updated';
        return redirect()->back()->with('alert', $alert);
    }
    public function deliver_order(Order $order)
    {
        $order->status = 'completed';
        $order->save();
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'Order Delivered successfully';
        return redirect()->back()->with('alert', $alert);
    }
    public function show_order($id)
    {
        $order=Order::with('driver')->where('order_no',$id)->first();
        $products=Order::with('product')->where('order_no',$id)->get();
        //dd($products);
        return view('admin.order.show_orders', compact('order','products'));
    }
    public function assign_order(Request $request)
    {
        
        $order->status = 'assign';
        $order->save();
        
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'Order status successfully updated';
        return redirect()->back()->with('alert', $alert);
    }
    public function assign_driver(Request $request,Order $order)
    {
        $request->validate([
            'id'=>'required',
        ]);
        
        $restuarantId=auth()->user()->id;
        $restaurant=Restaurant::where('id',$restuarantId)->first();
        $latitude=$restaurant->latitude;
        $longitude=$restaurant->longitude;
        $radius=6371;
        
         //     //Notification for New Ride

        $body='You Have A New Order';
        $title='New Order';
        $key='newOrder';
       
      
        $orders=Order::whereIn('order_no',$request->id)->get();
       
            // dd($orders);
        $getorderData['orders']=Order::whereIn('order_no',$request->id)->with('user')->take(count($request->id))->get();
        
        $checkDriverData=DB::table('reason_reject')->whereIn('order_no',$request->id)->get();
        //dd($checkDriverData);
        $checkIds=$checkDriverData->pluck('driver_id')->toArray();
        if(!$checkDriverData){
        $driversIfNot = Driver::selectRaw("id, name, address, latitude, longitude,device_token,
        
                     ( 6371 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( latitude ) ) )
                     ) AS distance", [$latitude, $longitude, $latitude])
        ->where('status', '=', 'online')
        ->having("distance", "<", $radius)
        ->orderBy("distance",'asc')
        ->first();
        $driver_id=$driversIfNot->id;
        $user_id=$driversIfNot->id;
        $device_token=$driversIfNot->device_token;
       }
       else{
           $drivers = Driver::selectRaw("id, name, address, latitude, longitude,device_token,
        
                     ( 6371 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( latitude ) ) )
                     ) AS distance", [$latitude, $longitude, $latitude])
        ->whereNotIn("id",$checkIds)->where('status', '=', 'online')
        ->having("distance", "<", $radius)
        ->orderBy("distance",'asc')
        ->first();
        $driver_id=$drivers->id;
        $device_token=$drivers->device_token;
       }
        $updateProduct = Order::whereIn('id',$request->id)
        ->update(['driver_id' => $drivers->id]);
         $data=$this->notification($body,$title,$device_token,$key,$driver_id);
        //dd($data);
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'Request sent successfully';
        return redirect()->back()->with('alert', $alert);
    }

}
