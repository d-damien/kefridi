<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Controllers\Api\TaskController as ApiTaskController;

class TaskController extends ApiTaskController
{
    /**
     * Common error gestion to call parent API
     * @param string $functionName probably __FUNCTION__
     * @param $arg transfer argument to parent
     * @param int $statusCode to compare return with
     */
    protected function handleApiErrors($functionName, $arg, $expectedCode) {
        $res = parent::$functionName($arg);
        if ($res->getStatusCode() != $expectedCode)
            return abort($res->getStatusCode());

        return $res;
    }

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
        $editing = false;
        $task = new Task;

        return response()->view(
            'tasks.create',
            compact('editing', 'task'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->handleApiErrors('store', $request, 201);

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
        $res = $this->handleApiErrors('show', $id, 200);

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
        $this->handleApiErrors('destroy', $id, 200);

        return redirect('/tasks');
    }

    public function start($id)
    {
        $this->handleApiErrors('start', $id, 200);

        return redirect()->back();
    }

    public function end($id) {
        $this->handleApiErrors('end', $id, 200);

        return redirect()->back();
    }


}
