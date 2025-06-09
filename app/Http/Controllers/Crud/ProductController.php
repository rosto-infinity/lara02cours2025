<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        //    $products = Product::orderBy('id', 'desc')->get();
        $products = Product::orderBy('id', 'desc')->paginate(7);

        $total = Product::count();

        return view('pages.products-index', compact('products', 'total'));
    }

    public function create()
    {
        return view('pages.products-create');
    }

    public function store(Request $request)
    {
        $validation = $request->validate(
            [
                'title' => 'required',
                'category' => 'required',
                'price' => 'required|numeric']);
        Product::create($validation);
        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    public function edit($id)
    {
        $products = Product::findOrFail($id);

        return view('pages.products-update', compact('products'));
    }


  public function update(Request $request, $id)
{
    // Validation des données
    $validation = $request->validate([
        'title' => 'required',
        'category' => 'required',
        'price' => 'required|numeric', // Ajoutez 'numeric' pour valider que le prix est un nombre
    ]);

    // Récupération du produit par ID
    $product = Product::findOrFail($id);

    // Mise à jour des attributs
    $product->title = $validation['title'];
    $product->category = $validation['category'];
    $product->price = $validation['price'];

    // Sauvegarde des changements
    $product->save();

    // Redirection avec message de succès
    return redirect()->route('products.index')->with('success', 'Product updated successfully');
}
        public function destroy($id)
        {
        $products = Product::findOrFail($id);
        $products->delete();
        return redirect()->route('products.index')->with('error', 'Product Deleted Successfully');
    }

}
