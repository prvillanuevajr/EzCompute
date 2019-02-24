<?php

namespace App\Console\Commands;

use App\Cart;
use Illuminate\Console\Command;

class DeleteExpiredCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carts:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expired_cart_items = Cart::where('created_at', '<=', now()->subHours(2))->get();
        if ($expired_cart_items->count()) {
            foreach ($expired_cart_items as $item) {
                $product = Product::find($item->product_id);
                $product->quantity += $item->quantity;
                $product->save();
                $item->forceDelete();
            }
        }
    }
}
