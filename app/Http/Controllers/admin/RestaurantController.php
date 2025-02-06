<?php

namespace App\Http\Controllers\admin;

use App\Cuisine;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\User;
use App\Order;
use App\CompletedOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('admin.restaurant.index')->with('restaurants', $restaurants);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.restaurant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'user_name' => 'required|string|max:191|unique:restaurants',
            'email' => 'required|string|unique:restaurants',
            'password' => 'required|string|min:6|max:191',
            'slogan' => 'required|string|max:191',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'city' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => 'required|string|max:191|unique:restaurants',
            'description' => 'required|string|max:191',
            'min_order' => 'nullable|integer',
            'avg_delivery_time' => 'nullable|integer',
            'account_name'=>'required|string',
            'account_number'=>'required|string',
            'bank_name'=>'required',
            'branch_name'=>'required',
        ]);
        $checkUser=User::where('email',$request->email)->first();
        if($checkUser){
          $alert['type'] = 'success';
        $alert['message'] = 'This email already taken!';
        return redirect()->back()->with('alert', $alert);  
        }
        $request['password'] = bcrypt($request->password);
        $request['type'] = 'restaurant';
        $request['services'] = 'both';
        $alert = [];
        //dd($request->all());
        $user = User::create($request->all());
        if ($user->type === 'restaurant'){
            $restaurant = $user->restaurant()->create($request->all());
            // dd($request);
        }
        if ($request->cuisine_id)
            $restaurant->cuisines()->attach([$request->cuisine_id]);
        $cover_image = $request->cover_image;
        $logo = $request->logo;
        $destination = 'images/restaurant_images';
        if ($request->hasFile('cover_image')) {
            $filename = strtolower(
                pathinfo($cover_image->getClientOriginalName(), PATHINFO_FILENAME)
                . '-'
                . uniqid()
                . '.'
                . $cover_image->getClientOriginalExtension()
            );
            $cover_image->move($destination, $filename);
            str_replace(" ", "-", $filename);
            $restaurant->cover_image = $filename;
            $restaurant->save();
        }
        if ($request->hasFile('logo')) {
            $file = strtolower(
                pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME)
                . '-'
                . uniqid()
                . '.'
                . $logo->getClientOriginalExtension()
            );
            $logo->move($destination, $file);
            str_replace(" ", "-", $file);
            $restaurant->logo = $file;
            $restaurant->save();
        }
        $alert['type'] = 'success';
        $alert['message'] = 'Restaurant Created Successfully';
        return redirect()->route('restaurant.index')->with('alert', $alert);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Restaurant $restaurant)
    {
        $cuisines = $restaurant->cuisines;
        $restaurant['ratings'] = number_format($restaurant->ratings()->avg('rating'));
        
$orders=CompletedOrder::select(DB::raw("(COUNT(*)) as count"),DB::raw('SUM(total) as totals'),DB::raw("MONTHNAME(created_at) as monthname"))
->where('restaurant_id', $restaurant->id)
->whereYear('created_at', date('Y'))
->groupBy('monthname')
->get();
$OrdersByYear=CompletedOrder::select(DB::raw("(COUNT(*)) as count"),DB::raw('SUM(total) as totals'),DB::raw("YEAR(created_at) as year"))
->where('restaurant_id', $restaurant->id)
->groupBy('year')
->get();
$OrdersByTotal=Order::where('restaurant_id', $restaurant->id)
->sum('total');

$OrdersByDay=Order::whereDate('created_at', Carbon::today())->where('restaurant_id', $restaurant->id)
->sum('total');
$OrdersByDayAvg=Order::where('restaurant_id', $restaurant->id)
->avg('total');
if($restaurant->admin_commission>0){
    $adminEarnings=($restaurant->admin_commission / 100) * $OrdersByTotal;
    $adminEarnByDay=($restaurant->admin_commission / 100) * $OrdersByDay;
    $adminEarnByAvg=($restaurant->admin_commission / 100) * $OrdersByDayAvg;
}
else{
    $adminEarnings=0.00;
    $adminEarnByDay=0.00;
    $adminEarnByAvg=0.00;
}
$getPendings=DB::table('orders')->where('status','pending')->where('restaurant_id', $restaurant->id)->count();
$getComleted=DB::table('completed_orders')->where('status','completed')->where('restaurant_id', $restaurant->id)->count();
$getCancel=DB::table('completed_orders')->where('status','cancelled')->where('restaurant_id', $restaurant->id)->count();

$totalorders=$getPendings+$getComleted+$getCancel;
if($totalorders!=0 || $totalorders!=null)
{
    $getPendingAvg=intval($getPendings/$totalorders*100);
$getCompletedAvg=intval($getComleted/$totalorders*100);
$getCanceledAvg=intval($getCancel/$totalorders*100);
}
else{
    $getPendingAvg=0;
$getCompletedAvg=0;
$getCanceledAvg=0;
}

$months=$orders->pluck('monthname')->toArray();
$monthstring =$result = "'" . implode ( "', '", $months ) . "'";
$counts=$orders->pluck('count')->toArray();
$count = implode(', ',$counts);
$totals=$orders->pluck('totals')->toArray();
$total = implode(', ',$totals);

$years=$OrdersByYear->pluck('year')->toArray();
$yearstring =$result = "'" . implode ( "', '", $years ) . "'";
$totalsByYear=$OrdersByYear->pluck('totals')->toArray();
$totalYearBy = implode(', ',$totalsByYear);
        
        
        //dd($restaurant);
        return view('admin.restaurant.show', compact('restaurant', 'cuisines', 'OrdersByTotal', 'OrdersByDayAvg','OrdersByDay', 'yearstring', 'totalYearBy', 'monthstring','count', 'total','getPendingAvg','getCompletedAvg','getCanceledAvg','getPendings','getComleted','totalorders','adminEarnings','adminEarnByDay','adminEarnByAvg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurant.edit')->with('restaurant', $restaurant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'slogan' => 'required|string|max:191',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'city' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required|string|max:500',
            'min_order' => 'nullable|integer',
            'avg_delivery_time' => 'nullable|integer',
            'delivery_range' => 'nullable|integer',
        ]);
        $user=User::where('email',$request->email)->first();
        if ($request->user_name)
            if ($request->user_name != $restaurant->user_name) {
                $request->validate([
                    'user_name' => 'required|string|max:191|unique:restaurants',
                ]);
            } else
                $request->request->remove('user_name');
        
        if ($request->phone)
             if ($request->phone != $restaurant->phone) {
                 $request->validate([
                     'phone' => 'required|string|max:191|unique:restaurants',
                 ]);
             } else
                 $request->request->remove('phone');
        
        if ($request->password!='')
        {
            $request['password'] = bcrypt($request->password);
            $user->name = $request->name;
             $user->password = $request->password;
            $user->save();
        }
            
        $restaurant->update($request->all());
        
        if($request->cuisine_id){
        $restaurant->cuisines()->sync($request->cuisine_id);
        }
        
        $cover_image = $request->cover_image;
        
        $destination = 'images/restaurant_images';
        
        
        if($request->cover_image=='')
            {
            $image = $restaurant->cover_image;
            }
            else{
          $image = $request->cover_image;
        }
        if ($request->hasFile('cover_image')) {
            $filename = strtolower(
                pathinfo($cover_image->getClientOriginalName(), PATHINFO_FILENAME)
                . '-'
                . uniqid()
                . '.'
                . $cover_image->getClientOriginalExtension()
            );
            
            $filename=str_replace(" ", "-", $filename);
            $cover_image->move($destination, $filename);
            $restaurant->cover_image = $filename;
            $restaurant->update();
        }
        
        
        $logo=$request->logo;
        if($request->logo=='')
            {
            $image = $restaurant->logo;
            }
            else{
          $image = $request->logo;
        }
        if ($request->hasFile('logo')) {
            $file = strtolower(
                pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME)
                . '-'
                . uniqid()
                . '.'
                . $logo->getClientOriginalExtension()
            );
            
            $file=str_replace(" ", "-", $file);
            $logo->move($destination, $file);
            $restaurant->logo = $file;
            $restaurant->update();
        }
        $alert['type'] = 'success';
        $alert['message'] = 'Restaurant updated Successfully';
        return redirect()->route('restaurant.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->cover_image)
            Storage::delete($restaurant->cover_image);
        if ($restaurant->logo)
            Storage::delete($restaurant->logo);

        $restaurant->delete();
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'restaurant successfully deleted';

        return redirect()->route('restaurant.index')->with('alert', $alert);
    }

    public function change_restaurant_active_status(Restaurant $restaurant)
    {
        if ($restaurant->approved)
            $restaurant->approved = false;
        else
            $restaurant->approved = true;

        $restaurant->save();
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'restaurant status successfully updated';
        return redirect()->back()->with('alert', $alert);
    }

    public function change_restaurant_featured_status(Restaurant $restaurant)
    {
        if ($restaurant->featured)
            $restaurant->featured = false;
        else
            $restaurant->featured = true;

        $restaurant->save();
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'restaurant status successfully updated';
        return redirect()->back()->with('alert', $alert);
    }

    public function pending()
    {
        $restaurants = Restaurant::where('approved', 0)->get();
        return view('admin.restaurant.pending')->with('restaurants', $restaurants);
    }
    public function get_service_charges(Restaurant $restaurant)
    {
        return view('admin.restaurant.set_service_charges')->with('restaurant', $restaurant);
    }
    public function set_service_charges(Request $request,Restaurant $restaurant)
    {
        $request->validate([
            'service_charges' => 'required'
            ]);
        $charges=$request->service_charges;
        Restaurant::where('id',$restaurant->id)->update(array('service_charges'=>$charges));
        $alert['type'] = 'success';
        $alert['message'] = 'restaurant successfully updated';
        return redirect()->route('restaurant.index')->with('alert', $alert);
    }
}
