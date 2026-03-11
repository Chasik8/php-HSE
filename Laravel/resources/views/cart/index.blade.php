@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-4">Корзина</h1>

            @if(empty($items))
                <p>Корзина пуста.</p>
            @else
                <table class="w-full text-sm mb-4">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Товар</th>
                            <th class="text-right py-2">Цена</th>
                            <th class="text-right py-2">Кол-во</th>
                            <th class="text-right py-2">Сумма</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr class="border-b">
                                <td class="py-2">
                                    <a href="{{ route('products.show', $item['product']) }}" class="text-blue-600 hover:underline">
                                        {{ $item['product']->name }}
                                    </a>
                                </td>
                                <td class="text-right py-2">
                                    {{ number_format($item['product']->price, 2, ',', ' ') }} ₽
                                </td>
                                <td class="text-right py-2">
                                    {{ $item['quantity'] }}
                                </td>
                                <td class="text-right py-2">
                                    {{ number_format($item['sum'], 2, ',', ' ') }} ₽
                                </td>
                                <td class="text-right py-2">
                                    <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:underline text-xs">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-between items-center mb-4">
                    <div class="font-bold">
                        Итого: {{ number_format($total, 2, ',', ' ') }} ₽
                    </div>
                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:underline">
                            Очистить корзину
                        </button>
                    </form>
                </div>

                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Оформить заказ
                    </button>
                </form>
            @endif
        </div>

        <div class="space-y-4">
            @if($recentProducts->count())
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="font-semibold mb-2">Недавно просмотренные</h2>
                    <ul class="space-y-1 text-sm">
                        @foreach($recentProducts as $recent)
                            <li>
                                <a href="{{ route('products.show', $recent) }}" class="text-blue-600 hover:underline">
                                    {{ $recent->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection

