<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('index');
Route::get('/admin', 'HomeController@dashboard');
//Route::get('register', 'RegisterController@register_view')->name('register');
Route::get('login', 'LoginController@login_view')->name('login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout')->name('logout');

//Fontend routes
Route::get('/', 'IndexController@home')->name('home');
Route::get('resturant/view/{id}', 'IndexController@resturantDetail')->name('resturant.detail');
Route::get('product/view/{id}', 'IndexController@proDetail')->name('pro.detail');
Route::get('cart', 'IndexController@cartDeatil')->name('cart.detail');
Route::get('user/login', 'IndexController@Login')->name('user.login');
Route::get('user/forgot', 'IndexController@forgot')->name('user.forgot');
Route::post('user/forgot-password', 'IndexController@forgotPassword')->name('forgot');
Route::get('signup', 'IndexController@SignUp')->name('user.signup');
Route::post('signup', 'IndexController@register')->name('new.signup');
Route::get('about-us', 'IndexController@about')->name('about.us');
Route::post('contact-us', 'ContactController@ContactUs')->name('contact');
Route::get('contact-us', 'IndexController@contact')->name('contact.us');
Route::get('user-logout', 'IndexController@logout')->name('user.logout');
Route::get('terms-and-conditions', 'IndexController@terms')->name('terms.conditions');
Route::get('return-policy', 'IndexController@refundPolicy')->name('refund.policy');
Route::get('profile', 'IndexController@profile')->name('user.profile');
Route::post('cart', 'IndexController@addToCart')->name('cart');
Route::post('voucher', 'IndexController@checkVoucher');
Route::get('/cart/deleteItem/{id}','IndexController@deleteItem')->name('cart.item');
Route::put('/cart/update/{cart}','IndexController@updateItem')->name('cart.update');
Route::get('checkout', 'IndexController@Checkout')->name('checkout.detail');
Route::post('/checkout/order', 'IndexController@getOrders')->name('place.order');
Route::get('/cart/checkout/stripe', 'IndexController@stripe')->name('stripe');
Route::post('/cart/checkout/stripe', 'IndexController@stripePost')->name('stripe.post');
Route::get('/cart/checkout/thankyou', 'IndexController@thanks')->name('thanks');
Route::get('/search/', 'IndexController@searchResult')->name('serach');
Route::post('paypal', 'PaypalController@payWithpaypal');
// route for check status of the payment
Route::get('status', 'PaypalController@getPaymentStatus');
Route::get('driver/registration', 'DriverController@driver')->name('driver');
Route::post('driver/registration', 'DriverController@driverRegistration')->name('driver.register');
Route::get('partner/registration', 'PartnerController@partner')->name('partner');
Route::post('partner/registration', 'PartnerController@partnerRegistration')->name('partner.register');
Route::get('restaurants/cuisine/{id}', 'IndexController@restaurantByCuisine')->name('restaurant.cuisine');


Route::group(['prefix' => 'admin', 'namespace' => 'admin', 'middleware' => ['auth', 'admin']], function () {

//    Route::get('/', 'HomeController@home')->name('admin.home');
    Route::resource('/', 'DashboardController');
    Route::get('all-products', 'HomeController@totalPro')->name('total.pro');
    Route::resource('restaurant', 'RestaurantController');
    Route::get('pending', 'RestaurantController@pending')->name('admin.pending');
    Route::get('get_service_charges/{restaurant}', 'RestaurantController@get_service_charges')->name('admin.get_service_charges');
    Route::post('set_service_charges/{restaurant}', 'RestaurantController@set_service_charges')->name('admin.set_service_charges');
    Route::get('change_restaurant_active_status/{restaurant}', 'RestaurantController@change_restaurant_active_status')->name('admin.change_restaurant_active_status');
    Route::get('change_restaurant_featured_status/{restaurant}', 'RestaurantController@change_restaurant_featured_status')->name('admin.change_restaurant_featured_status');
    Route::resource('cuisine', 'CuisineController');
    Route::resource('news', 'NewsController');
    Route::get('news-notification/{news}', 'NewsController@sentNotification')->name('send.notification');
    Route::resource('driver', 'DriverController');
    Route::get('change_driver_active_status/{driver}', 'DriverController@change_driver_active_status')->name('admin.change_driver_active_status');
    Route::get('get_hourly_pay/{driver}', 'DriverController@get_hourly_pay')->name('admin.get_hourly_pay');
    Route::post('set_hourly_pay/{driver}', 'DriverController@set_hourly_pay')->name('admin.set_hourly_pay');
    // Charges
    Route::resource('charge', 'ChargeController');

    Route::resource('vehicle', 'VehicleController');

    Route::resource('extras', 'ExtrasController');
    Route::resource('user', 'UserController');
    Route::get('change_block_status/{user}', 'UserController@change_block_status')->name('admin.change_block_status');
    //orders
    Route::get('all_orders', 'OrderController@all_orders')->name('admin.all_orders');
    Route::get('complete_orders', 'OrderController@complete_orders')->name('admin.complete_orders');
    Route::get('prepaire_orders', 'OrderController@prepaire_orders')->name('admin.prepaire_orders');
    Route::get('cancel_orders', 'OrderController@cancel_orders')->name('admin.cancel_orders');
    Route::get('pending_orders', 'OrderController@pending_orders')->name('admin.pending_orders');
    Route::get('schedule_orders', 'OrderController@schedule_orders')->name('admin.schedule_orders');
    Route::post('cancel_order/{order}', 'OrderController@cancel_order')->name('admin.cancel_order');
    Route::get('assign_order/{order}', 'OrderController@assign_order')->name('admin.assign_order');
    Route::get('show_order/{order}', 'OrderController@show_order')->name('admin.show_order');
    Route::get('show_completed_order/{order}', 'OrderController@show_completed_order')->name('admin.show_completed_order');
    Route::get('deliver_order/{order}', 'OrderController@deliver_order')->name('admin.deliver_order');
    Route::post('assign_driver', 'OrderController@assign_driver')->name('admin.assign_driver');
    Route::post('prepaire_order', 'OrderController@prepaire_order')->name('admin.prepaire_order');
    //orders
    //payouts
     Route::get('restaurant_payout', 'PayoutController@restaurant_payout')->name('restaurant_payout');
    Route::get('driver_payout', 'PayoutController@driver_payout')->name('driver_payout');
    Route::post('restaurant_pay', 'PayoutController@restaurant_pay')->name('restaurant_pay');
    Route::post('driver_pay', 'PayoutController@driver_pay')->name('driver_pay');
    //profile
    Route::get('profile', 'UserController@profile')->name('admin.profile');
    Route::post('profile/update', 'UserController@passwordUpdate')->name('admin.profile_update');
});

