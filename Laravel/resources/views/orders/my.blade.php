@extends('layouts.app')

@section('title', 'Мои заказы')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Мои заказы</h1>

        @if($orders->count() === 0)
            <p>У вас пока нет заказов.</p>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="border rounded p-4">
                        <div class="flex justify-between mb-2 text-sm">
                            <div>
                                Номер: <span class="font-semibold">{{ $order->order_number }}</span>
                            </div>
                            <div>
                                Дата: {{ $order->order_date->format('d.m.Y H:i') }}
                            </div>
                        </div>
                        <div class="mb-2 text-sm">
                            Сумма: <span class="font-semibold">{{ number_format($order->total, 2, ',', ' ') }} ₽</span>
                        </div>
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-1">Товар</th>
                                    <th class="text-right py-1">Цена</th>
                                    <th class="text-right py-1">Кол-во</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr class="border-b">
                                        <td class="py-1">
                                            {{ $item->product?->name ?? 'Удалённый товар' }}
                                        </td>
                                        <td class="text-right py-1">
                                            {{ number_format($item->price, 2, ',', ' ') }} ₽
                                        </td>
                                        <td class="text-right py-1">
                                            {{ $item->quantity }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection

