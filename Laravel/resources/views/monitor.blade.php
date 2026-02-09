<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мониторы</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Форма для монитора</h1>

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

        <form method="POST" action="{{ route('monitor.save') }}" class="mb-8">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Название</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Цена (руб)</label>
                <input type="number" name="price" id="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required min="0">
            </div>
            <div class="mb-4">
                <label for="releaseDate" class="block text-sm font-medium text-gray-700">Дата выпуска</label>
                <input type="date" name="releaseDate" id="releaseDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="matrix" class="block text-sm font-medium text-gray-700">Тип матрицы</label>
                <input type="text" name="matrix" id="matrix" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="resolution" class="block text-sm font-medium text-gray-700">Разрешение</label>
                <input type="text" name="resolution" id="resolution" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="refreshRate" class="block text-sm font-medium text-gray-700">Частота обновления (Гц)</label>
                <input type="number" name="refreshRate" id="refreshRate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required min="1">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Сохранить</button>
        </form>

        <form method="POST" action="{{ route('monitor.find') }}">
            @csrf
            <!-- Поля те же, но не required для поиска -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Название (для поиска)</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <!-- Аналогично для других полей, но без required -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Цена (для поиска)</label>
                <input type="number" name="price" id="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="0">
            </div>
            <div class="mb-4">
                <label for="releaseDate" class="block text-sm font-medium text-gray-700">Дата выпуска (для поиска)</label>
                <input type="date" name="releaseDate" id="releaseDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="matrix" class="block text-sm font-medium text-gray-700">Тип матрицы (для поиска)</label>
                <input type="text" name="matrix" id="matrix" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="resolution" class="block text-sm font-medium text-gray-700">Разрешение (для поиска)</label>
                <input type="text" name="resolution" id="resolution" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="refreshRate" class="block text-sm font-medium text-gray-700">Частота обновления (Гц, для поиска)</label>
                <input type="number" name="refreshRate" id="refreshRate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Описание (для поиска)</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Найти</button>
        </form>

        @if (isset($message))
            <div class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                {{ $message }}
            </div>
        @endif

        @if (isset($found) && !empty($found))
            <h2 class="text-xl font-bold mt-8 mb-4">Найденные мониторы:</h2>
            <ul class="list-disc pl-5">
                @foreach ($found as $monitor)
                    <li class="mb-2">
                        <strong>{{ $monitor['name'] }}</strong> - Цена: {{ $monitor['price'] }} руб, Дата: {{ $monitor['releaseDate'] }}, Матрица: {{ $monitor['matrix'] }}, Разрешение: {{ $monitor['resolution'] }}, Частота: {{ $monitor['refreshRate'] }} Гц, Описание: {{ $monitor['description'] }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
