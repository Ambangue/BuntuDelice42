<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Restaurant;
use App\WorkingHour;
use Illuminate\Http\Request;

class WorkingHourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $name=auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();
        $working_hours = $restaurant->working_hours;
        return view('restaurant.working_hour.index')->with('working_hours', $working_hours);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('restaurant.working_hour.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|string|max:191',
            'opening_time'=>'required',
            'closing_time'=>'required'
        ]);
        $name=auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();
        $restaurant->working_hours()->create($request->all());
//        Category::create($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'working hours added Successfully';
        return redirect()->route('working_hour.index')->with('alert', $alert);
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(WorkingHour $workingHour)
    {
        return view('restaurant.working_hour.edit')->with('workingHour', $workingHour);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, WorkingHour $workingHour)
    {
        $request->validate([
            'day' => 'required|string|max:191',
            'opening_time'=>'required',
            'closing_time'=>'required'
        ]);
        $workingHour->update($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'working hour updated Successfully';
        return redirect()->route('working_hour.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(WorkingHour $workingHour)
    {
        $workingHour->delete();

        $alert['type'] = 'success';
        $alert['message'] = ' Deleted Successfully';
        return redirect()->route('working_hour.index')->with('alert', $alert);
    }
}
