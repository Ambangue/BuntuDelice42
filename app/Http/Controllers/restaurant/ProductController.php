<?php

namespace App\Http\Controllers\restaurant;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\Restaurant;
use App\Optional;
use App\AddOnsTitle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // dd(auth()->user()->restaurant()->first()->services);
        $products = Product::where('restaurant_id',auth()->user()->restaurant->id)->get();
        return view('restaurant.product.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('restaurant.product.create');

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
            'category_id'=>'required|integer',
            'name'=>'required|string|max:191',
            'image'=>'required|image|mimes:jpeg,png,jpg',
            'price'=>'required',
            'discount_price'=>'nullable',
            'description'=>'nullable|string|max:191',
            'size'=>'nullable'
        ]);
        $name=auth()->user()->id;
        $restaurant=Restaurant::where('user_id',$name)->first();
        $request['restaurant_id']=$restaurant->id;
        $category = Category::find($request->category_id);
        $product=$category->products()->create($request->all());
        $image = $request->image;
        $destination = 'images/product_images';
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
            $product->image = $filename;
            $product->save();
        }
        $alert['type'] = 'success';
        $alert['message'] = 'Product Created Successfully';
        return redirect()->route('product.index')->with('alert', $alert);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prod = Db::table('products')->find($id);
        $optional = DB::table('optionals')->where('product_id', $id)->get();
        $required = DB::table('requireds')->where('product_id', $id)->get();
        $addons = DB::table('add_ons_titles')->where('product_id', $id)->get();
        foreach ($optional as $key => $value) {
            foreach ($addons as $key1 => $value1) 
                if($value->add_on_title_id == $value1->id)
                    $value->add_on_title_id = $value1->title;
        }
        foreach ($required as $key => $value) {
            foreach ($addons as $key1 => $value1) 
                if($value->add_on_title_id == $value1->id)
                    $value->add_on_title_id = $value1->title;
        }
        // dd($required);
        return view('restaurant.product.addon',compact('optional','addons','prod','required'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('restaurant.product.edit')->with('product', $product);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id'=>'required|integer',
            'name'=>'required|string|max:191',
            'price'=>'required',
            'discount_price'=>'nullable',
            'description'=>'nullable|string|max:191',
            'size'=>'nullable'
        ]);
       $product->update($request->all());
        $image = $request->image;
        if($request->image=='')
            {
            $image1 = $product->image;
            }
            else{
          $image1 = $request->image;
        }
        $destination = 'images/product_images';
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
            $product->image = $filename;
            $product->update();
        }
        $alert['type'] = 'success';
        $alert['message'] = 'Product updated Successfully';
        return redirect()->route('product.index')->with('alert', $alert);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        if ($product->image)
            Storage::delete($product->image);
        $product->delete();
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'product successfully deleted';

        return redirect()->route('product.index')->with('alert', $alert);
    }
    public function change_product_featured_status(Product $product)
    {
        if ($product->featured)
            $product->featured = false;
        else
            $product->featured = true;
        $product->save();
        $alert = [];
        $alert['type'] = 'success';
        $alert['message'] = 'product status successfully updated';
        return redirect()->back()->with('alert', $alert);
    }
}
