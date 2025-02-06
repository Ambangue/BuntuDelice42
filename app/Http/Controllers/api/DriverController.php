<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Driver;
use App\Order;
use App\User;
use App\News;
use App\Restaurant;
use App\Product;
use App\DriverHistory;
use App\UserToken;
use Carbon\Carbon;
use App\CompletedOrder;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

if (!defined('BASE_URL_PROFILE')) define('BASE_URL_PROFILE',URL::to('/').'/images/driver_images/');

class DriverController extends Controller
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
    
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                'name'=>'required',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required',
                'phone'=>'required|unique:users',
                'address'=>'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
                'account_name'=>'nullable',
                'account_address' => 'required',
                'account_number' => 'required',
                'bank_name'=>'required',
                'branch_name'=>'required',
                'branch_address'=>'required',
                'paypal_account_no'=>'required',
                'licence_image' => 'required|image|mimes:jpeg,png,jpg',
            ));

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } else {
            $request['password'] = bcrypt($request->password);
            DB::beginTransaction();

                try {
                    $request['approved']=0;
                    $driver = Driver::create($request->all());
                    $image = $request->image;
                    $destination = 'images/driver_images';
                    if ($request->hasFile('image')) {
                        $filename = strtolower(
                            pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)
                            . '-'
                            . uniqid()
                            . '.'
                            . $image->getClientOriginalExtension()
                        );
                        $image->move($destination, $filename);
                        str_replace(" ", "-", $filename);
                        $driver->image = $filename;
                        $driver->save();
                    }

                    $image = $request->licence_image;
                    $destination = 'images/driver_images';
                    if ($request->hasFile('licence_image')) {
                        $filename = strtolower(
                            pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)
                            . '-'
                            . uniqid()
                            . '.'
                            . $image->getClientOriginalExtension()
                        );
                        $image->move($destination, $filename);
                        str_replace(" ", "-", $filename);
                        $driver->image = $filename;
                        $driver->save();
                    }
                    
                    $dataEmail = array(
            			'name' => $driver->name,
            			'email' => $driver->email,
            		);
            		$message="Dear User, Your signup was successfully received. We value you as our customer, and we welcome your order requests, as You Shop, We Drop. It is our aim to fill as many orders as we possible can and at the same time to provide exceptional customer service. So during the process, feel free to let us know how we are doing, and where you would like to see us improve. Thank you for signing up and being apart of The Drop. Regards, The Drop Team";
                   //sending email
                   Mail::to($request->email)->send(new RegisterEmail($dataEmail));
                    $data = 'Bearer' . ' ' . $driver->createToken('MyApp')->accessToken;
                    DB::commit();
                    
                } catch (\Exception $exception) {
                    DB::rollBack();
                    return response()->json([
                        'message' => $exception->getMessage()
                    ], 403);
                }
                $response_array = array('status' => true, 'driver_id' =>$driver->id ,'status_code' => 200, 'data' => $data);
            }
        $response = response()->json($response_array, 200);
        return $response;
    }
    public function login(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');

        $driver = Driver::where('phone', '=', $request->phone)->first();
        if (!$driver) {
            return response()->json([
                'message' => 'Phone Dose Not Exist!',
                'status' => false
            ], 403);
        }
        elseif ($driver->approved==0) {
            return response()->json([
                'message' => 'You are not approved by admin!',
                'status' => false
            ], 403);
        }
        
        elseif (!Hash::check($password, $driver->password)) {
            return response()->json([
                'message' => 'Incorrect Password',
                'status' => false
            ], 403);
        }
        $request['driver_id'] = $driver->id;
        $request['name'] = $driver->name;
        $request['email'] = $driver->email;
        $request['phone'] = $driver->phone;
        $request['approved'] = $driver->approved;
        $request['image'] =  $driver->image;
        $data = 'Bearer' . ' ' . $driver->createToken('MyApp')->accessToken;
        $response_array = array('user_id'=>$request->driver_id,
                'name'=>$request->name,'email'=>$request->email,
                'image'=>$request->image,
                'status' => true,'status_code'=>200,'message' => 'Logged in successfully',
                'data'=>$data);

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),[
            'phone' => 'required',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        }
        else{


        $check_password=Driver::where(['phone'=>$request->phone])->first();
            $password=bcrypt($request->password);
            if($check_password)
            { 
            Driver::where('phone',$request->phone)->update(['password'=>$password]);
            return response()->json([
                'status' => true,
                'message' => 'Updated Successfully!',
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Failed!',
            ]);
        }

        }
    }
    public function profile($user)
    {
        $getUser=Driver::select('id','name','email','image','phone', 'paypal_account_no', 'created_at')->where('id',$user)->first();
        
 $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $getUser->created_at);
 $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', now());

   $diff_in_years = $to->diffInYears($from);
        return response()->json([
            'status' => true,
            'data' => $getUser,
            'years' => $diff_in_years,
            'BASE_URL_PROFILE'=>BASE_URL_PROFILE,
        ]);
    }
    
    
    public function updateProfile(Request $request)
    {
        

$validator = Validator::make(
            $request->all(),
            array(
                'driver_id'=>'required',
                'name'=>'nullable',
                'paypal_account_no'=>'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
            ));
            $driver=Driver::find($request->driver_id); 
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } 
        else {
                  $driver->name = $request->name;
                  $driver->email = $request->email;
                  //$driver->image = $request->image;
                  $driver->save();
                   
                    if($image = $request->image=='')
                    {
                        $image = $driver->image;
                    }
                    else{
                        $image = $request->image;
                    }
                    $destination = 'images/driver_images';
                    if ($request->hasFile('image')) {
                        $filename = strtolower(
                            pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)
                            . '-'
                            . uniqid()
                            . '.'
                            . $image->getClientOriginalExtension()
                        );
                        $image->move($destination, $filename);
                        str_replace(" ", "-", $filename);
                        $driver->image = $filename;
                        $driver->save();
                    }
                    $data['name']= $driver->name;
                    $data['email']= $driver->email;
                    $data['paypal_account_no']= $driver->paypal_account_no;
                $response_array = array('status' => true, 'data' => $data, 'status_code' => 200);
            }
        $response = response()->json($response_array, 200);
        return $response;
    }
    
    
    
    
    
    public function SetDriverOnline(Request $request , $driver)
    {
        
        
        
        $validator = Validator::make(
            $request->all(),
            array(
                'latitude' => 'required',
                'longitude' => 'required',
                'device_token' => 'required'
            ));

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } 
        else {
         $update=Driver::find($driver);   
        $update->status='online';
        $update->latitude=$request->latitude;
        $update->longitude=$request->longitude;
        $update->device_token=$request->device_token;
        $update->save();
         return response()->json([
            'status' => true,
            'message' =>'You are online now!'
        ]);
       }
       
    }
    
    public function SetDriverOnlineTime(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                'driver_id'=>'required',
                'start_date'=>'required',
                'end_date'=>'required',
                
            ));

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } 
        else {
           
           
           $book = DriverHistory::create($request->all());
        }
        
             return response()->json([
            'status' => true,
            
        ]);  
        
       
    }
    
    public function SetDriverOffline($user)
    {
        $getUser=Driver::where('id',$user)->first();
        
        $getUser->status='offline';
        $getUser->save();

        return response()->json([
            'status' => true,
            'message' =>'You are Offline Now!'
        ]);
    }

    
    //Assign Orders 
     public function orderRequests($driver)
    {
        
        $getRestId=Order::where('driver_id',$driver)->first();
        $getRestIds=Order::where('driver_id',$driver)->get();
        $cartProIDs=$getRestIds->pluck('product_id')->toArray();
        $cartOrderNo=$getRestIds->pluck('order_no')->toArray();
        $cartUserIDs=$getRestIds->pluck('user_id')->toArray();
        
        $getorderData=Restaurant::find($getRestId->restaurant_id);
       
         $Ids=array_unique($cartOrderNo);
            
        $getorderData['orders']=Order::whereIn('order_no',$Ids)->with('user')->take(count($Ids))->get();
        return response()->json([
            'status' =>true,
            'data' =>$getorderData
            
            ]);
    }
    
    public function ordersProducts($orderno)
    {
        $getOrders=Order::where('order_no',$orderno)->get();
        $ProIDs=$getOrders->pluck('product_id')->toArray();
        
        $products=Product::whereIn('id', $ProIDs)->get();
        
        return response()->json([
            'status' => true,
            'products' =>$products
            
            ]);
        
    }
    
     public function acceptOrderRequests(Request $request)
    {
        $driverId=$request->driver_id;
        $orders=Order::get()->unique('order_no');
        $users=$orders->pluck('user_id')->toArray();
        $user=UserToken::WhereIn('user_id',$users)->get();
        $tokens=$user->pluck('device_tokens')->toArray();
        if($request->status==1)
        {
        $body='Your is assign to driver';
        $title='Order Assign';
        $key='assignOrder';
          $assignOrder=DB::table('orders')
            ->where('driver_id', $driverId)
            ->update(['status' => "assign"]);
            
            $data=$this->userNotification($body,$title,$tokens,$key,$driverId);
           dd($data);
          $status=true;
        }
        elseif($request->status==3){
            $body='Your Order is pickup from';
        $title='Order Pickup';
        $key='pickipOrder';
             $assignOrder=DB::table('orders')
            ->where('driver_id', $driverId)
            ->update(['status' => "pickup"]);
          $status=true;
          $data=$this->userNotification($body,$title,$tokens,$key,$driverId);
        }
        else{
            $status=false;
        }
        
        return response()->json([
            'status' =>$status,
            
            ]);
    }
    
    public function deliverySummary($driver)
    {
       
        $records = DB::table('completed_orders')
        ->select(DB::raw('*'))
        ->whereRaw('Date(created_at) = CURDATE()')
        ->count();
                  
       $driverHistory=DriverHistory::where('driver_id',$driver)
       ->latest()->first();
  
  $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $driverHistory->start_date);
 
  $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $driverHistory->end_date);
  
  $diff_in_hours = $to->diffInHours($from);
   $driver=Driver::find($driver);
  $finalEarnings=$driver->hourly_pay * $diff_in_hours;
  
                 return response()->json([
                'status' =>true,
                'derlieries' =>$records,
                'total' =>$finalEarnings,
                'starttime' => $driverHistory->start_date,
                'to' => $diff_in_hours,
            
            ]);
                  
    }
    
    public function driverEarningHistory(Request $request, $driver)
    {
        
        // currentEarning = TotalEarning - WithdrawEarning
        
        
        $data=DriverHistory::where('driver_id',$driver)->get()->sum('earnings');
        
        
        // $result['weeks']= DriverHistory::where('driver_id',$driver)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->selectRaw('year(created_at) year, monthname(created_at) month')
        //         ->groupBy('year', 'month')
        //          ->orderBy('year', 'desc')->get();
        
        if($request->start_date!='' || $request->end_date!='')
        {
         $result= DriverHistory::where('driver_id',$driver)->whereBetween('created_at', [$request->start_date, $request->end_date])->latest()->get();   
        }
        else{
        $result= DriverHistory::where('driver_id',$driver)->latest()->get();
        }
     return response()->json([
                'status' =>true,
                'totalEarning' =>$data,
                'weeks' =>$result,
            
            ]);
    }
    
    public function latestNews()
    {
        $news=News::latest()->get();
        return response()->json([
                'status' =>true,
                'data' =>$news,
            
            ]);
    }
}
