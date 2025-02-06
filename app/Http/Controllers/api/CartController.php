<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Charge;
use App\Product;
use App\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
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
    public function addToCart(Request $request)
    {
         $validator = Validator::make(
            $request->all(),
            array(
                'restaurant_id'=>'required',
                'user_id' => 'required',
                'product_id' => 'required',
                'product_name' => 'required',
                'qty'=>'required',
                'price' => 'required'
            ));

            $getRestaurant=Restaurant::find($request->restaurant_id);
            
            $checkUser=Cart::where('user_id',$request->user_id)->first();
                
            $cart = new Cart;
           
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } 
        else{
            
            if($checkUser==NULL){

                $cart->restaurant_id = $request->restaurant_id;
                $cart->user_id = $request->user_id;
                $cart->product_id = $request->product_id;
                $cart->product_name = $request->product_name;
                $cart->qty = $request->qty;
                $cart->instructions = $request->instructions;
                $cart->price = $request->price;
        
                $cart->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Successfully Added!'
                    ]);
            }
            elseif($checkUser && $checkUser->restaurant_id==$request->restaurant_id){
                $cart->restaurant_id = $request->restaurant_id;
                $cart->user_id = $request->user_id;
                $cart->product_id = $request->product_id;
                $cart->product_name = $request->product_name;
                $cart->qty = $request->qty;
                $cart->instructions = $request->instructions;
                $cart->price = $request->price;
        
                $cart->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Successfully Added!'
                    ]);
            }
            else{

                if($checkUser->restaurant_id!=$request->restaurant_id){
                     return response()->json([
                         'status' => false,
                         'message' => 'Do you want to delete previous record from cart!',
                     ]);
                }

            }
        }
    }

    public function showCartDetail($user)
        {

        //get cart where user_id = 12
        $cartDetail=Cart::where('user_id',$user)->get();

        

        $cartRestIDs=$cartDetail->pluck('restaurant_id')->toArray();
        $cartProIDs=$cartDetail->pluck('product_id')->toArray();
        $cartUserIDs=$cartDetail->pluck('user_id')->toArray();

     
     $restDetail=DB::table('carts')
     ->join('restaurants', 'restaurants.id', '=', 'carts.restaurant_id')
     ->join('products', 'products.id', '=', 'carts.product_id')
     ->select('carts.id','carts.qty','carts.product_id','carts.user_id','carts.restaurant_id','carts.price','carts.instructions','carts.product_name','products.image')
     ->where('carts.user_id',$user)
     ->get();
      $charges=Charge::first();
   
            
            return response()->json([
                'status' => true,
                'data' => $restDetail,
                'charges' =>$charges
            ]);
            
        }

    public function deletePreviousCart($user)
    {
       $getResData=Cart::where('user_id',$user)->delete();
       return response()->json([
           'status' =>true,
           'message' =>'Cart deleted Successfully!'
           ]);
    }
    
    public function deleteCartProduct($cart)
    {
        $getProduct=Cart::find($cart);
        $getProduct->delete();
        return response()->json([
           'status' =>true,
           'message' => 'Data deleted Successfully'
           ]);

    }
    
     public function UpdateCartDetail(Request $request)
    {
        $cart=$request->cart_id;
        $getQty=$request->qty;
        $getCart=Cart::find($cart);

        ///multipel price*qty
        
if($getQty>0){
$getCart->qty= $getQty;
        $getCart->save();
      return response()->json([
'status' =>true,
'message' => 'Updated Successfully!'

]);   
}
elseif($getQty<=0){
             $getCart->delete();

             return response()->json([
'status' =>true,
'message' => 'deleted Successfully!'

]);

        }

    }
}
