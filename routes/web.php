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

Route::post('/cart', 'CartController@store')->middleware('auth');
Route::get('/cart', 'CartController@index')->middleware('auth');
Route::post('/cart/delete', 'CartController@delete')->middleware('auth');
Route::post('/cart/update', 'CartController@update')->middleware('auth');

Route::get('/orders','OrderController@index');
Route::post('/orders','OrderController@store');
Route::get('/orders/{order}','OrderController@show');
Route::post('/orders/{order}/cancel','OrderController@cancel');
Route::post('/orders/{order}/update','OrderController@update');

Route::get('categories', 'CategoryController@index');
Route::post('categories', 'CategoryController@store');
Route::post('categories/{category}', 'CategoryController@delete');

Route::get('brands', 'BrandController@index');
Route::post('brands', 'BrandController@store');
Route::post('brands/{brand}', 'BrandController@delete');

Route::get('products', 'ProductController@index');
Route::post('products', 'ProductController@store');
Route::get('products/create', 'ProductController@create');
Route::post('products/{product}', 'ProductController@delete');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
