@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-4 py-4">
        <div class="flex justify-between w-full items-center">
            <h2 class="text-grey text-sm mr-auto uppercase">Projects</h2>
            <a href="/projects/create" class="button button-blue">New project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-2">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-2 pb-4">
                <div class="bg-white rounded-md shadow p-6" style="height: 200px;">
                    <h3 class="font-normal text-xl py-4 -ml-6 border-l-4 border-blue-light pl-5 mb-2">
                        <a href="{{ $project->path() }}">{{ $project->title }}</a>
                    </h3>
                    <div class="text-grey">
                        {{ \Illuminate\Support\Str::limit($project->description, 200) }}
                    </div>
                </div>
            </div>
        @empty
            <li>No project yet.</li>
        @endforelse
    </main>
@endsection
