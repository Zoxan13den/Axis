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
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" required>
                                <label for="description">Description:</label>
                                <textarea name="description" id="description"></textarea>
                                <label for="status">Status:</label>
                                <select name="status" id="status">
                                    <option value="1">Open</option>
                                    <option value="0">Completed</option>
                                </select>
                                <label for="deadline">Deadline:</label>
                                <input type="date" name="deadline" id="deadline">

                                <h2>Tasks</h2>
                                <div id="tasks-container">
                                    <div class="task-item">
                                        <label for="task_name[]">Task Name:</label>
                                        <input type="text" name="task_name[]" required>
                                        <label for="task_description[]">Task Description:</label>
                                        <textarea name="task_description[]"></textarea>
                                        <label for="task_priority[]">Task Priority:</label>
                                        <select name="task_priority[]">
                                            <option value="низький">Низький</option>
                                            <option value="середній">Середній</option>
                                            <option value="високий">Високий</option>
                                        </select>
                                        <label for="task_status[]">Task Status:</label>
                                        <select name="task_status[]">
                                            <option value="відкрито">Відкрито</option>
                                            <option value="в процесі">В процесі</option>
                                            <option value="завершено">Завершено</option>
                                        </select>
                                        <label for="task_deadline[]">Task Deadline:</label>
                                        <input type="date" name="task_deadline[]">
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
