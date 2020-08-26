<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Product;


Route::middleware('auth')->group(function() {

    //Listar Datos de la DB
Route::get('products', function () {
    $products = Product::orderBy('created_at', 'desc')->get();
   return view('products.index', compact('products')); 
})->name('products.index');


Route::get('products/create', function () {
    return view('products.create'); 
 })->name('products.create');

//Agregar DAtos a la DB
 Route::post('products', function (Request $request) {
     $productos = new Product;
     $productos->description = $request->input('description');
     $productos->price = $request->input('price');
     $productos->save();

     return redirect()->route('products.index')->with('info','Producto Creado Exitosamente');

     
 })->name('products.store');

//Eliminar Datos de la DB
 Route::delete('products/{id}', function ($id) {
     //return $id;
     $product = Product::findOrFail($id);
     $product->delete();
     return redirect()->route('products.index')->with('info','Producto Eliminado Exitosamente');

 })->name('products.destroy');


//Pasar datos de una vista a otra por id
 Route::get('products/{id}/edit', function ($id) {
    $product = Product::findOrFail($id);
    return view('products.edit', compact('product'));
 })->name('products.edit');


 Route::put('products/{id}', function (Request $request, $id) {
    $product = Product::findOrFail($id);
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    $product->save();
    return redirect()->route('products.index')->with('info','Producto Actualizado Exitosamente');
 })->name('products.update');


});

Route::get('/', function () {
    return "esta la url raiz";
});


Auth::routes();
