<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTask;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * List user tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Auth::user()->tasks;
        $statusCode = count($tasks) ? 200 : 204;

        return response()->json($tasks, $statusCode);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if ($req->user()->tasks->whereIn('task_state_id', [1, 2])->count() >= 50)
            return response()->json(['error' => 'Max tasks count reached'], 507);

        $req->validate([
            'title'     => 'required|max:255',
            'detail'    => 'required|max:255',
            'link'      => 'nullable|url'
        ]);

        $task = Task::create([
            'user_id' => $req->user()->id,
            'task_state_id' => 1,
            'title' => $req->title,
            'detail' => $req->detail,
            'link' => $req->link,
        ]);

        return response()->json(['id' => $task->id], 201);
    }

    /**
     * Display the specified task.
     * @todo authorizations
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (Gate::denies('task', $task))
            return response()->json([], 404);

        return $task; // HTTP 200 par défaut
    }

    /**
     * Update the specified task in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $task = Task::find($id);
        if (Gate::denies('task', $task))
            return response()->json([], 404);

        // Pas de màj si tâche terminée
        // ou si aucun attribut valide
        // Note : le lien peut être vide
        if ($task->task_state_id == 3)
            return response()->json(['error' => 'Task ended'], 422);
        if (!($req->title || $req->detail || $req->has('link')))
           return response()->json(['error' => 'Needs at least one argument'], 422);

        $task->title = $req->title ?? $task->title;
        $task->detail = $req->detail ?? $task->detail;
        $task->link = $req->has('link') ? $req->link : $task->link;
        $task->save();

        return [];
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (Gate::denies('task', $task))
            return response()->json([], 404);

        // Pas de suppression si tâche en cours
        if ($task->task_state_id == 2)
            return response()->json(['error' => 'Ongoing task'], 422);

        $task->delete();

        return [];
    }
}
