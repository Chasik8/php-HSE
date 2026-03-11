<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Интернет-магазин')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow mb-6">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('shop.home') }}" class="text-xl font-bold text-blue-600">Магазин</a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600">Каталог</a>
                <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-blue-600">Корзина</a>
                <a href="{{ route('feedback.form') }}" class="text-gray-700 hover:text-blue-600">Обратная связь</a>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-gray-700 text-sm">
                        {{ auth()->user()->full_name ?? auth()->user()->name }}
                        ({{ auth()->user()->role }})
                    </span>
                    <a href="{{ route('orders.my') }}" class="text-gray-700 hover:text-blue-600 text-sm">Мои заказы</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 text-sm">Админка</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Выход</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 text-sm">Вход</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 text-sm">Регистрация</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>

