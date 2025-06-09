<?php

use App\Http\Controllers\Crud\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Afficher le formulaire de création
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Enregistrer un nouveau produit
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Afficher un produit spécifique
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Afficher le formulaire d’édition
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');

// Mettre à jour un produit
Route::patch('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');

// Supprimer un produit
Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

//  les routes classiques pour un CRUD complet avec ProductController :
// Route::resource('products', ProductController::class);
