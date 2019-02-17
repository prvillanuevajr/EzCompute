<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function PHPSTORM_META\map;

class OrderController extends Controller
{

    public function index()
    {
        if (auth()->user()->is_admin) {
            $orders = Order::all();
        } else {
            $orders = auth()->user()->orders;
        }
        return view('orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $order->delivery_date = Carbon::parse($request->delivery_date);
        $order->status = 'invoiced';
        $order->save();
        $invoice = $order->invoice()->create([
            'total_price' => $order->total_price,
            'user_id' => $order->user_id
        ]);
        foreach ($order->details as $detail){
            $product = Product::find($detail->product_id);
            $invoice->details()->create([
                'product_id' => $detail->product_id,
                'name' => $product->name,
                'brand' => $product->brand->name,
                'category' => $product->category->name,
                'price' => $detail->price,
                'quantity' => $detail->quantity,
            ]);
        }
        return back();
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        foreach ($order->details as $detail) {
            $product = Product::find($detail->product_id);
            $product->quantity += $detail->quantity;
            $product->save();
        }
        $order->forceDelete();
        return redirect('/orders');
    }

    public function store()
    {
        $items = auth()->user()->carts;
        $total_price = $items->map(function ($item) {
            return $item->quantity * $item->product->price;
        })->sum();

        if ($total_price) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $total_price,
            ]);
            foreach ($items as $item) {
                $order->details()->create([
                    'product_id' => $item->product->id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }
        }
        Cart::query()->forceDelete($items->pluck('id'));    //FLUSH ITEMS ON CART
        return redirect('/orders/' . $order->id);
    }
}
