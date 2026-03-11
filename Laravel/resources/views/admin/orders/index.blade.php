@extends('layouts.app')

@section('title', 'Все заказы')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Все заказы</h1>

        @if($orders->count() === 0)
            <p>Заказов нет.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Номер</th>
                        <th class="text-left py-2">Покупатель</th>
                        <th class="text-left py-2">Дата</th>
                        <th class="text-right py-2">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b align-top">
                            <td class="py-2">{{ $order->order_number }}</td>
                            <td class="py-2">
                                {{ $order->user?->full_name ?? $order->user?->name ?? 'Пользователь' }}
                            </td>
                            <td class="py-2">{{ $order->order_date->format('d.m.Y H:i') }}</td>
                            <td class="py-2 text-right">
                                {{ number_format($order->total, 2, ',', ' ') }} ₽
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td colspan="4" class="py-2">
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection

