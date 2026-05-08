@extends('layouts.app')

@section('content')

<h2 class="text-xl mb-4">Modifier tâche</h2>

<form method="POST" action="{{ route('tasks.update', $task) }}">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ $task->title }}" class="w-full mb-2 p-2 border">

    <textarea name="description" class="w-full mb-2 p-2 border">{{ $task->description }}</textarea>

    <select name="status" class="w-full mb-2 p-2 border">
        <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>Todo</option>
        <option value="doing" {{ $task->status == 'doing' ? 'selected' : '' }}>Doing</option>
        <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
    </select>

    <button class="bg-blue-100 text-black px-4 py-2">Mettre à jour</button>

</form>

@endsection