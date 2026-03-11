@extends('layouts.app')

@section('title', 'Интернет-магазин')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Интернет-магазин</h1>
        <p class="mb-4">
            Добро пожаловать в интернет-магазин. Здесь доступны каталог товаров, поиск, корзина, заказы и дополнительные сервисы.
        </p>
        <a href="{{ route('products.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
            Перейти в каталог
        </a>
    </div>
@endsection

