<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Driver;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

if (!defined('BASE_URL_PROFILE')) define('BASE_URL_PROFILE',URL::to('/').'/images/profile_images/');

class ReviewController extends Controller
{
    public function driverReviews($driver)
    {
        $reviews=Driver::find($driver);
         $reviews['reviews']=DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select('users.image', 'users.name', 'reviews.rating', 'reviews.reviews')
            ->get();
            $avgStar = Review::where('driver_id',$driver)->avg('rating');
            $count = DB::table('completed_orders')
            ->where('driver_id',$driver)
             ->select('created_at', DB::raw('count(*) as trips'))
             ->groupBy('created_at')
             ->get()->count();
         
        return response()->json([
            'status' => true,
            'data' =>$reviews,
            'rating' =>$avgStar,
            'trips' =>$count,
            'BASE_URL_PROFILE'=>BASE_URL_PROFILE,
            ]);
    }
    
    public function sendDriverReviews(Request $request)
    {
        $driverId=$request->driver_id;
        $userId=$request->user_id;
        $userRating=$request->rating;
        $userReview=$request->review;
        $reiews = new Review;

        $reiews->driver_id = $request->driver_id;
        $reiews->user_id = $request->user_id;
        $reiews->reviews = $request->reviews;
        $reiews->rating = $userRating;

        $reiews->save();
        
        return response()->json([
            'status' =>true,
            
            ]);
    }
}
