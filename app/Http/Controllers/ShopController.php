<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $categories = Category::all();
        if (!$request->filled('category') && !$request->filled('search')) {
            $products = Product::with('brand')->get();
        } else if ($request->filled('search')) {
            $products = Product::where('name', 'like', '%' . $request->search . '%')->with('brand')->get();
        } else {
            if ($categories->where('name', $request->category)->first()->categories->count()) {
                $products = Product::whereIn('category_id', $categories->where('name', $request->category)->first()->categories->pluck('id')->toArray())->with('brand')->get();
            } else {
                $products = $categories->where('name', $request->category)->first()->products()->with('brand')->get();
            }
        }
        $recently_added_products = Product::latest()->limit(3)->get();
        return view('shop.index', compact('categories', 'products', 'recently_added_products'));
    }

    public function show(Request $request)
    {
        $categories = Category::all();
        $product = Product::find($request->id);
        return view('shop.show', compact('categories', 'product'));
    }
}
