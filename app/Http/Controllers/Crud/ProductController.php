<?php

namespace App\Http\Controllers\Crud;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
    //    $products = Product::orderBy('id', 'desc')->get();
       $products = Product::paginate(2);

        $total = Product::count();

      
        return view('pages.products-index', compact('products', 'total'));
    }

    public function create()
    {
        return view('pages.products-create');
    }

    public function store(Request $request)
    {
        $validation = $request->validate(['title' => 'required', 'category' => 'required', 'price' => 'required']);
        $data = Product::create($validation);
        if ($data) {
            session()->flash('success', 'Product Add Successfully');

            return redirect(route('products.index'));
        } else {
            session()->flash('error', 'Some problem occure');

            return redirect(route('products.create'));
        }
    }

    public function edit($id)
    {
        $products = Product::findOrFail($id);

        return view('pages.products-update', compact('products'));
    }

    public function delete($id)
    {
        $products = Product::findOrFail($id)->delete();
        if ($products) {
            session()->flash('success', 'Product Deleted Successfully');

            return redirect(route('products.index'));
        } else {
            session()->flash('error', 'Product Not Delete successfully');

            return redirect(route('products.index'));
        }
    }

    public function update(Request $request, $id)
    {
        $products = Product::findOrFail($id);
        $title = $request->title;
        $category = $request->category;
        $price = $request->price;
        $products->title = $title;
        $products->category = $category;
        $products->price = $price;
        $data = $products->save();
        if ($data) {
            session()->flash('success', 'Product Update Successfully');

            return redirect(route('products.index'));
        } else {
            session()->flash('error', 'Some problem occure');

            return redirect(route('products.update'));
        }
    }
}
