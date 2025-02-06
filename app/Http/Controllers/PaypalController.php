<?php
namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PaypalController extends Controller
{
    public function index()
    {
        return view('paywithpaypal');
    }
    public function payWithpaypal(Request $request)
    {
        $this->store($request);
        return $this->processTransaction($request);
    }

    

    public function store($request)
    {
        $tax = $request->tax;
        $delivery_charges = $request->delivery_charges;
        $driver_tip = $request->driver_tip;
        $delivery_address = $request->delivery_address;
        $d_lat = $request->d_lat;
        $d_lng = $request->d_lng;
        $sub_total = $request->sub_total;
        $total = $request->amount;
        $id = auth()->user()->id;
        $datas = Cart::where('user_id', $id)->get();
        $orderNo = 'TD-' . rand(1000000, 9999999);
        foreach ($datas as $data) {
            DB::table('orders')->insert([
                'user_id' => $id,
                'restaurant_id' => $data->restaurant_id,
                'product_id' => $data->product_id,
                'qty' => $data->qty,
                'driver_id' => null,
                'order_no' => $orderNo,
                'offer_discount' => 4,
                'tax' => $tax,
                'delivery_charges' => $delivery_charges,
                'sub_total' => $sub_total,

                'total' => $total,
                'admin_commission' => 2,
                'restaurant_commission' => 4,
                'driver_tip' => $driver_tip,
                'delivery_address' => $delivery_address,
                'scheduled_date' => null,

                'd_lat' => $d_lat,
                'd_lng' => $d_lng,
                'ordered_time' => Now(),
                'delivered_time' => Now(),
                'created_at' => now(),
            ]);
        }
        $request->session()->put('order_id', $orderNo);
    }


    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        try{
           $order = Order::where('order_no', Session::get('order_id'))->first();
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/oauth2/token',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Basic QWRBajN1ZV9ST2ZvRzViYVd3N1ZRRjBGZE5hS0N2bEdLd09MSEpNbEtXbVA0dFRITnZqd0tHZDlrQWNaeVIyenEyNy0ydlNEbFZBMldtYjg6RUV5dWcwWDJMSXk3aFNwYW9DYkJTR0FNdzltbm12Sy1uNkJZTkIzRjlJcjh0cTlwQ2pnNUhTRkdJd0xrMFQxcGlZQl9IeWlvOHdkZjBqaXY=',
                'Content-Type: application/x-www-form-urlencoded'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response2 = json_decode($response);
            $token = $response2->access_token;
            $data = [
                'order_id' => $order->id,
                'token' => $token,
                'amount' => $order->total,
                'code' => $order->order_no

            ];
            
            $resp = $this->paypalAuth($data);
            
            $resp2 = json_decode($resp);
            $resp_link = $resp2->links;
            return redirect($resp_link[1]->href);
            } catch (Exception $e) {
            Log::info($e->getMessage());
        }
       
    }
    public function paypalAuth($data)
    {
        try{
        $price = str_replace( ',', '',number_format($data['amount'],2));

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v2/checkout/orders',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "intent": "CAPTURE",
          "purchase_units": [
            {
              "reference_id": "d9f80740-38f0-11e8-b467-0ed5f89f718b",
              "amount": {
                "currency_code": "USD",
                "value": "'.$price.'"
              }
            }
          ],
          "payment_source": {
            "paypal": {
              "experience_context": {
                "payment_method_preference": "IMMEDIATE_PAYMENT_REQUIRED",
                "payment_method_selected": "PAYPAL",
                "brand_name": "Mangrove",
                "locale": "en-US",
                "landing_page": "LOGIN",
                "shipping_preference": "NO_SHIPPING",
                "user_action": "PAY_NOW",
                "return_url": "'.route("thanks").'?orderID='.$data['code'].'",
                "cancel_url": "'.route("cart").'"
              }
            }
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$data['token'],
            'Content-Type: application/json',
            'PayPal-request-id: '.rand(1000000,9999999)
          ),
        ));

        $response = curl_exec($curl);
        \Log::info($response);
        $tok = json_decode($response)->id;
        curl_close($curl);

        //Update trxId
        // Order::where("id", $data['order_id'])->update(["transaction_id" => $tok]);

        return $response;
    } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}
