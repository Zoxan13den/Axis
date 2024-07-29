@extends('layouts.app')

@section('title', 'Task: ' . $task->name)

@section('content')
    <div class="container">
        <h1>Edit Task</h1>
        <form action="{{ route('task.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            <div id="tasks-container">
                <div class="task-item">
                    <label for="name">Task Name:</label>
                    <input type="text" name="name" id="name" value="{{ $task->name }}" required>
                    <label for="description">Task Description:</label>
                    <textarea name="description" id="description">{{ $task->description }}</textarea>
                    <label for="priority">Task Priority:</label>
                    <select name="priority" id="priority">
                        @foreach($task_priorities as $task_priority)
                            <option value="{{ $task_priority->value }}" {{ $task->priority == $task_priority->value ? 'selected' : '' }}>{{ $task_priority->name }}</option>
                        @endforeach
                    </select>
                    <label for="status">Task Status:</label>
                    <select name="status" id="status">
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" {{ $task->status == $status->value ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <label for="deadline">Task Deadline:</label>
                    <input type="datetime-local" name="deadline" id="deadline" value="{{ $task->deadline }}">
                </div>
            </div>
            <button type="submit" class="btn btn-blue">Update Task</button>
        </form>

{{--        <h2>Comments</h2>--}}
{{--        <form action="{{ route('comments.store', $task) }}" method="POST">--}}
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
