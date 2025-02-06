<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Restaurant;
use App\Cuisine;
use App\Filter;
use App\Rating;
use App\SearchFilter;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

if (!defined('BASE_URL_PROFILE')) define('BASE_URL_PROFILE',URL::to('/').'/images/profile_images/');

class RestaurantController extends Controller
{
    public function search(Request $request)
    {
    	$validator = Validator::make(
            $request->all(),
            array(
                'query'=>'required',
            ));
           
        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('status' => false, 'error_code' => 101, 'message' => $error_messages);
        } 
        else{
              $restaurants = Restaurant::where('name','like','%'.$request->get('query').'%')->get();
              foreach ($restaurants as $restaurant) {
                $restaurant['ratings'] = $restaurant->ratings()->avg('rating');
                  }
                
            }
            return response()->json([
            	'status' => true,
             'data' => $restaurants
            ]);
    }
    public function restaurantsByCuisine($cuisine)
    {
    	$get=Cuisine::find($cuisine);
    	$res=$get->restaurants()->select('restaurant_id','name','city','phone','address','cover_image','logo','slogan','latitude','longitude')->get();
    	return response()->json([
           'status' => true,
           'data' => $res
    	]);
    }
    
    public function sendFilters()
    {
        $filters=Filter::with('searchfilters')->get();
        return response()->json([
         'filter' => $filters
        ]);
    }
    
    public function restaurantAbout($restaurant)
   {
        $restaurantDetail=Restaurant::select('address','name','logo','cover_image','slogan')->with('working_hours')->find($restaurant);
        
        $restaurantDetail['reviews']=DB::table('ratings')
        ->join('users', 'users.id', '=', 'ratings.user_id')
            ->select('users.image', 'users.name', 'ratings.rating', 'ratings.reviews')
            ->where('restaurant_id',$restaurant)->get();
        $avg=DB::table('ratings')->where('restaurant_id',$restaurant)->avg('rating');
                 
        return response()->json([
        'status'=> true,
        'data' =>$restaurantDetail,
        'avg' =>$avg,
        'BASE_URL_PROFILE'=>BASE_URL_PROFILE,
        ]);
   }
   
}
