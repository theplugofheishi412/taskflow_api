@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Mes tâches</h2>
    <a href="{{ route('tasks.create') }}" class="bg-blue-100 text-black px-4 py-2 rounded">+ Ajouter</a>
</div>

@foreach($tasks as $task)
<div class="bg-white p-4 mb-3 rounded shadow">
    <h3 class="font-bold">{{ $task->title }}</h3>
    <p>{{ $task->description }}</p>
    <span class="text-sm text-gray-500">{{ $task->status }}</span>

    <div class="mt-2">
        <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-500">Modifier</a>

        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button class="text-red-100">Supprimer</button>
        </form>
    </div>
</div>
@endforeach

@endsection