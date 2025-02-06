<?php

namespace App\Http\Controllers\admin;

use App\Cuisine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CuisineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cuisines = Cuisine::all();
        return view('admin.cuisine.index')->with('cuisines', $cuisines);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.cuisine.create');
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
            'name' => 'required|string|max:191',
            'image'=>'required|image|mimes:png,jpg'
        ]);
        $cuisine=Cuisine::create($request->all());
        $image = $request->image;
                    $destination = 'images/cuisine';
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
                        $cuisine->image = $filename;
                        $cuisine->save();
                    }
        $alert['type'] = 'success';
        $alert['message'] = 'Cuisine Created Successfully';
        return redirect()->route('cuisine.index')->with('alert', $alert);
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
    public function edit(Cuisine $cuisine)
    {
        return view('admin.cuisine.edit')->with('cuisine', $cuisine);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Cuisine $cuisine)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'image'=>'required|image|mimes:png,jpg'
        ]);
        $cuisine->update($request->all());
        
        $image = $request->image;
          $destination = 'images/cuisine';
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
            $cuisine->image = $filename;
            $cuisine->update();
        }
        else{
            $cuisine->image = $cuisine->image;
            $cuisine->update();
        }
        $alert['type'] = 'success';
        $alert['message'] = 'Cuisine updated Successfully';
        return redirect()->route('cuisine.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Cuisine $cuisine)
    {
        $cuisine->delete();

        $alert['type'] = 'success';
        $alert['message'] = 'Cuisine Deleted Successfully';
        return redirect()->route('cuisine.index')->with('alert', $alert);
    }
}
