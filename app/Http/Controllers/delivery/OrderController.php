<?php

namespace App\Http\Controllers\delivery;

use App\Http\Controllers\Controller;
use App\Order;
use App\Restaurant;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function all_orders()
    {
        $name=auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();
        $orders=$restaurant->orders;
        return view('admin.order.all_orders')->with('orders',$orders);
    }
    public function complete_orders()
    {
        $name=auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();
        $orders=Order::where('status','completed')->where('restaurant_id',$restaurant->id)->get();
        return view('admin.order.complete_orders')->with('orders',$orders);
    }
    public function pending_orders()
    {
        $name=auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();
        $orders=Order::where('status','pending')->where('restaurant_id',$restaurant->id)->get();
        return view('admin.order.pending_orders')->with('orders',$orders);
    }
    public function cancel_orders()
    {
        $name=auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();
        $orders=Order::where('status','cancelled')->where('restaurant_id',$restaurant->id)->get();
        return view('admin.order.cancel_orders')->with('orders',$orders);
    }
    public function cancel_order(Request $request,Order $order)
    {
        $request->validate([
            'reason' => 'required|string|max:191',
        ]);
        $user=auth()->user();
        $user->cancellation_reasons()->create($request->all());
        Order::where('id',$order->id)->update('status','cancelled');
        $alert['type'] = 'success';
        $alert['message'] = 'Order cancelled Successfully';
        return redirect()->route('order.index')->with('alert', $alert);
    }
    public function schedule_orders()
    {
        $current_date = Carbon::now();
        $orders=Order::where('scheduled_date','!=',$current_date)->orwhere('status','scheduled')->get();
        return view('admin.order.schedule_orders')->with('orders',$orders);

    }
    public function assign_request(Order $order,Request $request)
    {

//        dd('hi');
        $name = auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();

        # code...
        $old_provider = 0;

//        $trackorderstatus = $this->trackorderstatus;
//        dd($trackorderstatus);

//        $order_data = DB::table('requests')->where('id', $request_id)->first();
        $order_data=Order::where('id',$order->id)->first();


        $restuarant_detail = Restaurant::whwre('id',$restaurant->id)->first();

        $source_lat = $restuarant_detail->latitude;
        $source_lng = $restuarant_detail->longitude;


        $data = file_get_contents(env('FIREBASE_URL') . "/available_providers/.json");

        $data = json_decode($data);
        //dd($data);

        //var_dump($data); exit;
        $temp_driver = 0;
        $last_distance = 0;
        if ($data != NULL && $data != "") {
            foreach ($data as $key => $value) {
                # code...
                $driver_id = $key;
                //dd($key);

                if ($old_provider == 0) {

                    $old_provider = -1;

                }
                if ($driver_id != $old_provider) {
                    if ($value != NULL && $value != "") {
                        $driver_lat = $value->lat;
                        $driver_lng = $value->lng;

                        try {
                            $q = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$source_lat,$source_lng&destinations=$driver_lat,$driver_lng&mode=driving&sensor=false&key=" . GOOGLE_API_KEY;
                            $json = file_get_contents($q);
                            $details = json_decode($json, TRUE);

                            dd($details);
                            exit;
                            if (isset($details['rows'][0]['elements'][0]['status']) && $details['rows'][0]['elements'][0]['status'] != 'ZERO_RESULTS') {
                                $current_distance_with_unit = $details['rows'][0]['elements'][0]['distance']['text'];
                                $current_distance = (float)$details['rows'][0]['elements'][0]['distance']['text'];
                                $unit = str_after($current_distance_with_unit, ' ');
                                if ($unit == 'm') {
                                    $current_distance = $current_distance / 1000;
                                }
                                if ($current_distance <= DEFAULT_RADIUS) {
                                    if ($temp_driver == 0) {
                                        $temp_driver = $driver_id;
                                        $last_distance = $current_distance;
                                    } else {
                                        if ($current_distance < $last_distance) {
                                            $temp_driver = $driver_id;
                                            $last_distance = $current_distance;

                                        }
                                    }
                                }
                            }

                        } catch (Exception $e) {

                        }
                    }
                }

                //print_r($value->lat); exit;
            }
        }
        //dd($temp_driver);

        if ($temp_driver != 0) {
            # code...
            $ins_data = array();
            $user_data = DB::table('requests')
                ->where('id', $request_id)
                ->first();
            dd($user_data);

            $data = DB::table('requests')->where('id', $request_id)->update(['delivery_boy_id' => $temp_driver, 'status' => 2]);
            //dd($data);
            $check_status = $trackorderstatus->where('request_id', $request_id)->where('status', 2)->count();
            //dd($check_status);
            if ($check_status == 0) {
                $status_entry[] = array(
                    'request_id' => $request_id,
                    'status' => 2,
                    'detail' => "Food is being prepared"
                );

                $trackorderstatus->insert($status_entry);
            }

            // to insert into firebase
            $postdata = array();
            $postdata['request_id'] = $request_id;
            $postdata['provider_id'] = (String)$temp_driver;
            $postdata['user_id'] = $user_data->user_id;
            $postdata['status'] = 2;
            $postdata = json_encode($postdata);
            $this->update_firebase($postdata, 'current_request', $request_id);

            // sending request to driver
            $postdata = array();
            $postdata['request_id'] = $request_id;
            $postdata['user_id'] = $user_data->user_id;
            $postdata['status'] = 1;
            $postdata = json_encode($postdata);
            $this->update_firebase($postdata, 'new_request', $temp_driver);

            //send push notification to user
            $provider = $this->deliverypartners->find($temp_driver);
            if (isset($provider->device_token) && $provider->device_token != '') {
                $title = $message = trans('constants.new_order');
                $this->user_send_push_notification($provider->device_token, $provider->device_type, $title, $message, $request_id);
            }


            // end of request to driver
            return redirect()->back();
        } else {
            # code...
            $title = "No Providers available";
            // $message = array();
            // $message['title'] = "Taxi Request";
            // $message['body'] = "No Providers available";
            // $this->send_push_notification($request->header('authId'), $title, $message);

            return redirect()->back();
        }
    }
}
