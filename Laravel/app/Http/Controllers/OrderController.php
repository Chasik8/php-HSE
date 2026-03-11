<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items.product')
            ->orderByDesc('order_date')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function myOrders()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->orderByDesc('order_date')
            ->paginate(20);

        return view('orders.my', compact('orders'));
    }

    public function store(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        if ($products->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Товары не найдены.');
        }

        $total = 0;
        foreach ($cart as $productId => $qty) {
            if (!isset($products[$productId])) {
                continue;
            }
            $total += $products[$productId]->price * $qty;
        }

        $order = Order::create([
            'order_number' => 'ORD-' . Str::upper(Str::random(8)),
            'order_date' => now(),
            'user_id' => Auth::id(),
            'total' => $total,
        ]);

        foreach ($cart as $productId => $qty) {
            if (!isset($products[$productId])) {
                continue;
            }
            $product = $products[$productId];
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $product->price,
            ]);
        }

        $request->session()->forget('cart');

        return redirect()->route('orders.my')->with('success', 'Заказ создан.');
    }
}

