<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController  as Product;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/check', function () {
    return view('check_file');
});


Route::get('/add_p_form', function () {
    return view('product.add_product');
})->name("add_p_form");
// Route::post("/upload", 'ProductController@store')->name("upload");
Route::post('products', [Product::class, 'store'])->name('products.store');
Route::get('products', [Product::class, 'index'])->name('products.index');
Route::get('add_form', [Product::class, 'addForm'])->name('products.form');
Route::post('delete/{id}',[Product::class, 'delete'])->name('product.delete');
Route::get('reset', [Product::class, 'reset'])->name('reset');
