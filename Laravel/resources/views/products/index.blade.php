@extends('layouts.app')

@section('title', 'Каталог товаров')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Каталог товаров</h1>

        <form method="GET" action="{{ route('products.index') }}" class="mb-4 flex space-x-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Поиск по названию или описанию"
                   class="flex-1 border rounded px-3 py-2">
            <select name="category_id" class="border rounded px-3 py-2">
                <option value="">Все категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Найти</button>
        </form>

        @if($products->count() === 0)
            <p>Товары не найдены.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($products as $product)
                    <div class="border rounded p-4 flex flex-col">
                        <h2 class="font-semibold mb-1">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-600 mb-2">
                            {{ $product->category?->name ?? 'Без категории' }}
                        </p>
                        <p class="font-bold mb-2">{{ number_format($product->price, 2, ',', ' ') }} ₽</p>
                        <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline mt-auto">
                            Подробнее
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection

