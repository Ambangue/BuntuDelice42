<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cuisine;
use App\Product;
use App\Extra;
use App\Rating;
use App\AddOnTitle;
use App\Restaurant;
use App\Order;
use App\Optional;
use App\Required;
use App\Category;
use App\SearchFilter;
use Illuminate\Support\Facades\URL;
use DB;
use Illuminate\Support\Facades\Validator;


if (!defined('BASE_URL_PRODUCT')) define('BASE_URL_PRODUCT',URL::to('/').'/images/product_images/');
if (!defined('BASE_URL_RESTAURANT')) define('BASE_URL_RESTAURANT',URL::to('/').'/images/restaurant_images/');
if (!defined('BASE_URL_CUISINE')) define('BASE_URL_CUISINE',URL::to('/').'/images/cuisine/');

class IndexController extends Controller
{
   public function index(Request $request,$radius = 1000)
   {
        $latitude=31.4644341;
        $longitude=74.2416731;
        $nearbyRestaurants = Restaurant::selectRaw("id, name, address, latitude, longitude, slogan, logo, city,cover_image,
                     ( 6371 * acos( cos( radians(?) ) *
                       cos( radians( latitude ) )
                       * cos( radians( longitude ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( latitude ) ) )
                     ) AS distance", [$latitude, $longitude, $latitude])
        
        ->orderBy("distance",'asc')
        ->limit(20)
        ->get();

   	$trendingCuisine=Cuisine::get();
   	$trendingProduct=DB::table('products')
            ->join('restaurants', 'restaurants.id', '=', 'products.restaurant_id')
            ->select('products.id','products.name as product_name','products.category_id','products.price','products.featured','products.image','restaurants.id as restaurant_id', 'restaurants.name as resturant_name')
            ->get();
   	$featuredRestaurant=Restaurant::selectRaw("id, name as restuarant_name, address, latitude, longitude, slogan, logo, city,cover_image,
        ( 6371 * acos( cos( radians(?) ) *
          cos( radians( latitude ) )
          * cos( radians( longitude ) - radians(?)
          ) + sin( radians(?) ) *
          sin( radians( latitude ) ) )
        ) AS distance", [$latitude, $longitude, $latitude])
->where('featured', '=', 1)

->orderBy("distance",'asc')
->limit(20)
->get();
   return response()->json([
   	'status' =>true,
   	'featuredRestaurants' =>$featuredRestaurant,
   	'trendingCuisine' =>$trendingCuisine,
   	'trendingProduct' =>$trendingProduct,
     'nearbyRestaurants' =>$nearbyRestaurants,
     'BASE_URL_PRODUCT'=>BASE_URL_PRODUCT,
     'BASE_URL_RESTAURANT'=>BASE_URL_RESTAURANT,
     'BASE_URL_CUISINE'=>BASE_URL_CUISINE,
   ]);
   }

   public function searchQurey(Request $request)
   {
   	$validator = Validator::make(
            $request->all(),
            array(
                'qurey'=>'required',
            ));
         $searchTerm=$request->qurey;
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } 
        else {
        	$resultData=DB::table('restaurants')
        ->where('name', 'like', '%'.$searchTerm.'%')->
        orWhere('keywords','%'.$searchTerm.'%')
        ->get();

   return response()->json([
   	'status' =>true,
   	'search' =>$resultData,
   ]);
        }
   }
   public function restaurantDetail($restaurant)
   {
        $restaurantDetail=Restaurant::find($restaurant);
        $RestaurantCate=Category::with('products')->where('restaurant_id',$restaurant)->get();
        return response()->json([
        'status'=> true,
        'data' =>$restaurantDetail,
        'categoryWithPro' =>$RestaurantCate,
        ]);
   }

   public function proDetail($id)
   {
        $proDetail=Product::findOrFail($id);
         
         $getReq=Required::where('product_id',$id)->get();
         $getOptional=Optional::where('product_id',$id)->get();
         
        //  $proDetail['addOns']=$getAddOn;
        //  $proDetail['optional']=$getOptional;
         
         
         if(empty($getReq) OR $getReq==null OR $getReq=''){
             $getAddOn=null;
         }
         else{
             $getAddOn=AddOnTitle::select('id','title')->with(['requireds' => function($q) use ($id) {
                        $q->where('product_id', '=', $id);
                    }])->get();
               $proDetail['addOns']=$getAddOn;
         $proDetail['optional']=$getOptional;
         }
        
              
         
       // $proDetail['titles']=AddOnTitle::with('requireds')->where('product_id',$id)->get();
       
        return response()->json([
          'status'=> true,
          'data' => $proDetail,
          ]);
   }
    public function searchFilter(Request $request)
    {
            $getOffers = $request->offers;
            $getCuisines = $request->cuisines;
            
            $offers=str_replace(array( '[', ']' ), '', $getOffers);
            $offersArray = explode(',', $offers);

            $cuisines=str_replace(array( '[', ']' ), '', $getCuisines);
            $cuisinesArray = explode(',', $cuisines);

            $getname=SearchFilter::select("id","name")->whereIn('id', $offersArray)->get();

            $getCuisi=SearchFilter::select("id","name")->whereIn('id', $cuisinesArray)->get();
            $names=$getCuisi->pluck('name')->toArray();
        if($offersArray!="" && $offersArray!=null){

                 foreach ($getname as $key) {

                  if(!empty($key->name))
                  {
                    if($key->name == 'Free Delivery')
                    {
                      $search_conditions[]='delivery';
                    }
                    if ($key->name == 'Deal') {
                      $search_conditions[]='deal';
                    }
                    if ($key->name == 'Accept Vouchers') {
                      $search_conditions[]='vouchers';
                    }
                    
                  }

                    $query = "SELECT * FROM restaurants";

                    if(!empty($search_conditions))
                    {
                      $query .= " where ";

                      $query .= implode(" = 'yes' or  ",$search_conditions)." = 'yes'";
                      
                      $results = DB::select( DB::raw($query));
                      
                    }
                 }
        }
                  if($cuisinesArray!="" && $cuisinesArray!=null){
                    
                    $fetchCuisines=Cuisine::whereIn('name',$names)->get();
                    $iDs=$fetchCuisines->pluck('id')->toArray();
                    $restaurantGet=DB::table('cuisine_restaurant')->whereIn('cuisine_id',$iDs)->get();
                    $restiDs=$restaurantGet->pluck('restaurant_id')->toArray();
                    $rest=Restaurant::with('ratings')->whereIn('id',$restiDs)->get()->toArray();
                   
                  }
                  
                  if(empty($results)){
                      $results = array();
                  }
                  
               $getFinal=array_merge($results,$rest);  
         
             return response()->json([
               'data' => $getFinal
            ]);
            
                  

    }
}
