<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        return view('cart.index');
    }

    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        $noitem = auth()->user()->carts()->where('product_id', $product->id)->get()->isEmpty();
        if ($noitem) {
            Cart::create([
                'product_id' => $product->id,
                'quantity' => 1,
                'user_id' => auth()->id(),
            ]);
        } else {
            $cartItem = auth()->user()->carts()->where('product_id', $product->id)->first();
            $cartItem->quantity++;
            $cartItem->save();
        }
        return redirect('/cart');
    }

    public function update(Request $request)
    {
        foreach ($request->items as $item) {
           $cart = Cart::find($item['id']);
           $cart->quantity = $item['quantity'];
           $cart->save();
        }
    }

    public function delete(Request $request)
    {
        Cart::find($request->id)->forceDelete();
    }
}
