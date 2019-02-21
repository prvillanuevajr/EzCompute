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

Route::get('seed_orders', function (\Illuminate\Http\Request $request) {
    if ($request->init) {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \App\Order::query()->truncate();
        \App\OrderDetail::query()->truncate();
        \App\InvoiceDetail::query()->truncate();
        \App\Invoice::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
    factory(\App\Cart::class, (int)rand(50, 150))->create();
    $users = \App\User::has('carts')->with('carts')->get();
    foreach ($users as $user) {
        $items = $user->carts;
        $total_price = $items->map(function ($item) {
            return $item->quantity * $item->product->price;
        })->sum();

        if ($total_price) {
            $carbon = \Carbon\Carbon::parse($request->month . '/01/' . $request->year)->addDays(rand(0, 20));
            $delivery_date = \Carbon\Carbon::parse($carbon)->addDays(3);
            $order = \App\Order::create([
                'user_id' => $user->id,
                'total_price' => $total_price,
                'status' => 'invoiced',
                'created_at' => $carbon,
                'updated_at' => $carbon,
                'delivery_date' => $delivery_date,
            ]);
            $invoice = $order->invoice()->create([
                'total_price' => $order->total_price,
                'user_id' => $order->user_id,
                'created_at' => $carbon,
                'updated_at' => $carbon,
            ]);
            foreach ($items as $item) {
                $order->details()->create([
                    'product_id' => $item->product->id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
                $product = $item->product;
                $invoice->details()->create([
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand->name,
                    'category' => $product->category->name,
                    'price' => $product->price,
                    'quantity' => $item->quantity,
                ]);
            }
        }
        \App\Cart::query()->forceDelete($items->pluck('id'));    //FLUSH ITEMS ON CART
    }
    return 'success';
});
