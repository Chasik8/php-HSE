@extends('layouts.app')

@section('title', 'Сообщения обратной связи')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Сообщения обратной связи</h1>

        @if($feedback->count() === 0)
            <p>Сообщений нет.</p>
        @else
            <div class="space-y-4">
                @foreach($feedback as $item)
                    <div class="border rounded p-4 text-sm">
                        <div class="flex justify-between mb-1">
                            <div>
                                {{ $item->name ?? $item->user?->full_name ?? $item->user?->name ?? 'Пользователь' }}
                                @if($item->email)
                                    ({{ $item->email }})
                                @endif
                            </div>
                            <div>
                                {{ $item->created_at->format('d.m.Y H:i') }}
                            </div>
                        </div>
                        <p>{{ $item->message }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $feedback->links() }}
            </div>
        @endif
    </div>
@endsection

