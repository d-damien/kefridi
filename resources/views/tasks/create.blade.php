@extends('layouts.app')

@section('content')
<div class="page-header">
      <h1>Create new task</h1>
</div>

<div class="container">
    @foreach ($errors->all() as $error)
        <p class="danger">{{ $error }}</p>
    @endforeach

    <form action="/tasks{{ $editing ? '/'.$task->id : '' }}" method="POST">
        {{ csrf_field() }}
        {{ $editing ? method_field('PUT') : '' }}

        <input value="{{ old('title', $task->title) }}" name="title" type="text" maxlength="255" required />
        <br />
        <textarea name="detail" type="text" maxlength="255" required>{{ old('detail', $task->detail) }}</textarea>
        <br />
        <input value="{{ old('link', $task->link) }}" name="link" type="url" />
        <br />

        <input type="submit" />

    </form>

</div>
@endsection
