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

    public  function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->firstOrFail();
        $related_products = Product::where('slug', '<>', $product_slug)
            ->where('category_id', $product->category_id)
            ->orderBy('created_at', 'DESC')
            ->take(8)
            ->get();
        return view('details', compact('product', 'related_products'));
    }


    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('category', data: compact('category'));
    }
}
