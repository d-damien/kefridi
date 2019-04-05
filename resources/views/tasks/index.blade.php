@extends('layouts.app')

@section('content')
<div class="container">

    <a href="/tasks/create" class="btn">@lang('Add task')</a>

    <ul class="nav nav-tabs">
        <li class=""><a href="/tasks">@lang('All')</a></li>
        <li class="bg-warning"><a href="/tasks/list/todo">@lang('To do')</a></li>
        <li class="bg-info"><a href="/tasks/list/ongoing">@lang('Ongoing')</a></li>
        <li class="bg-success"><a href="/tasks/list/done">@lang('Done')</a></li>
    </ul>

    @foreach ($tasks as $task)
        <div class="panel task-{{ $task->state->name }}">
            <div class="panel-heading">
                @if ($task->task_state_id == 3)
                    <strong>{{ $task->title }}</strong>
                @else
                    <a href="/tasks/{{ $task->id }}">
                        <strong>{{ $task->title }}</strong>
                    </a>
                @endif
                <em>{{ $task->relevantDate() }}</em>

                <div class="pull-right">
                    @if ($task->task_state_id == 1)
                        @component('tasks.button', [
                            'path' => '/tasks/'.$task->id.'/start',
                            'method' => 'PATCH',
                            'methodName' => 'Start'])
                        @endcomponent
                    @endif

                    @if ($task->task_state_id == 2)
                        @component('tasks.button', [
                            'path' => '/tasks/'.$task->id.'/end',
                            'method' => 'PATCH',
                            'methodName' => 'End'])
                        @endcomponent
                    @endif

                    @if ($task->task_state_id != 2)
                        @component('tasks.button', [
                            'path' => '/tasks/'.$task->id,
                            'method' => 'DELETE',
                            'methodName' => 'Delete'])
                        @endcomponent
                    @endif
                </div>
            </div>

            <div class="panel-body">
                {{ $task->detail }}
            </div>

            @if ($task->link)
                <div class="panel-footer">
                    <a href="{{ $task->link }}">{{ $task->link }}</a>
                </div>
            @endif
        </div>
    @endforeach

</div>
@endsection

