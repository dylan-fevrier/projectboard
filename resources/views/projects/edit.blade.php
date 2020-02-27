@extends('layouts.app')

@section('content')
    <div class="card lg:w-1/2 lg:mx-auto">
        <h1 class="text-2xl text-center mb-10">Update a Project</h1>

        <form action="{{ route('projects.update', ['project' => $project->id]) }}" method="POST">
            @method('PATCH')

            @include('projects.form', [
                'buttonText' => "Save project"
            ])
        </form>
    </div>
@endsection
