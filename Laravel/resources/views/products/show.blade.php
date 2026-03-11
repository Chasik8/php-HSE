@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
            <p class="text-sm text-gray-600 mb-2">
                {{ $product->category?->name ?? 'Без категории' }}
            </p>
            <p class="text-xl font-bold mb-4">{{ number_format($product->price, 2, ',', ' ') }} ₽</p>

            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mb-4 max-h-64 object-contain">
            @endif

            <p class="mb-4">{{ $product->description }}</p>

            @auth
                <form method="POST" action="{{ route('cart.add', $product) }}" class="mb-4 flex space-x-2">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1"
                           class="w-24 border rounded px-3 py-2">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                        Добавить в корзину
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-600 mb-4">
                    Чтобы оформить заказ, войдите или зарегистрируйтесь.
                </p>
            @endauth

            <h2 class="text-xl font-semibold mb-2">Оценки товара</h2>
            @if($product->ratings->count() === 0)
                <p class="mb-2">Пока нет оценок.</p>
            @else
                <ul class="space-y-2 mb-4">
                    @foreach($product->ratings as $rating)
                        <li class="border rounded p-2">
                            <div class="flex justify-between text-sm mb-1">
                                <span>{{ $rating->user?->full_name ?? $rating->user?->name ?? 'Пользователь' }}</span>
                                <span>Оценка: {{ $rating->rating }}</span>
                            </div>
                            <p>{{ $rating->comment }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif

            @auth
                <h3 class="text-lg font-semibold mb-2">Оценить товар</h3>
                <form method="POST" action="{{ route('products.rate', $product) }}" class="space-y-2">
                    @csrf
                    <div>
                        <label class="block mb-1 text-sm">Оценка (1-5)</label>
                        <input type="number" name="rating" value="5" min="1" max="5"
                               class="w-24 border rounded px-3 py-2">
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 text-sm">Комментарий</label>
                        <textarea name="comment" class="w-full border rounded px-3 py-2" rows="3"></textarea>
                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Сохранить оценку
                    </button>
                </form>
            @endauth
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

