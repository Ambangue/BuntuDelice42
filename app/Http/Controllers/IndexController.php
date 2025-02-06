<?php

namespace App\Http\Controllers;

use App\Cuisine;
use App\Restaurant;
use App\Rating;
use App\Order;
use App\Product;
use App\Category;
use App\Cart;
use App\User;
use App\Charge;
use App\Voucher;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{

    public function home()
    {
        $restaurants=Restaurant::with('cuisines')->limit(4)->get();
        $products=Product::limit(20)->get();
        foreach ($restaurants as $restaurant) {
        $restaurant['ratings'] =number_format( $restaurant->ratings()->avg('rating'));
          }
    //dd($restaurants);
        return view('frontend.index', compact('restaurants','products'));
    }
    public function resturantDetail($id)
    {
        $restaurant=Restaurant::where('id',$id)->with('cuisines')->with('products')->first();
        $restaurant['ratings'] = number_format($restaurant->ratings()->avg('rating'));
        $cuisines=Cuisine::get();
        $abc=Category::where('restaurant_id',$id)->with(['products' => function($q) use ($id) {
                        $q->where('restaurant_id',$id);
                    }])->get();
        //dd($abc);
        return view('frontend.menu', compact('restaurant', 'cuisines','abc'));
    }

    public function proDetail($id)
    {
         $proDetail=Product::findOrFail($id);
         $restaurant=Restaurant::findOrFail($proDetail->restaurant_id);

        $products=Product::get();
        //dd($getReq);
        return view('frontend.product_detail', compact('products', 'proDetail', 'restaurant'));
    }
    public function cartDeatil()
    {
      if(!auth()->check()){
              return view('frontend.login');
          }
          else{
        $id=auth()->user()->id;
        $cartData=DB::table('carts')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.*', 'products.image', 'products.name', 'products.description')->where('user_id',$id)->get();
            
        $total=Cart::where('user_id',$id)->sum(\DB::raw('price * qty'));
        $rest_id=Cart::where('user_id',$id)->first();
        if($rest_id)
        {
        $check=Restaurant::findOrFail($rest_id->restaurant_id);
        }
        else{
           $check=null; 
        }
        
        //dd($check);
        return view('frontend.cart', compact('cartData', 'total', 'check'));
      }
    }
    public function deleteItem($id=null){
        $delete_item=Cart::findOrFail($id);;
        $delete_item->delete();
        return back()->with('message','Deleted Success!');
    }

    public function updateItem(Request $request, $cart){

        $cart=Cart::find($cart);
        $cart->qty = $request->qty;
        $cart->update();
       return back()->with('message','Update Quantity already');

    }

    public function Login()
    {
        if (auth()->check())
            return redirect('/');
        return view('frontend.login');
    }
    public function SignUp()
    {
        if (auth()->check())
            return redirect('/');
        return view('frontend.signup');
    }
    
     public function register(Request $request)
    {
        $request->validate([
                'name'=>'nullable',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required',
                'phone'=>'required|unique:users',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
                'type' => 'nullable|in:user,admin','restaurant',
            ]);

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
                    
            $data = array(
            'name' => $user->name,
            'email' => $user->email,
        );
            $message="Dear User, Your signup was successfully received. We value you as our customer, and we welcome your order requests, as You Shop, We Drop. It is our aim to fill as many orders as we possible can and at the same time to provide exceptional customer service. So during the process, feel free to let us know how we are doing, and where you would like to see us improve. Thank you for signing up and being apart of The Drop. Regards, The Drop Team";
            //sending email
            Mail::to($request->email)->send(new RegisterEmail($data));
                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollBack();
                    return response()->json([
                        'message' => $exception->getMessage()
                    ], 403);
                }
                return back()->with('message','Successfully Registered!');
            }
    
    
   public function Checkout(){
    if(!auth()->check()){
              return view('frontend.login');
          }
          else{
       $id=auth()->user()->id;
        $checkoutData=DB::table('carts')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.*', 'products.image', 'products.name', 'products.description')->where('user_id',$id)->get();
            $name=$checkoutData->pluck('name')->toArray();
            $qty=$checkoutData->pluck('qty')->toArray();
            //dd($qty);
        $total=Cart::where('user_id',$id)->sum(\DB::raw('price * qty'));
        $resturant=Cart::where('user_id',$id)->first();
        $charges=Charge::first();
        $address=DB::table('user_address')->where('user_id',$id)->first();

       return view('frontend.checkout' , compact('checkoutData', 'total', 'charges', 'address', 'name', 'qty','resturant'));
     }
   }
   public function profile(){
       if (auth()->check())
       return view('frontend.profile');
       else
       return redirect('/');
   }

   public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function thanks(){
        $order = Order::where('order_no', $_GET['orderID'])->first();
        if($order){
            Cart::where('user_id', $order->user_id)->delete();
            return view('frontend.thanks', compact('order')); 
            }else{
            abort('404'); 
            }
   }

    public function addToCart(Request $request){

        $inputToCart=$request->all();
         if(!auth()->check()){
              return view('frontend.login');
          }
        elseif($inputToCart['qty']==""){
            return back()->with('message','Please Select Quantity');
        }
        else{
                $count_duplicateItems=Cart::where(['product_id'=>$inputToCart['product_id']])->where(['user_id'=>$inputToCart['user_id']])->count();
                if($count_duplicateItems>0){
                    $updateQty=Cart::where(['product_id'=>$inputToCart['product_id']])->where(['user_id'=>$inputToCart['user_id']])->first();
                    $updateQty->increment('qty',$inputToCart['qty']);
                    return back()->with('message','Product Updated!');
                }
                else{
                    Cart::create($inputToCart);
                    return back()->with('message','Add To Cart Already');
                }
            }
        }

        public function forgotPassword(Request $request)
        {
          $request->validate([
              'email'=>'required',
              'phone'=>'required',
              'password'=>'required',
            ]);
            $user=User::where('phone',$request->phone)->where('email',$request->email)->first();
            
            if($user){
                $request['password'] = bcrypt($request->password);
            $user->password=$request->password;
            $user->save(); 
            return back()->with('message','Password Updated Successfully!');
                
            }
            else{
                return back()->with('message','Email or phone invalid!');
            }

        }


     public function searchResult(Request $request)
        {
              $request->validate([
                'qurey'=>'required',
                ]);
                $qurey=$request->qurey;
          $restaurants=Restaurant::with('cuisines')->where('address', 'LIKE', "%{$request->qurey}%")
          ->orWhere('name', 'LIKE', "%{$request->qurey}%")
          ->get();

          foreach ($restaurants as $restaurant) {
              $restaurant['ratings'] = $restaurant->ratings()->avg('rating');
          }

            return view('frontend.search', compact('restaurants', 'qurey'));
        }

    public function about()
    {
        return view('frontend.about');

    }
    public function contact()
    {
        return view('frontend.contact');
    }
    public function terms()
    {
        return view('frontend.terms');
    }
    public function refundPolicy()
    {
        return view('frontend.policy');
    }
    
    public function forgot()
    {
        return view('frontend.forgot');

    }
    
    
    public function restaurantByCuisine($id)
    {
        $cuisines=Cuisine::with('restaurants')->find($id);
        
        return view('frontend.restaurant_by_cuisines', compact('cuisines'));

    }
     public function checkVoucher(Request $request){
         $vouchers=Voucher::where('name',$request->voucher)->where('restaurant_id',$request->restaurant)->first();
         if($vouchers){
             $message='';
         }
         else{
             $message='Invalid or expired voucher';
         }
         
         return response()->json([
               'data' => $vouchers,
               'message' => $message
           ]);
         
     }
 
}
