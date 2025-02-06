<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;
use App\Address;
use App\Order;
use App\Restaurant;
use App\Product;
use App\Rating;
use App\Review;
use App\CompletedOrder;
use App\UserToken;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

if (!defined('BASE_URL_PROFILE')) define('BASE_URL_PROFILE',URL::to('/').'/images/profile_images/');

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                'name'=>'nullable',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required',
                'phone'=>'required|unique:users',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
                'type' => 'nullable|in:user,admin','restaurant',
            ));

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } else {
            $request['password'] = bcrypt($request->password);
            DB::beginTransaction();

                try {
                    $user = User::create($request->all());
                    $image = $request->image;
                    $destination = 'images/profile_images';
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
                        $user->image = $filename;
                        $user->save();
                    }
                    DB::commit();
                    $data = array(
            			'name' => $user->name,
            			'email' => $user->email,
            		);
            		$message="Dear User, Your signup was successfully received. We value you as our customer, and we welcome your order requests, as You Shop, We Drop. It is our aim to fill as many orders as we possible can and at the same time to provide exceptional customer service. So during the process, feel free to let us know how we are doing, and where you would like to see us improve. Thank you for signing up and being apart of The Drop. Regards, The Drop Team";
            		$subject="Registration";
            		$email=$request->email;
                   //sending email
                   Mail::to($request->email)->send(new RegisterEmail($data));
            
                } catch (\Exception $exception) {
                    DB::rollBack();
                    return response()->json([
                        'message' => $exception->getMessage()
                    ], 403);
                }
                $response_array = array('status' => true, 'user_id' =>$user->id ,'status_code' => 200);
            }
        $response = response()->json($response_array, 200);
        return $response;
    }
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),[
            'phone' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        }
        else {
            $user = User::where(function ($query) use ($request) {
                $query->where('phone', $request->phone)->first();
            })->first();

            if (!$user)
                return response()->json([
                    'message' => 'incorrect number',
                    'status'=>false
                ], 403);

            if (!auth()->loginUsingId((password_verify($request->password, $user->password)) ? $user->id : 0))
                return response()->json([
                    'message' => 'incorrect password',
                    'status'=>false
                ], 403);
            $user = auth()->user();
            $request['user_id'] = $user->id;
            $request['email']=$user->email;
            $request['phone']=$user->phone;
            $data = 'Bearer' . ' ' . $user->createToken('MyApp')->accessToken;
            $response_array = array('user_id'=>$request->user_id,
               'email'=>$request->email, 'phone'=>$request->phone,
                'status' => true,'status_code'=>200,'message' => 'Logged in successfully', 'data'=>$data);
        }
        $response = response()->json($response_array, 200);
        return $response;
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),[
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        }
        else{


        $check_password=User::where(['phone'=>$request->phone])->first();
            $password=bcrypt($request->password);
            if($check_password)
            { 
            User::where('phone',$request->phone)->update(['password'=>$password]);
            return response()->json([
                'status' => true,
            ]);
        }
        else{
            return response()->json([
                'status' => false,
            ]);
        }

        }
        $response = response()->json($response_array, 200);
        return $response;
    }
    public function profile($user)
    {
        $getUser=User::select('id','name','email','image','phone','firebase_id')->where('id',$user)->first();

        return response()->json([
            'status' => true,
            'data' => $getUser,
            'BASE_URL_PROFILE'=>BASE_URL_PROFILE,
        ]);
    }
    public function updateProfile(Request $request)
    {
        

$validator = Validator::make(
            $request->all(),
            array(
                'user_id'=>'required',
                'name'=>'nullable',
                'email' => 'required|email|max:255',
                'phone'=>'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
            ));
            $user=User::find($request->user_id); 
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } 
        else {
                  $user->name = $request->name;
                  $user->email = $request->email;
                  $user->phone = $request->phone;
                  //$user->image = $request->image;
                  $user->save();
                   
                    if($image = $request->image=='')
                    {
                        $image = $user->image;
                    }
                    else{
                        $image = $request->image;
                    }
                    $destination = 'images/profile_images';
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
                        $user->image = $filename;
                        $user->save();
                    }
                $response_array = array('status' => true, 'status_code' => 200);
            }
        $response = response()->json($response_array, 200);
        return $response;
    }
    
     public function addUserAddress(Request $request)
    {
       $validator = Validator::make(
            $request->all(),
            array(
                'title'=>'required',
                'user_id'=>'required',
                'building_no'=>'required',
                'street_no' => 'required',
                'area'=>'required',
                'latitude'=>'required',
                'longitude'=>'required',
                'complete_address'=>'required',
                'floor' => 'nullable',
            ));
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        }
        else{
        $address = new Address;
        $address->title = $request->title;
        $address->user_id = $request->user_id;
        $address->building_no = $request->building_no;
        $address->street_no = $request->street_no;
        $address->area = $request->area;
        $address->floor = $request->floor;
        $address->latitude = $request->latitude;
        $address->longitude = $request->longitude;
        $address->complete_address = $request->complete_address;
        $address->save();
        if($address){
           return response()->json([
             'status' => true,
           ]);
        }
        }
    }
     public function getUserAddress($user)
    {
        $getUserAddress=Address::where('user_id',$user)->get();
          return response()->json([
             'status' => true,
             'address' => $getUserAddress,
           ]);
    }
        
    public function trackOrders(Request $request)
        {
            $orderNo=$request->order_no;
            $restaurantId=$request->restaurant_id;
            $getProDetail=Order::with('restaurant')->where([

        ['restaurant_id', '=', $restaurantId],['order_no', '=', $orderNo]

       ])
        ->select('user_id','restaurant_id','order_no','product_id','d_lat','d_lng','tax','offer_discount','delivery_charges','sub_total','total','ordered_time','status')->first();
        
        $getProIDs=Order::with('restaurant')->where([

        ['restaurant_id', '=', $restaurantId],['order_no', '=', $orderNo],['status', '!=', 'completed']

       ])
        ->select('product_id')->get();
            
            $cartProIDs=$getProIDs->pluck('product_id')->toArray();
            
            $getProDetail['products']=Product::whereIn('id',$cartProIDs)->get();
            return response()->json([
                'status' => true,
                'data' => $getProDetail
              ]);
        }
        
        public function trackCompletedOrders(Request $request)
        {
            $orderNo=$request->order_no;
            $restaurantId=$request->restaurant_id;
            $getProDetail=CompletedOrder::with('restaurant')->where([

        ['restaurant_id', '=', $restaurantId],['order_no', '=', $orderNo]

       ])
        ->select('user_id','restaurant_id','order_no','product_id','tax','d_lat','d_lng','offer_discount','delivery_charges','sub_total','total','status','ordered_time','delivery_address','updated_at')->first();
        
        $getProIDs=CompletedOrder::with('restaurant')->where([

        ['restaurant_id', '=', $restaurantId],['order_no', '=', $orderNo]

       ])
        ->select('product_id')->get();
            
            $cartProIDs=$getProIDs->pluck('product_id')->toArray();
            
            $getProDetail['products']=Product::whereIn('id',$cartProIDs)->get();
            return response()->json([
                'status' => true,
                'data' => $getProDetail
              ]);
        }
    
    public function sendReviewsToRestaurant(Request $request)
    {
        $restauranId=$request->restaurant_id;
        $driverId=$request->driver_id;
        $UserId=$request->user_id;
        
        $restaurantRating=$request->restaurant_rating;
        $restaurantReview=$request->restaurant_review;
        
        $driverRating=$request->driver_rating;
        $driverReview=$request->driver_review;
        
        $ratings = new Rating;
        $reiews = new Review;
        
        $reiews->driver_id = $driverId;
        $reiews->user_id = $UserId;
        $reiews->reviews = $driverReview;
        $reiews->rating = $driverRating;
        $reiews->save();
        
        $ratings->restaurant_id =$restauranId;
        $ratings->user_id = $UserId;
        $ratings->reviews = $restaurantReview;
        $ratings->rating = $restaurantRating;
        $ratings->save();
        
        return response()->json([
            'status' =>true,
            
            ]);
    }    
    
    public function userDeviceToken(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
            'device_token' => 'required',
            'user_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        }
        else{
        $driver =UserToken::updateOrCreate(
            ['user_id' => $request->user_id],
            ['device_tokens' => $request->device_token]
        );
 
             $response_array = array('status' => true, 'status_code' => 200);
            }
        $response = response()->json($response_array, 200);
        return $response;
    }
    }

