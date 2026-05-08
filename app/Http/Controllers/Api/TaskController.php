<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->latest()->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'in:todo,doing,done',
        ]);

        $task = Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status ?? 'todo',
            'user_id'     => Auth::id(),
        ]);

        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'  => 'sometimes|string|max:255',
            'status' => 'sometimes|in:todo,doing,done',
        ]);

        $task->update($request->all());
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted'], 200);
    }
}
