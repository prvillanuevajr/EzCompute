<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $files = Storage::disk('public_uploads')->allFiles('product/images/');; //Get all photos in products images to delete non associated.
        Storage::delete(collect($files)->diff($products->pluck('image'))->flatten()->toArray());
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('products.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|numeric',
            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price' => 'required',
            'image' => 'image',
        ]);
        $validated['image'] = $request->image->store('product/images');
        Product::create($validated);
        return redirect('/products');

    }

    public function update(Request $request, Product $product)
    {
        $product->update([$request->column => $request->value]);
    }

    public function delete(Product $product)
    {
        File::delete('images/' . $product->image);
        $product->forceDelete();
    }
}
