@extends('layouts.app')

@section('content')
<div class="container">


    @foreach ($tasks as $task)
        <div class="panel task-{{ $task->state->name }}">
            <div class="panel-heading">
              <h3 class="panel-title">
                <strong>{{ $task->title }}</strong>
                <em>{{ $task->relevantDate() }}</em>
              </h3>
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

