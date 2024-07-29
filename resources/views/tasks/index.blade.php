@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="container">
                    <h1>Projects</h1>
                    <div class="add-btn-container">
                        <a href="{{ route('project.create') }}" class="btn btn-blue">Create New Project</a>
                    </div>
                    <ul class="project-list">
                        @foreach($projects as $project)
                            <li class="project-item">
                                <a href="{{ route('project.show', $project) }}" class="project-link">{{ $project->name }}</a>
                                <div class="btn-container">
                                    <a href="{{ route('project.edit', $project) }}" class="btn btn-blue">Edit</a>
                                    <form action="{{ route('project.destroy', $project) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-red">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
