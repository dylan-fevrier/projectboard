@extends('layouts.app')

@section('content')
    <div class="card lg:w-1/2 lg:mx-auto">
        <h1 class="text-2xl text-center mb-10">Create a Project</h1>

        <form action="{{ route('projects.store') }}" method="POST">
            @include('projects.form', [
                'project' => new \App\Project(),
                'buttonText' => "Create project"
            ])
        </form>
    </div>
@endsection
