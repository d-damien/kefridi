@extends('layouts.app')

@section('content')
<div class="container">

    <a href="/tasks/create" class="btn">@lang('Add task')</a>

    <ul class="nav nav-tabs">
        <li class=""><a href="/tasks">@lang('All')</a></li>
        <li class=""><a href="/tasks/list/todo">@lang('To do')</a></li>
        <li class=""><a href="/tasks/list/ongoing">@lang('Ongoing')</a></li>
        <li class=""><a href="/tasks/list/done">@lang('Done')</a></li>
    </ul>

    @foreach ($tasks as $task)
        <div class="panel task-{{ $task->state->name }}">
            <div class="panel-heading">
                <strong>{{ $task->title }}</strong>
                <em>{{ $task->relevantDate() }}</em>
                <div class="pull-right">
                    @if ($task->task_state_id != 3)
                        <a href="/tasks/{{ $task->id }}">@lang('Edit')</a>
                    @endif

                    @if ($task->task_state_id != 2)
                        <!-- form & jeton permettent d'éviter les failles CSRF -->
                        <form action="/tasks/{{ $task->id }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="submit" class="btn" value="@lang('Delete')" />
                        </form>
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

