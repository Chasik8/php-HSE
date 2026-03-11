@extends('layouts.app')

@section('title', 'Админка')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Административная панель</h1>
        <ul class="list-disc pl-5 space-y-1">
            <li><a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">Товары</a></li>
            <li><a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline">Категории</a></li>
            <li><a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline">Заказы</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">Пользователи</a></li>
            <li><a href="{{ route('admin.feedback.index') }}" class="text-blue-600 hover:underline">Обратная связь</a></li>
        </ul>
    </div>
@endsection

