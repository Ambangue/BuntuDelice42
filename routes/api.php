<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['namespace'=>'api'],function() {
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@login');
    Route::get('user_profile/{user}', 'UserController@profile');
    Route::post('update_profile/', 'UserController@updateProfile');
    Route::post('forgot_password', 'UserController@forgotPassword');
    Route::post('add_user_address', 'UserController@addUserAddress');
    Route::get('get_user_address/{user}', 'UserController@getUserAddress');
    Route::post('track_pendings_orders', 'UserController@trackOrders');
     Route::post('track_completed_orders', 'UserController@trackCompletedOrders');
     Route::post('reviews_and_ratings', 'UserController@sendReviewsToRestaurant');
     Route::post('user_device_token','UserController@userDeviceToken');

//Dirver's APIs

    Route::post('driver_register', 'DriverController@register');
    Route::post('driver_login', 'DriverController@login');
    Route::get('driver_profile/{driver}', 'DriverController@profile');
    Route::post('driver_update_profile/', 'DriverController@updateProfile');
    Route::post('driver_forgot_password', 'DriverController@forgotPassword');
    Route::post('set_driver_online/{driver}', 'DriverController@SetDriverOnline');
    Route::get('set_driver_offline/{driver}', 'DriverController@SetDriverOffline');
    Route::post('set_time_for_online', 'DriverController@SetDriverOnlineTime');
    Route::get('order_request/{dirver}', 'DriverController@orderRequests');
    Route::post('order_accept_by_driver', 'DriverController@acceptOrderRequests');
    Route::get('ordered_product/{orderno}', 'DriverController@ordersProducts');
    Route::get('driver_reviews/{dirver}', 'ReviewController@driverReviews');
    Route::post('driver_earning_history/{dirver}', 'DriverController@driverEarningHistory');
    
    
    //Home APIs
     Route::post('home_data','IndexController@index');
     Route::get('product_detail/{product}','IndexController@proDetail');
     Route::post('search_filters', 'IndexController@searchFilter');
     Route::post('search_by_keyword','IndexController@searchQurey');
    Route::get('restaurant_detail/{restaurant}','IndexController@restaurantDetail');

//Cart's APIs
    Route::post('add_to_cart','CartController@addToCart');
    Route::get('show_cart_details/{user}','CartController@showCartDetail');
    Route::post('update_cart_details','CartController@UpdateCartDetail');
    Route::delete('delete_cart_product/{cart}','CartController@deleteCartProduct');
    Route::delete('delete_previous_cart/{user}','CartController@deletePreviousCart');
    
    
    //Orders APIs
    Route::post('place_orders/','OrderController@getOrders');
    Route::get('user_pending_orders/{user}', 'OrderController@UserOrderHistory');
    Route::get('user_completed_order_history/{user}', 'OrderController@UserCompletedOrderHistory');
    Route::post('complete_orders', 'OrderController@completeOrders');
    
    
    //Restaurant's APIs
     Route::post('search_restaurant','RestaurantController@search');
      Route::get('restaurants_with_category/{cuisine}', 'RestaurantController@restaurantsByCuisine');
    Route::get('get_filters', 'RestaurantController@sendFilters');
    Route::get('about_restaurant/{restaurant}', 'RestaurantController@restaurantAbout');
    
      //Vouchers
    Route::post('get_voucher', 'VoucherController@getVoucher');
    
      
     ///Reasons
     Route::get('get_reason', 'ReasonController@getReason');
     Route::post('reject_order_request', 'ReasonController@rejectOrderRequests');
     
     Route::get('delivery_summary/{driver}', 'DriverController@deliverySummary');
     Route::get('latest_news', 'DriverController@latestNews');
     
});
