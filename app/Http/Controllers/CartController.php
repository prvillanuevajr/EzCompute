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
        return checkIfActive('redirect');
        $product = Product::find($request->product_id);
        if (!$product->quantity) return response('out of stock', 406);
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
        $product->quantity = $product->quantity - 1;
        $product->save();
        return redirect('/cart');
    }

    public function update(Request $request)
    {
        $cart = Cart::find($request->item['id']);
        $product = Product::find($cart->product_id);
        if (!$product->quantity && $request->toAdd == 1) return response('out of stock', 406);
        $cart->quantity += $request->toAdd;
        $cart->save();
        $product->quantity -= $request->toAdd;
        $product->save();

        return $cart;
    }

    public function delete(Request $request)
    {
        Cart::find($request->item['id'])->forceDelete();
        $product = Product::find($request->item['product']['id']);
        $product->quantity += $request->item['quantity'];
        $product->save();
    }
}
