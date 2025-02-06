<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Optional;
use Illuminate\Support\Facades\DB;
class OptionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // dd($request);
        $request->validate([
            'title' => 'required|string|max:191',
            'product_id' => 'required|string|max:191',
            'add_on_title_id' => 'required|string|max:191',
            'price' => 'required|string|max:191',
        ]);
        Optional::create($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'Add Ons Added Successfully';
        return redirect()->back()->with('alert', $alert);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request,$id);
        $request->validate([
            'title' => 'required|string|max:191',
            'add_on_title_id' => 'required|string|max:191',
            'price' => 'required|string|max:191',
        ]);
        DB::table('optionals')->where('id', $id)
        ->update(['title' => $request->title , 'price' => $request->price]);
        $alert['type'] = 'success';
        $alert['message'] = 'Addon updated Successfully';
        return redirect()->back()->with('alert', $alert);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('optionals')->where('id',$id)->delete();
        $alert['type'] = 'success';
        $alert['message'] = 'Addon Deleted Successfully';
        return redirect()->back()->with('alert', $alert);
    }
}
