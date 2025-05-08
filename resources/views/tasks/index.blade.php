@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Taskuri</h1>
        @auth
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Adaugă Task Nou</a>
        @else
        <a href="{{ route('login') }}" class="btn btn-primary">Conectează-te pentru a adăuga taskuri</a>
        @endauth
    </div>

    @if (Auth::check() && $personalTasks->count() > 0)
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Taskurile mele</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($personalTasks as $task)
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h2 class="card-title">{{ $task->title }}</h2>
                        <div class="badge {{ $task->status === 'public' ? 'badge-success' : 'badge-warning' }}">
                            {{ $task->status }}
                        </div>
                    </div>
                    <p class="my-2">{{ Str::limit($task->description, 100) }}</p>
                    <div class="card-actions justify-end">
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-primary">Vezi</a>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-info">Editează</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-error" onclick="return confirm('Ești sigur că vrei să ștergi acest task?')">Șterge</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div>
        <h2 class="text-xl font-semibold mb-4">Taskuri publice</h2>
        @if ($publicTasks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($publicTasks as $task)
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h2 class="card-title">{{ $task->title }}</h2>
                        <div class="badge badge-success">public</div>
                    </div>
                    <p class="my-2">{{ Str::limit($task->description, 100) }}</p>
                    <p class="text-sm text-gray-500">Creat de: {{ $task->user->name }}</p>
                    <div class="card-actions justify-end">
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-primary">Vezi</a>
                        @if (Auth::check() && $task->user_id === Auth::id())
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-info">Editează</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-error" onclick="return confirm('Ești sigur că vrei să ștergi acest task?')">Șterge</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-info">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Nu există taskuri publice momentan.</span>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection