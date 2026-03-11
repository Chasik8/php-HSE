@extends('layouts.app')

@section('title', 'Товары')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Товары</h1>
            <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
                Добавить товар
            </a>
        </div>

        @if($products->count() === 0)
            <p>Товаров нет.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">ID</th>
                        <th class="text-left py-2">Название</th>
                        <th class="text-left py-2">Категория</th>
                        <th class="text-right py-2">Цена</th>
                        <th class="text-right py-2">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-b">
                            <td class="py-2">{{ $product->id }}</td>
                            <td class="py-2">{{ $product->name }}</td>
                            <td class="py-2">{{ $product->category?->name ?? '—' }}</td>
                            <td class="py-2 text-right">
                                {{ number_format($product->price, 2, ',', ' ') }} ₽
                            </td>
                            <td class="py-2 text-right">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline text-xs mr-2">
                                    Редактировать
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs"
                                            onclick="return confirm('Удалить товар?')">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection

