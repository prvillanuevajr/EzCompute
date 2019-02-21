<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ShopController@index');
Route::get('/shop', 'ShopController@index');
Route::get('/shop/product', 'ShopController@show');
Route::post('shop/list', 'ShopController@list');

Route::middleware('auth')->group(function () {
    Route::middleware('customer')->group(function () {
        Route::post('/cart', 'CartController@store');
        Route::get('/cart', 'CartController@index');
        Route::post('/cart/delete', 'CartController@delete');
        Route::post('/cart/update', 'CartController@update');

        Route::post('/orders', 'OrderController@store');

    });

    Route::get('/invoices/{invoice}', 'InvoiceController@show');

    Route::get('/orders', 'OrderController@index');
    Route::get('/orders/{order}', 'OrderController@show');
    Route::post('/orders/{order}/cancel', 'OrderController@cancel');

    Route::post('/ratings/{product}/store', 'RatingController@store');
    Route::post('/ratings/{rating}/delete', 'RatingController@delete');
});


Route::middleware('admin')->group(function () {
    Route::get('categories', 'CategoryController@index');
    Route::post('categories', 'CategoryController@store');
    Route::post('categories/{category}', 'CategoryController@delete');
    Route::post('categories/{category}/update', 'CategoryController@update');

    Route::get('brands', 'BrandController@index');
    Route::post('brands', 'BrandController@store');
    Route::post('brands/{brand}', 'BrandController@delete');
    Route::post('brands/{brand}/update', 'BrandController@update');

    Route::get('products', 'ProductController@index');
    Route::post('products', 'ProductController@store');
    Route::get('products/create', 'ProductController@create');
    Route::post('products/{product}', 'ProductController@delete');
    Route::post('products/{product}/update', 'ProductController@update');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::post('/orders/{order}/update', 'OrderController@update');

    Route::get('users', 'UserController@index');
    Route::post('users/toggle_active', 'UserController@toggle_active');
});

Auth::routes();

Route::get('seed_orders', 'FactoryController@orders');
Route::get('seed_ratings', 'FactoryController@ratings');
