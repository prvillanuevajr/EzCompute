<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $category = new Category();
        $category->name = strtoupper($request->name);
        $category->category_id = $request->category_id ?: null;
        $category->save();
        return back();
    }

    public function delete(Category $category)
    {
        return $category->forceDelete();
    }

    public function update(Request $request, Category $category)
    {
        $category->update(['name' => $request->value]);
    }
}
