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
        $products = Product::orderBy('id', 'desc')->paginate(5);

          // Formater le total avec notation "k"
    $total = $this->formatCount(Product::count());

        return view('pages.products-index', compact('products', 'total'));
    }
/**
 * Formate les grands nombres avec notation "k"
 */
private function formatCount($number)
{
    if ($number >= 1000000) {
        return round($number / 1000000, 1) . 'M'; // Pour les millions
    }
    
    if ($number >= 1000) {
        // Logique pour déterminer la précision
        $divided = $number / 1000;
        
        // Si c'est un nombre rond (ex: 2000 → 2k)
        if ($number % 1000 === 0) {
            return $divided . 'k';
        }
        
        // Sinon on garde 1 décimale max (ex: 2250 → 2.25k)
        return number_format($divided, ($divided < 10) ? 2 : 1, '.', '') . 'k';
    }
    
    return $number; // Retourne tel quel si < 1000
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
                'price' => 'required|numeric']
            );
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
