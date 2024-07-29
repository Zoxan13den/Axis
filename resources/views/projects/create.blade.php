@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Project</div>
                    <div class="card-body">
                        <div class="container">
                            <h1>Create Project</h1>
                            <form action="{{ route('project.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}" required>
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" required>
                                <label for="description">Description:</label>
                                <textarea name="description" id="description"></textarea>
                                <label for="status">Status:</label>
                                <select name="status" id="status">
                                    <option value="1">Open</option>
                                    <option value="0">Completed</option>
                                </select>

                                <h2>Tasks</h2>
                                <div id="tasks-container">
                                    <div class="task-item">
                                        <label for="tasks[0][name]">Task Name:</label>
                                        <input type="text" name="tasks[0][name]" required>
                                        <label for="tasks[0][description]">Task Description:</label>
                                        <textarea name="tasks[0][description]"></textarea>
                                        <label for="tasks[0][priority]">Task Priority:</label>
                                        <select name="tasks[0][priority]">
                                            @foreach($task_priorities as $task_priority)
                                                <option value="{{ $task_priority->value }}">{{ ucfirst($task_priority->value) }}</option>
                                            @endforeach
                                        </select>
                                        <label for="tasks[0][status]">Task Status:</label>
                                        <select name="tasks[0][status]">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>
                                            @endforeach
                                        </select>
                                        <label for="tasks[0][deadline]">Task Deadline:</label>
                                        <input type="datetime-local" name="tasks[0][deadline]">
                                        <button type="button" class="btn btn-red" onclick="removeTask(this)">Remove</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-blue" onclick="addTask()">Add Task</button>
                                <button type="submit" class="btn btn-blue">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function updateTaskIndices() {
        const tasks = document.querySelectorAll('.task-item');
        tasks.forEach((task, index) => {
            task.querySelector('input[name^="tasks["]').setAttribute('name', `tasks[${index}][name]`);
            task.querySelector('textarea[name^="tasks["]').setAttribute('name', `tasks[${index}][description]`);
            task.querySelector('select[name^="tasks["][name*="[priority]"]').setAttribute('name', `tasks[${index}][priority]`);
            task.querySelector('select[name^="tasks["][name*="[status]"]').setAttribute('name', `tasks[${index}][status]`);
            task.querySelector('input[name^="tasks["][type="datetime-local"]').setAttribute('name', `tasks[${index}][deadline]`);
        });
    }

    function addTask() {
        const container = document.getElementById('tasks-container');
        const firstTask = container.querySelector('.task-item');
        const taskItem = firstTask.cloneNode(true);

        // Очистка значений в клонированных полях
        taskItem.querySelector('input[name^="tasks["]').value = '';
        taskItem.querySelector('textarea[name^="tasks["]').value = '';
        taskItem.querySelector('select[name^="tasks["][name*="[priority]"]').selectedIndex = 0;
        taskItem.querySelector('select[name^="tasks["][name*="[status]"]').selectedIndex = 0;
        taskItem.querySelector('input[name^="tasks["][type="datetime-local"]').value = '';

        container.appendChild(taskItem);
        updateTaskIndices();
    }

    function removeTask(button) {
        const taskItem = button.closest('.task-item');
        taskItem.remove();
        updateTaskIndices();
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateTaskIndices();
    });
</script>
