<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TaskOwnershipMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $taskId = $request->route('task');
        
        if (!is_numeric($taskId)) {
            return abort(400, 'ID-ul task-ului este invalid.');
        }

        $task = Task::find($taskId);
            
        if (!$task || $task->user_id !== Auth::id()) {
            return abort(403, 'Nu aveți permisiunea de a accesa acest task.');
        }

        return $next($request);
    }
}