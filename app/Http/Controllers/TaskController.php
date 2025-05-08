<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller; 
class TaskController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth')->except(['index', 'show']);
    }


    public function index()
    {
        $publicTasks = Task::where('status', 'public')->get();
        $personalTasks = Auth::check() ? Auth::user()->tasks : collect();

        return view('tasks.index', [
            'publicTasks' => $publicTasks,
            'personalTasks' => $personalTasks
        ]);
    }


    public function create()
    {
        return view('tasks.create');
    }


    public function store(Request $request)
    {
        if (!Auth::check()) {
            dd('User not authenticated');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:public,private',
        ]);

        $task = Auth::user()->tasks()->create($validated);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task creat cu succes!');
    }


    public function show(Task $task)
    {
        if ($task->status === 'public' || (Auth::check() && $task->user_id === Auth::id())) {
            return view('tasks.show', compact('task'));
        }

        return abort(403, 'Nu aveți permisiunea de a vizualiza acest task.');
    }


    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return abort(403, 'Nu aveți permisiunea de a edita acest task.');
        }

        return view('tasks.edit', compact('task'));
    }


    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return abort(403, 'Nu aveți permisiunea de a actualiza acest task.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:public,private',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'Task actualizat cu succes!');
    }


    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return abort(403, 'Nu aveți permisiunea de a șterge acest task.');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task șters cu succes!');
    }
}