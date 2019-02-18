<?php

namespace App\Http\Controllers;

use App\Product;
use App\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required',
            'comment' => 'required',
        ]);

        $user_has_rating_to_this_product = auth()->user()->ratings()->where('product_id', $product->id)->get()->count();
        $user_bought_product_ids = auth()->user()->invoices()->with('details')->get()->pluck('details')->flatten()->pluck('product_id')->toArray();
        $user_has_bought_the_product = in_array($product->id, $user_bought_product_ids);
        if ($user_has_rating_to_this_product) {
            return response(['message' => 'You already reviewed this product'], 406);
        }
        if (!$user_has_bought_the_product) {
            return response(['message' => 'You have not purchase this product yet!'], 406);
        }
        $rating = auth()->user()->ratings()->create([
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return Rating::with('user')->find($rating->id);
    }

    public function delete(Rating $rating)
    {
        if (auth()->user()->is_admin == 1 || $rating->user_id == auth()->id()) {
            $rating->forceDelete();
            return response(null, 200);
        };
        return response(['message' => 'This is not yours'], 406);
    }
}
