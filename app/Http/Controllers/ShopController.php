<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
class ShopController extends Controller
{
    //
    public function index(Request $request)
    {
        $size = $request->query('size') ? $request->query('size') : 12;
        $o_column = "";
        $o_oder = "";
        $order = $request->query('order') ? $request->query('order') : -1;
        switch ($order) {
            case 1:
                $o_column = 'created_at';
                $o_oder = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_oder = 'ASC';
                break;
            case 3:
                $o_column = 'sale_price';
                $o_oder = 'ASC';
                break;
            case 4:
                $o_column = 'sale_price';
                $o_oder = 'DESC';
                break;
            default:
                $o_column = 'created_at';
                $o_oder = 'DESC';
                break;
        }
        $brands = Brand::orderBy('name', 'ASC')->get();
        $f_brands = $request->query('brands') ? $request->query('brands') : "";
        $categories = Category::orderBy('name', 'ASC')->get();
        $f_categories = $request->query('categories') ? $request->query('categories') : "";
        $min_price = $request->query('min_price') ? $request->query('min_price') : 1;
        $max_price = $request->query('max_price') ? $request->query('max_price') : 10000000;
        $products = Product::where(function ($query) use ($f_brands) {
            if ($f_brands != "") {
                $query->whereIn('brand_id', explode(',', $f_brands))->orWhereRaw("'" . $f_brands . "'=''");
            }

        })
            ->where(function ($query) use ($f_categories) {
                if ($f_categories != "") {
                    $query->whereIn('category_id', explode(',', $f_categories))->orWhereRaw("'" . $f_categories . "'=''");
                }
            })
            ->where(function ($query) use ($min_price, $max_price) {
                $query->whereBetween('regular_price', [$min_price, $max_price])
                    ->orWhereBetween('sale_price', [$min_price, $max_price]);
            })
            ->orderBy($o_column, $o_oder)->paginate($size);
        return view('shop', data: compact('products', 'size', 'order', 'o_column', 'o_oder', 'brands', 'f_brands', 'categories', 'f_categories', 'min_price', 'max_price'));
    }

    public function product_details($product_slug)
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
