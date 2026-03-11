@extends('layouts.app')

@section('title', 'Пользователи')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Пользователи</h1>

        @if($users->count() === 0)
            <p>Пользователей нет.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">ID</th>
                        <th class="text-left py-2">ФИО</th>
                        <th class="text-left py-2">Email</th>
                        <th class="text-left py-2">Роль</th>
                        <th class="text-left py-2">Изменить роль</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b">
                            <td class="py-2">{{ $user->id }}</td>
                            <td class="py-2">{{ $user->full_name ?? $user->name }}</td>
                            <td class="py-2">{{ $user->email }}</td>
                            <td class="py-2">{{ $user->role }}</td>
                            <td class="py-2">
                                <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="flex items-center space-x-2">
                                    @csrf
                                    <select name="role" class="border rounded px-2 py-1 text-sm">
                                        <option value="customer" @selected($user->role === 'customer')>Покупатель</option>
                                        <option value="admin" @selected($user->role === 'admin')>Администратор</option>
                                    </select>
                                    <button type="submit" class="text-blue-600 hover:underline text-sm">
                                        Сохранить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection

