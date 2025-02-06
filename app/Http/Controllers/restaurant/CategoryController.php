<?php

namespace App\Http\Controllers\restaurant;

use App\Category;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\User;
use DemeterChain\C;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $name=auth()->user()->id;
        $restaurant=Restaurant::where('user_id',$name)->first();
        $categories = $restaurant->categories;
        return view('restaurant.category.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        return view('restaurant.category.create');
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
        ]);
        $name=auth()->user()->id;
        //dd($name);
        $restaurant=Restaurant::where('user_id',$name)->first();
        $restaurant->categories()->create($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'Category Created Successfully';
        return redirect()->route('category.index')->with('alert', $alert);
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
    public function edit(Category $category)
    {
        $name=auth()->user()->name;
        $restaurant=Restaurant::where('name',$name)->first();
        $categories = $restaurant->categories;
        return view('restaurant.category.index',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);
        $category->update($request->all());
        $alert['type'] = 'success';
        $alert['message'] = 'Category updated Successfully';
        return redirect()->route('category.index')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();

        $alert['type'] = 'success';
        $alert['message'] = 'Category Deleted Successfully';
        return redirect()->route('category.index')->with('alert', $alert);
    }
    public function search(Request $request,Category $category)
    {
        $search = $request->input($category->id);
        $categories = Category::search($search)->get();
        return redirect()->route('category.index')->with('categories',$categories);
    }
}
