<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\CouponController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

//shop route
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');

//cart route
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_Cart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.increase');
Route::put('/cart/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item_cart'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear_cart'])->name('cart.clear');

//wishlist route
Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishListController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::delete('/wishlist/remove/{rowId}', [WishListController::class, 'remove_from_wishlist'])->name('wishlist.remove');
Route::delete('/wishlist/clear', [WishListController::class, 'clear_wishlist'])->name('wishlist.clear');
Route::post('/wishlist/add-to-cart/{rowId}', [WishListController::class, 'wishlist_to_cart'])->name('wishlist.add_to_cart');


//account route
Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});

Route::middleware(['auth', AuthAdmin::class])->group(function () {
    //route brands
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'edit_brand'])->name('admin.brand.edit');
    Route::put('/admin/brand/update', [AdminController::class, 'update_brand'])->name('admin.brand.update');
    Route::delete('/admin/brand/delete{id}', [AdminController::class, 'delete_brand'])->name('admin.brand.delete');

    ///route catogories
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'add_category'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'edit_category'])->name('admin.category.edit');
    Route::put('/admin/category/update', [AdminController::class, 'update_category'])->name('admin.category.update');
    Route::delete('/admin/category/delete{id}', [AdminController::class, 'delete_category'])->name('admin.category.delete');

    //products route
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'add_product'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'edit_product'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [AdminController::class, 'update_product'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [AdminController::class, 'delete_product'])->name('admin.products.delete');

    //shop route
    // Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    // Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
    // Route::get('/shop/category/{slug}', [ShopController::class, 'category'])->name('shop.category');

    //coupon route
    Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
    Route::get('/admin/coupons/add', [AdminController::class, 'add_coupon'])->name('admin.coupons.add');
    Route::post('/admin/coupons/store', [AdminController::class, 'coupon_store'])->name('admin.coupons.store');
});