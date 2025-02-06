<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;
use App\Address;
use App\Order;
use App\Restaurant;
use App\Product;
use App\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

if (!defined('BASE_URL_PROFILE')) define('BASE_URL_PROFILE',URL::to('/').'/images/profile_images/');

class ReasonController extends Controller
{
  public function getReason(Request $request)
    {
        $getResaon=Reason::where('type',1)->get();
        
        return response()->json([
            'status' =>true,
            'data' =>$getResaon
            
            ]);
    }
    
    public function rejectOrderRequests(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                'driver_id'=>'required',
                'user_id' => 'required',
                'order_no' =>'required',

            ));
            
        if ($validator->fails())
        {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        }
        else{
            $ordersNo=str_replace(array( '[', ']' ), '', $request->order_no);
            $optionalArray = explode(',', $ordersNo);
            
            foreach($optionalArray as $orders){
                 DB::table('reason_reject')->insert(
            [ 
              'driver_id' => $request->driver_id, 
              'user_id' => $request->user_id,
              'order_no' =>$orders,
              'reason'=>$request->reason,
              'created_at' => Now(),
           ]); 
            }
            
             $assignOrder=DB::table('orders')
            ->where('driver_id', $request->driver_id)
            ->update(['status' => "pending", 'driver_id'=>null]);
             if($assignOrder){
                 
             return response()->json([
            'status' =>true,
            
            ]);  
             }    
         } 
        
    }
}
