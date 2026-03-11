@extends('layouts.app')

@section('title', 'Обратная связь')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Форма обратной связи</h1>

        <form method="POST" action="{{ route('feedback.store') }}">
            @csrf

            @guest
                <div class="mb-4">
                    <label class="block mb-1 text-sm">Имя</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endguest

            <div class="mb-4">
                <label class="block mb-1 text-sm">Сообщение</label>
                <textarea name="message" rows="4" class="w-full border rounded px-3 py-2">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Отправить
            </button>
        </form>
    </div>
@endsection

