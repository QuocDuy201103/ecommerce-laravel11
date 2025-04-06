<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishListController extends Controller
{
    public function index()
    {
        $wishlist = Cart::instance('wishlist')->content();
        return view('wishlist', compact('wishlist'));
    }

    public function add_to_wishlist(Request $request)
    {
        Cart::instance('wishlist')->add($request->product_id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back()->with('success', 'Product added to wishlist');
    }

    public function remove_from_wishlist($rowId)
    {
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back()->with('success', 'Product removed from wishlist');
    }

    public function clear_wishlist()
    {
        Cart::instance('wishlist')->destroy();
        return redirect()->back()->with('success', 'Wishlist cleared');
    }

    public function wishlist_to_cart($rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);
        Cart::instance('cart')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function wishlist_to_cart_all()
    {
        $items = Cart::instance('wishlist')->content();
        foreach ($items as $item) {
            Cart::instance('cart')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');  
        }
        Cart::instance('wishlist')->destroy();
        return redirect()->back()->with('success', 'All products added to cart');
    }

    
}
