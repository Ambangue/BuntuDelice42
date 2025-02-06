<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Order;
use App\Cart;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

if (!defined('BASE_URL_PROFILE')) define('BASE_URL_PROFILE',URL::to('/').'/images/profile_images/');

class OrderController extends Controller
{
    public function notification( $body,$title,$device_token,$key,$click_action)
    {
       
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = $device_token;
        $notification = [
            'title' => $title,
            'body' => $body,
            'sound' => true,
        ];
        $extraNotificationData = ["key" => $key, "click_action" =>$click_action];
        $fcmNotification = [
            //'registration_ids' => $tokenList, //multiple token array
            'to' => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key= AAAAGem_t_Q:APA91bHtrZm7cIzbtlnzrwrS8jcszUwx6kPEQS_ZY9nG359OwmlgZYzNc6elU6LLBVmuigcXL11isK-1oVMgwq-LjGGcqV22ERlsWacsgI4KLc9KwJNUIDPLPmYZ1N4ZabV4sxjkcvQT',
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
    public function getOrders(Request $request)
    {
       $validator = Validator::make(
            $request->all(),
            array(
                'user_id'=>'required',
                'sub_total'=>'required',
                'total'=>'required',
                'delivery_fee'=>'required',
                'tax'=>'required',
                'delivery_address'=>'required',
                'd_lat'=>'required',
                'd_lng'=>'required',
            ));
           
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } 
        else{
             
             $datas =Cart::where('user_id',$request->user_id)->get();
         $orderNo='D-'.rand ( 1000000 , 9999999 );
foreach($datas as $data){
    $orders=DB::table('orders')
    ->insert(
        [
        'user_id' => $data->user_id, 'restaurant_id'=>$data->restaurant_id,
        'product_id'=>$data->product_id,'qty'=>$data->qty,
        'driver_id' => NULL,'order_no' => $orderNo,
        'offer_discount' => 4, 'tax'=>$request->tax,
        'delivery_charges' => $request->delivery_fee, 'sub_total'=>$request->sub_total,

        'total' => $request->total, 'admin_commission'=>2,
        'restaurant_commission' => 4, 'driver_tip'=>$request->driver_tip,
        'delivery_address' => $request->delivery_address,

        'd_lat' => $request->d_lat, 'd_lng'=>$request->d_lng,
        'ordered_time' => now(), 'delivered_time'=>now(),'created_at'=>now(),

    ]);
}
if($orders){
    Cart::where('user_id',$request->user_id)->delete();
}
    
   return response()->json([
                'status' => true,
            ]);

           }
}
public function UserOrderHistory($user)
{
$getCompletedOrders=DB::table('orders')
            ->join('restaurants', 'restaurants.id', '=', 'orders.restaurant_id')
            ->select('orders.order_no','orders.id','orders.total', 'restaurants.name', 'restaurants.logo','orders.restaurant_id','orders.id','orders.status','orders.created_at')
            ->where([
                'orders.user_id'=> $user, 
                'orders.status'=>'pending'])
                ->orWhere([
                'orders.user_id'=> $user, 
                'orders.status'=>'assign'])
            ->get();
            return response()->json([
     'status' => true,
     'data' => $getCompletedOrders

    ]);
}

public function UserCompletedOrderHistory($user)
{
    $getCompletedOrders=DB::table('completed_orders')
            ->join('restaurants', 'restaurants.id', '=', 'completed_orders.restaurant_id')
            ->select('completed_orders.order_no','completed_orders.id','completed_orders.total', 'restaurants.name', 'restaurants.logo','completed_orders.restaurant_id','completed_orders.id','completed_orders.status','completed_orders.created_at','completed_orders.user_id','completed_orders.ordered_time')
           
           ->where(function($query) use ($user)
        {
            $query->where('completed_orders.user_id',$user)
                  ->where('completed_orders.status','completed');
        })
       ->orWhere(function($query) use ($user)
        {
            $query->where('completed_orders.user_id',$user)
                  ->where('completed_orders.status','cancelled');
        })
            ->latest()
            ->get();

     
     
    return response()->json([
     'status' => true,
     'data' => $getCompletedOrders

    ]);
}
public function completeOrders(Request $request)
{
    $validator = Validator::make(
            $request->all(),
            array(
                'user_id'=>'required',
                'driver_id'=>'required',
            ));
           
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } 
        else{
             
             $datas =Order::where([
                 ['user_id',$request->user_id],
                 ['driver_id',$request->driver_id]
                 ])->get();
                 //$getTokens=UserToken::where('user_id',$request->user_id)->get();
foreach($datas as $data){
    $orders=DB::table('completed_orders')
    ->insert(
        [
        'user_id' => $data->user_id, 'restaurant_id'=>$data->restaurant_id,
        'product_id'=>$data->product_id,'qty'=>$data->qty,
        'driver_id' => $data->driver_id,'order_no' => $data->order_no,
        'offer_discount' => 4, 'tax'=>$data->tax,
        'delivery_charges' => $data->delivery_charges, 'sub_total'=>$data->sub_total,

        'total' => $data->total, 'admin_commission'=>2,
        'restaurant_commission' => 4, 'driver_tip'=>11,
        'delivery_address' => $data->delivery_address, 'scheduled_date'=>$data->scheduled_date,

        'd_lat' => $data->d_lat, 'd_lng'=>$data->d_lng,
        'ordered_time' => $data->ordered_time, 'delivered_time'=>$data->delivered_time,'created_at'=>now(),

    ]);
}
if($orders){
    
    
    // $body='You Have A New Order';
    //     $title='New Order';
    //     $key='newOrder';
    //     $device_token=$getTokens->device_tokens;
    //     $data=$this->notification($body,$title,$device_token,$key,$user_id);
    
    Order::where([
                 ['user_id',$request->user_id],
                 ['driver_id',$request->driver_id]
                 ])->delete();
}
    
   return response()->json([
                'status' => true,
            ]);

           }
}
}
