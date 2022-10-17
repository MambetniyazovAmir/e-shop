<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        Cart::add($product, $quantity);
        return Cart::content();
    }

    public function update(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        Cart::update($product, $quantity);
        return Cart::content();
    }

    public function delete(Request $request)
    {
        Cart::remove($request->cart_id);
        return Cart::content();
    }
}
