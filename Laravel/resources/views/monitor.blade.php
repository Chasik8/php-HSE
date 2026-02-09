<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мониторы - Расширенный</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6">Управление мониторами</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <!-- Табы: Добавить/Поиск -->
        <div x-data="{ tab: 'add' }" class="mb-8">
            <div class="flex border-b mb-4">
                <button @click="tab = 'add'" :class="{ 'border-b-2 border-blue-500': tab === 'add' }" class="px-4 py-2">Добавить/Редактировать</button>
                <button @click="tab = 'find'" :class="{ 'border-b-2 border-blue-500': tab === 'find' }" class="px-4 py-2">Поиск</button>
            </div>

            <div x-show="tab === 'add'">
                <form method="POST" action="{{ route('monitor.save') }}">
                    @csrf
                    <input type="hidden" name="id" id="edit-id">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label>Название</label>
                            <input type="text" name="name" id="name" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label>Цена (руб)</label>
                            <input type="number" name="price" id="price" class="w-full border p-2 rounded" required min="0">
                        </div>
                        <div>
                            <label>Дата выпуска</label>
                            <input type="date" name="releaseDate" id="releaseDate" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label>Тип матрицы</label>
                            <input type="text" name="matrix" id="matrix" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label>Разрешение</label>
                            <input type="text" name="resolution" id="resolution" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label>Частота (Гц)</label>
                            <input type="number" name="refreshRate" id="refreshRate" class="w-full border p-2 rounded" required min="1">
                        </div>
                        <div class="col-span-2">
                            <label>Описание</label>
                            <textarea name="description" id="description" class="w-full border p-2 rounded"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Сохранить</button>
                </form>
            </div>

            <div x-show="tab === 'find'">
                <form method="POST" action="{{ route('monitor.find') }}">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label>Название</label>
                            <input type="text" name="name" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label>Цена от</label>
                            <input type="number" name="price_min" class="w-full border p-2 rounded" min="0">
                        </div>
                        <div>
                            <label>Цена до</label>
                            <input type="number" name="price_max" class="w-full border p-2 rounded" min="0">
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Найти</button>
                </form>
            </div>
        </div>

        <!-- Список мониторов -->
        <h2 class="text-2xl font-bold mb-4">Список мониторов ({{ count($monitors) }})</h2>
        <a href="{{ route('monitor.export') }}" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded">Экспорт в CSV</a>

        @if (isset($message))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">{{ $message }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach (isset($found) ? $found : $monitors as $monitor)
                <div class="bg-gray-50 p-4 rounded shadow">
                    <h3 class="font-bold">{{ $monitor['name'] }}</h3>
                    <p>Цена: {{ $monitor['price'] }} руб</p>
                    <p>Дата: {{ $monitor['releaseDate'] }}</p>
                    <p>Матрица: {{ $monitor['matrix'] }}</p>
                    <p>Разрешение: {{ $monitor['resolution'] }}</p>
                    <p>Частота: {{ $monitor['refreshRate'] }} Гц</p>
                    <p>Описание: {{ Str::limit($monitor['description'], 100) }}</p>
                    <div class="mt-2">
                        <button onclick="editMonitor({{ json_encode($monitor) }})" class="text-blue-500">Редактировать</button>
                        <form action="{{ route('monitor.delete', $monitor['id']) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-500 ml-4" onclick="return confirm('Удалить?')">Удалить</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div x-data="{ open: false, monitor: {} }" x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg">
                <h2 class="text-xl mb-4">Редактировать монитор</h2>
                <button @click="open = false" class="absolute top-2 right-2">X</button>
            </div>
        </div>
    </div>

    <script>
        function editMonitor(monitor) {
            document.getElementById('edit-id').value = monitor.id;
            document.getElementById('name').value = monitor.name;
            document.getElementById('price').value = monitor.price;
            document.getElementById('releaseDate').value = monitor.releaseDate;
            document.getElementById('matrix').value = monitor.matrix;
            document.getElementById('resolution').value = monitor.resolution;
            document.getElementById('refreshRate').value = monitor.refreshRate;
            document.getElementById('description').value = monitor.description;
            alpineStore.tab = 'add';
        }
    </script>
</body>
</html>
