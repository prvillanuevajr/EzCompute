<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->save();

        return back();
    }

    public function delete(Brand $brand)
    {
        $brand->forceDelete();
    }
}
