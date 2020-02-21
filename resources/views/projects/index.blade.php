@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <h1 class="mr-auto">Projects</h1>
        <a href="/projects/create">New project</a>
    </div>

    <div class="flex">
        @forelse($projects as $project)
            <div class="bg-white mr-4 rounded shadow w-1/3 p-6" style="height: 200px;">
                <h3 class="font-normal text-xl py-4"> {{ $project->title }}</h3>
                <div class="text-grey">
                    {{ \Illuminate\Support\Str::limit($project->description, 200) }}
                </div>
            </div>
        @empty
            <li>No project yet.</li>
        @endforelse
    </div>
@endsection
