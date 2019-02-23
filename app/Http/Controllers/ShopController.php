<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $recently_added_products = Product::latest()->limit(5)->get();
        return view('shop.index', compact('recently_added_products'));
    }

    public function list(Request $request)
    {
        $products = Product::query();
        if (!$request->filled('category') && !$request->filled('search') && !$request->filled('brand')) {
            $products = $products->with('brand');
        } else if ($request->filled('search')) {
            $products = $products->where('name', 'like', '%' . $request->search . '%')
                ->orWhereHas('brand', function ($query) use ($request) {
                    return $query->where('name', 'like','%'. $request->search.'%');
                })->orWhereHas('category', function ($query) use ($request) {
                    return $query->where('name', 'like','%'. $request->search.'%');
                })
                ->with('brand');
        }
        if ($request->filled('category')) {
            $categories = Category::all();
            if ($categories->where('name', $request->category)->first()->categories->count()) {
                $products = $products->whereIn('category_id', $categories->where('name', $request->category)->first()->categories->pluck('id')->toArray())->with('brand');
            } else {
                $products = $categories->where('name', $request->category)->first()->products()->with('brand');
            }
        }
        if ($request->filled('brand')) {
            $brand_id = Brand::where('name', $request->brand)->first()->id;
            $products = $products->where('brand_id', $brand_id);
        }
        $sort_box = ['Price, low to high' => ['price', 'asc'], 'Price, high to low' => ['price', 'desc'],
            'Alphabetically, A-Z' => ['name', 'asc'], 'Alphabetically, Z-A' => ['name', 'desc']];

        $products->orderBy($sort_box[$request->sort][0], $sort_box[$request->sort][1]);
        return $products->limit(4)->offset($request->offset)->get();
    }

    public function show(Request $request)
    {
        $product = Product::find($request->id);
        $ratings = $product->ratings()->with('user')->latest()->get();
        return view('shop.show', compact('product', 'ratings'));
    }
}
