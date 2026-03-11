@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Регистрация</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 text-sm">ФИО</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" required
                       class="w-full border rounded px-3 py-2">
                @error('full_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border rounded px-3 py-2">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm">Пароль</label>
                <input type="password" name="password" required
                       class="w-full border rounded px-3 py-2">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                Зарегистрироваться
            </button>
        </form>
    </div>
@endsection

