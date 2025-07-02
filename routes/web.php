<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DBBackupController;
use App\Http\Controllers\Crud\ProductController;

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

Route::get('/dbbackup', [DBBackupController::class, 'index'])
    ->name('dbbackup');

Route::get('/dbbackup/download', [DBBackupController::class, 'download'])
    ->name('dbbackup.download');

Route::post('/dbbackup/create', [DBBackupController::class, 'create'])
    ->name('dbbackup.create');

// Ajouter ces nouvelles routes
Route::post('/dbbackup/import', [DBBackupController::class, 'import'])
    ->name('dbbackup.import');

Route::delete('/dbbackup/delete', [DBBackupController::class, 'delete'])
    ->name('dbbackup.delete');
Route::post('/dbbackup/restore', [DBBackupController::class, 'restore'])
    ->name('dbbackup.restore');

