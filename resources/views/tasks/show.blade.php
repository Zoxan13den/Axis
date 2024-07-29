@extends('layouts.app')

@section('title', 'Task: ' . $task->name)

@section('content')
    <div class="container">
        <h1>{{ $task->name }}</h1>
        <p><strong>Description:</strong> {{ $task->description }}</p>
        <p><strong>Priority:</strong> {{ $task->priority }}</p>
        <p><strong>Status:</strong> {{ $task->status }}</p>
        <p><strong>Deadline:</strong> {{ $task->deadline }}</p>
        <div class="btn-container">
            <a href="{{ route('task.edit', $task) }}" class="btn btn-blue">Edit Task</a>
            <form action="{{ route('task.destroy', $task) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-red">Delete Task</button>
            </form>
        </div>
    </div>
{{--        <h2>Comments</h2>--}}
{{--        <form action="{{ route('tasks.comments.store', $task) }}" method="POST">--}}
{{--            @csrf--}}
{{--            <label for="content">New Comment:</label>--}}
{{--            <textarea name="content" id="content" required></textarea>--}}
{{--            <button type="submit" class="btn btn-blue">Add Comment</button>--}}
{{--        </form>--}}
{{--        <ul class="comment-list">--}}
{{--            @foreach($task->comments as $comment)--}}
{{--                <li class="comment-item">--}}
{{--                    {{ $comment->content }}--}}
{{--                    <form action="{{ route('tasks.comments.destroy', $comment) }}" method="POST" style="display:inline;">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit" class="btn btn-red">Delete</button>--}}
{{--                    </form>--}}
{{--                </li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
    </div>
@endsection
