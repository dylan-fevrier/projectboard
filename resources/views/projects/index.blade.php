@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-4 py-4">
        <div class="flex justify-between w-full items-end">
            <h2 class="text-muted text-sm mr-auto">My Projects</h2>
            <a href="/projects/create" class="button button-blue">New project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-2">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-2 pb-4">
                @include('projects.card')
            </div>
        @empty
            <li>No project yet.</li>
        @endforelse
    </main>
@endsection
