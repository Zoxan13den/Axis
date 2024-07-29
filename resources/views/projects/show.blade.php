@extends('layouts.app')

@section('title', 'Project: ' . $project->name)

@section('content')
    <div class="container">
        <h1>{{ $project->name }}</h1>
        <p><strong>Description:</strong> {{ $project->description }}</p>
        <p><strong>Status:</strong> {{ $project->status ? 'Open' : 'Completed' }}</p>
        <div class="btn-container">
            <a href="{{ route('project.edit', $project) }}" class="btn btn-blue">Edit Project</a>
            <form action="{{ route('project.destroy', $project) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-red">Delete Project</button>
            </form>
        </div>

        <h2>Tasks</h2>
        <div class="task-list">
            @foreach($project->tasks as $task)
                <div class="task-item">
                    <h3>{{ $task->name }}</h3>
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
{{--                    <h4>Comments</h4>--}}
{{--                    <ul class="comment-list">--}}
{{--                        @foreach($task->comments as $comment)--}}
{{--                            <li class="comment-item">{{ $comment->content }}</li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                    <form action="{{ route('tasks.comments.store', $task) }}" method="POST" class="add-comment-form">--}}
{{--                        @csrf--}}
{{--                        <label for="content">New Comment:</label>--}}
{{--                        <textarea name="content" id="content" required></textarea>--}}
{{--                        <button type="submit" class="btn btn-blue">Add Comment</button>--}}
{{--                    </form>--}}
                </div>
            @endforeach
        </div>
    </div>
@endsection
