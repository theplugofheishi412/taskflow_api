@extends('layouts.app')

@section('content')

<h2 class="text-xl mb-4">Nouvelle tâche</h2>

<form method="POST" action="{{ route('tasks.store') }}">
    @csrf

    <input type="text" name="title" placeholder="Titre" class="w-full mb-2 p-2 border">

    <textarea name="description" placeholder="Description" class="w-full mb-2 p-2 border"></textarea>

    <select name="status" class="w-full mb-2 p-2 border">
        <option value="todo">Todo</option>
        <option value="doing">Doing</option>
        <option value="done">Done</option>
    </select>

    <button class="bg-blue-100 text-black px-4 py-2">Créer</button>

</form>

@endsection