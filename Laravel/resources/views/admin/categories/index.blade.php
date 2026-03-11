@extends('layouts.app')

@section('title', 'Категории')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Категории</h1>
            <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
                Добавить категорию
            </a>
        </div>

        @if($categories->count() === 0)
            <p>Категорий нет.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">ID</th>
                        <th class="text-left py-2">Название</th>
                        <th class="text-left py-2">Родитель</th>
                        <th class="text-right py-2">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr class="border-b">
                            <td class="py-2">{{ $category->id }}</td>
                            <td class="py-2">{{ $category->name }}</td>
                            <td class="py-2">{{ $category->parent?->name ?? '—' }}</td>
                            <td class="py-2 text-right">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline text-xs mr-2">
                                    Редактировать
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs"
                                            onclick="return confirm('Удалить категорию?')">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

