<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Invoice;
use App\InvoiceDetail;
use App\Order;
use App\OrderDetail;
use App\Rating;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactoryController extends Controller
{
    public function orders(Request $request)
    {
        if ($request->init) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            Order::query()->truncate();
            OrderDetail::query()->truncate();
            InvoiceDetail::query()->truncate();
            Invoice::query()->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }
        factory(Cart::class, (int)rand(50, 150))->create();
        $users = User::has('carts')->with('carts')->get();
        foreach ($users as $user) {
            $items = $user->carts;
            $total_price = $items->map(function ($item) {
                return $item->quantity * $item->product->price;
            })->sum();

            if ($total_price) {
                $carbon = Carbon::parse($request->month . '/01/' . $request->year)->addDays(rand(0, 20));
                $delivery_date = Carbon::parse($carbon)->addDays(3);
                $order = Order::create([
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
            Cart::query()->forceDelete($items->pluck('id'));    //FLUSH ITEMS ON CART
        }
        return 'success';
    }

    public function ratings(Faker $generator)
    {
        Rating::query()->truncate();
        $users = User::has('invoices')->with('invoices.details')->get();
        foreach ($users as $user) {
            $invoices_ids = $user->invoices->pluck('id');
            $items = InvoiceDetail::whereIn('invoice_id', $invoices_ids)->get()->pluck('product_id')->unique();
            foreach ($items as $item) {
                Rating::create([
                    'user_id' => $user->id,
                    'product_id' => $item,
                    'rating' => rand(1, 5),
                    'comment' => $generator->paragraph,
                ]);
            }
        }
    }
}
