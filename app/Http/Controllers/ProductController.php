<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::when(
            $request->name,
            function ($query, $name) {
                $query->where("name", "like", "%" . $name . "%");
            }
        )->paginate(10);
        return view("pages.products.index", compact("products"));
    }

    public function create(){
        return view("pages.products.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"=> "required",
            "price"=> "required|numeric",
            "stock"=> "required",
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();

        return redirect()->route('products.index')->with("success","Product Created Successfully");
    }

    public function show($id){}

    public function edit($id){
        $product = Product::find($id);
        return view('pages.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=> 'required',
            'price'=> 'required',
            'stock'=> 'required',
        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();

        return redirect()->route('products.index')->with('success','Product Updated Successfully');
    }

    public function destroy($id){
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index')->with('success','Product Deleted Successfully');
    }
}