Route::group(['prefix' => 'restaurant', 'namespace' => 'restaurant', 'middleware' => ['auth', 'restaurant']], function () {
    //profile
    Route::get('profile', 'UserController@profile')->name('profile');
    Route::get('delivery_boundary', 'HomeController@delivery_boundary')->name('delivery_boundary');

    Route::post('profile/profile_update', 'UserController@profile_update')->name('profile.profile_update');
    Route::resource('/', 'DashboardController');
    //category
    Route::resource('category', 'CategoryController');
    Route::post('category/search/{category}', 'CategoryController@search')->name('category.search');
    Route::get('notifications/{id}','DashboardController@notifications');
    //AddOns
    Route::resource('add-on', 'AddOnsController');
    // vouchers
    Route::resource('voucher','VoucherController');
    //products
    Route::resource('product', 'ProductController');
    Route::resource('optional', 'OptionalController');
    Route::resource('required', 'RequiredController');
    Route::get('change_product_featured_status/{product}', 'ProductController@change_product_featured_status')->name('restaurant.change_product_featured_status');
    //orders
    Route::get('all_orders', 'OrderController@all_orders')->name('restaurant.all_orders');
    Route::get('complete_orders', 'OrderController@complete_orders')->name('restaurant.complete_orders');
    Route::get('cancel_orders', 'OrderController@cancel_orders')->name('restaurant.cancel_orders');

    Route::post('prepaire_order', 'OrderController@prepaire_order')->name('restaurant.prepaire_orders');
    Route::get('all-preparing-orders', 'OrderController@getPreparingOrders')->name('restaurant.getpreparing');

    Route::get('assigned_orders', 'OrderController@pending_orders')->name('restaurant.pending_orders');
    Route::get('schedule_orders', 'OrderController@schedule_orders')->name('restaurant.schedule_orders');
    Route::get('cancel_order/{order}', 'OrderController@cancel_order')->name('restaurant.cancel_order');
    Route::get('assign_order/{order}', 'OrderController@assign_order')->name('restaurant.assign_order');
    Route::get('show_order/{order}', 'OrderController@show_order')->name('restaurant.show_order');
    
    Route::get('prepaire_order/{order}', 'OrderController@prepaire_order')->name('restaurant.prepaire_order');
    Route::get('deliver_order/{order}', 'OrderController@deliver_order')->name('restaurant.deliver_order');
    Route::post('assign_driver', 'OrderController@assign_driver')->name('restaurant.assign_driver');
    //payment
    Route::resource('r_earnings', 'PaymentHistoryController');
    //employee
    Route::resource('employee', 'EmployeeController');
    //working hours
    Route::resource('working_hour', 'WorkingHourController');


});
Route::group(['prefix' => 'restaurant/delivery', 'namespace' => 'Delivery', 'middleware' => ['auth', 'delivery']], function () {
    Route::resource('/', 'DashboardController');
    //orders
    Route::get('all_orders', 'OrderController@all_orders')->name('delivery.all_orders');
    Route::get('complete_orders', 'OrderController@complete_orders')->name('delivery.complete_orders');
    Route::get('cancel_orders', 'OrderController@cancel_orders')->name('delivery.cancel_orders');
    Route::get('pending_orders', 'OrderController@pending_orders')->name('delivery.pending_orders');
    Route::get('schedule_orders', 'OrderController@schedule_orders')->name('delivery.schedule_orders');
    Route::post('cancel_order/{order}', 'OrderController@cancel_order');
    //payment
    Route::resource('d_earnings', 'PaymentHistoryController');

});
