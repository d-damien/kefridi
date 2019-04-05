<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Controllers\Api\TaskController as ApiTaskController;

class TaskController extends ApiTaskController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($action = null)
    {
        $res = $this->retrieve($action);
        $tasks = $res['tasks'];
        $statusCode = $res['statusCode'];

        return response()->view(
            'tasks.index',
            compact('tasks', 'action'),
            $statusCode);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $res = parent::store($request);
        if ($res->getStatusCode() == 507)
            return view('errors.507');

        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $res = parent::show($id);
        if ($res->getStatusCode() == 404)
            return abort(404);

        $task = json_decode($res->getContent());
        $editing = true;

        return response()->view(
            'tasks.create',
            compact('task', 'editing'),
            200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $res = parent::update($request, $id);
        $statusCode = $res->getStatusCode();
        if (in_array($statusCode, [422, 404]))
            abort($statusCode);

        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = parent::destroy($id);
        $statusCode = $res->getStatusCode();
        if (in_array($statusCode, [422, 404]))
            abort($statusCode);

        return redirect('/tasks');
    }
}
