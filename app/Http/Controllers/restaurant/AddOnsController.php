<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AddOnTitle;
use App\Product;
use App\Restaurant;
use Illuminate\Support\Facades\DB;
class AddOnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant_id = Restaurant::where('user_id',auth()->user()->id)->value('id');
        $addon = AddOnTitle::where('restaurant_id',$restaurant_id)->get();
        $prod= Product::where('restaurant_id',$restaurant_id)->get();
        foreach ($addon as $key => $value) {
            foreach ($prod as $key1 => $value1) 
                if($value->product_id == $value1->id)
                    $value->product_id = $value1->name;
        }
         
        return view('restaurant.Add_Ons.index',compact('addon','prod'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'product_id' => 'required|string|max:191',
        ]);
        $restaurant_id = Restaurant::where('user_id',auth()->user()->id)->value('id');
        $request['restaurant_id'] = $restaurant_id;
        AddOnTitle::create($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'Add Ons Added Successfully';
        return redirect()->route('add-on.index')->with('alert', $alert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant_id = Restaurant::where('user_id',auth()->user()->id)->value('id');
        $addonstitle = AddOnTitle::find($id);
        $addon = AddOnTitle::where('restaurant_id',$restaurant_id)->get();
        $prod= Product::where('restaurant_id',$restaurant_id)->get();
        foreach ($addon as $key => $value) {
            foreach ($prod as $key1 => $value1) 
                if($value->product_id == $value1->id)
                    $value->product_id = $value1->name;
        }
        return view('restaurant.Add_Ons.index',compact('addonstitle','addon','prod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'product_id' => 'required|string|max:191',
        ]);
        $restaurant_id = Restaurant::where('user_id',auth()->user()->id)->value('id');
        $request['restaurant_id'] = $restaurant_id;
        // //dd($request->all());
        // $AddOns = AddOnsTitle::find($id);
        // $AddOns => $request->title;
        // $AddOns => $request->product_id;
        DB::table('add_ons_titles')
            ->where('id', $id)
            ->update(['title' => $request->title , 'product_id' => $request->product_id]);
        $alert['type'] = 'success';
        $alert['message'] = 'Addon updated Successfully';
        return redirect()->route('add-on.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd('Entered in the destroy section with id = '.$id);
        DB::table('add_ons_titles')->where('id',$id)->delete();
        $alert['type'] = 'success';
        $alert['message'] = 'Addon Deleted Successfully';
        return redirect()->route('add-on.index')->with('alert', $alert);
    }
}
