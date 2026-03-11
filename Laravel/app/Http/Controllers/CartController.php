<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $qty) {
            if (!isset($products[$productId])) {
                continue;
            }
            $product = $products[$productId];
            $sum = $product->price * $qty;
            $total += $sum;
            $items[] = [
                'product' => $product,
                'quantity' => $qty,
                'sum' => $sum,
            ];
        }

        $recentIds = $request->session()->get('recently_viewed', []);
        $recentProducts = Product::whereIn('id', $recentIds)->get();

        return view('cart.index', compact('items', 'total', 'recentProducts'));
    }

    public function add(Product $product, Request $request)
    {
        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $qty = $data['quantity'] ?? 1;

        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $qty;
        $request->session()->put('cart', $cart);

        $recent = $request->session()->get('recently_viewed', []);
        $recent = array_values(array_unique(array_merge([$product->id], $recent)));
        $recent = array_slice($recent, 0, 5);
        $request->session()->put('recently_viewed', $recent);

        return redirect()->route('cart.index')->with('success', 'Товар добавлен в корзину.');
    }

    public function remove(Product $product, Request $request)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Товар удалён из корзины.');
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Корзина очищена.');
    }
}

