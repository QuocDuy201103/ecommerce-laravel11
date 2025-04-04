<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
class ShopController extends Controller
{
    //
    public function index()
    {
        $products = Product::orderByDesc('created_at')->paginate(9);
        return view('shop', data: compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('product', data: compact('product'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('category', data: compact('category'));
    }
}
