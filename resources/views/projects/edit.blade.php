@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="container">
        <h1>Edit Project</h1>
        <form action="{{ route('project.update', $project) }}" method="POST" id="project-form">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{ $project->user_id }}">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ $project->name }}" required>
            <label for="description">Description:</label>
            <textarea name="description" id="description">{{ $project->description }}</textarea>
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="1" {{ $project->status ? 'selected' : '' }}>Open</option>
                <option value="0" {{ !$project->status ? 'selected' : '' }}>Completed</option>
            </select>

            <h2>Tasks</h2>
            <div id="tasks-container">
                @foreach($project->tasks as $index => $task)
                    <div class="task-item">
                        <input type="hidden" name="tasks[{{ $index }}][id]" value="{{ $task->id }}">
                        <label for="tasks[{{ $index }}][name]">Task Name:</label>
                        <input type="text" name="tasks[{{ $index }}][name]" value="{{ $task->name }}" required>
                        <label for="tasks[{{ $index }}][description]">Task Description:</label>
                        <textarea name="tasks[{{ $index }}][description]">{{ $task->description }}</textarea>
                        <label for="tasks[{{ $index }}][priority]">Task Priority:</label>
                        <select name="tasks[{{ $index }}][priority]">
                            @foreach($task_priorities as $task_priority)
                                <option value="{{ $task_priority->value }}" {{ $task->priority == $task_priority->value ? 'selected' : '' }}>{{ ucfirst($task_priority->value) }}</option>
                            @endforeach
                        </select>
                        <label for="tasks[{{ $index }}][status]">Task Status:</label>
                        <select name="tasks[{{ $index }}][status]">
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ $task->status == $status->value ? 'selected' : '' }}>{{ ucfirst($status->value) }}</option>
                            @endforeach
                        </select>
                        <label for="tasks[{{ $index }}][deadline]">Task Deadline:</label>
                        <input type="datetime-local" name="tasks[{{ $index }}][deadline]" value="{{ $task->deadline }}">
                        <button type="button" class="btn btn-red" onclick="removeEditTask(this)">Remove</button>
                    </div>
                @endforeach
            </div>
            <div class="task-item template" style="display: none;">
                <input type="hidden" name="tasks[0][id]" value="">
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
                <button type="button" class="btn btn-red" onclick="removeEditTask(this)">Remove</button>
            </div>
            <button type="button" class="btn btn-blue" onclick="addEditTask()">Add Task</button>
            <button type="submit" class="btn btn-blue" onclick="validateForm()">Update</button>
        </form>
    </div>
@endsection

<script>
    function updateTaskEditIndices() {
        const tasks = document.querySelectorAll('.task-item:not(.template)');
        tasks.forEach((task, index) => {
            task.querySelector('input[name^="tasks["][name$="[id]"]').setAttribute('name', `tasks[${index}][id]`);
            task.querySelector('input[name^="tasks["][name$="[name]"]').setAttribute('name', `tasks[${index}][name]`);
            task.querySelector('textarea[name^="tasks["][name$="[description]"]').setAttribute('name', `tasks[${index}][description]`);
            task.querySelector('select[name^="tasks["][name$="[priority]"]').setAttribute('name', `tasks[${index}][priority]`);
            task.querySelector('select[name^="tasks["][name$="[status]"]').setAttribute('name', `tasks[${index}][status]`);
            task.querySelector('input[name^="tasks["][name$="[deadline]"]').setAttribute('name', `tasks[${index}][deadline]`);
        });
    }

    function addEditTask() {
        const container = document.getElementById('tasks-container');
        let template = document.querySelector('.task-item.template');

        if (!template) {
            console.error('Template task item not found.');
            return;
        }

        const taskItem = template.cloneNode(true);
        taskItem.classList.remove('template');
        taskItem.style.display = '';

        // Очистка значений в клонированных полях
        taskItem.querySelector('input[name^="tasks["][name$="[id]"]').value = '';
        taskItem.querySelector('input[name^="tasks["][name$="[name]"]').value = '';
        taskItem.querySelector('textarea[name^="tasks["][name$="[description]"]').value = '';
        taskItem.querySelector('select[name^="tasks["][name$="[priority]"]').selectedIndex = 0;
        taskItem.querySelector('select[name^="tasks["][name$="[status]"]').selectedIndex = 0;
        taskItem.querySelector('input[name^="tasks["][name$="[deadline]"]').value = '';

        container.appendChild(taskItem);
        updateTaskEditIndices();
    }

    function removeEditTask(button) {
        const taskItem = button.closest('.task-item');
        taskItem.remove();
        updateTaskEditIndices();
    }

    function validateForm() {
        // Удалить все шаблонные задачи перед отправкой формы
        document.querySelectorAll('.task-item.template').forEach(template => {
            template.remove();
        });

        // Проверить, есть ли пустые обязательные поля
        const tasks = document.querySelectorAll('.task-item:not(.template)');
        tasks.forEach(task => {
            const name = task.querySelector('input[name^="tasks["][name$="[name]"]').value;
            if (!name) {
                task.querySelector('input[name^="tasks["][name$="[name]"]').focus();
                return false;
            }
        });

        // Отправить форму
        document.getElementById('project-form').submit();
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateTaskEditIndices();
    });
</script>