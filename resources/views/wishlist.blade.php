@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Wishlist</h2>
            @if(Cart::instance('wishlist')->content()->count() > 0)
                <div class="shopping-cart">
                    <div class="cart-table__wrapper">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th></th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wishlist as $item)
                                    <tr>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <img loading="lazy"
                                                    src="{{ asset('uploads/products/thumbnails')}}/{{ $item->model->image }}"
                                                    width="120" height="120" alt="{{ $item->model->name }}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4>{{ $item->name }}</h4>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__product-price">${{ $item->price }}</span>
                                        </td>
                                        <td>
                                            {{ $item->qty }}
                                        </td>
                                        <td>
                                            <span class="shopping-cart__subtotal">${{ $item->price * $item->qty }}</span>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="{{ route('wishlist.add_to_cart', $item->rowId) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-warning">ADD TO CART</button>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <form action="{{ route('wishlist.remove', $item->rowId) }}" method="POST"
                                                        id="remove-item-{{ $item->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:void(0)" class="remove-cart"
                                                            onclick="document.getElementById('remove-item-{{ $item->id }}').submit();">
                                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                                <path
                                                                    d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                            </svg>
                                                        </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="cart-table-footer">
                            <form action="{{ route('wishlist.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light">CLEAR CART</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <p>Your wishlist is empty.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">Continue Shopping</a>
                    </div>
                </div>
            @endif
        </section>
    </main>
@endsection