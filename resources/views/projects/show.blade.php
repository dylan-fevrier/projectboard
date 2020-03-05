@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-4 py-4 mx-4 lg:mx-0">

        <div class="flex w-full justify-between items-end">

            <p class="text-muted text-sm font mr-2">
                <a href="/projects" class="text-default hover:underline focus:underline">My Projects</a>
                 / {{ $project->title }}
            </p>
            <div class="flex">
                @foreach($project->members as $member)
                    <img src="{{ \App\Helper\BladeHelper::url_gravatar($member->email) }}"
                         alt="{{ $member->name }}'s avatar"
                         class="rounded-full mr-2"
                         title="{{ $member->name }}">
                @endforeach

                <img src="{{ \App\Helper\BladeHelper::url_gravatar($project->owner->email) }}"
                     alt="{{ $project->owner->name }}'s avatar"
                     class="rounded-full"
                     title="{{ $project->owner->name }}">
                <a href="{{ $project->path() . "/edit" }}" class="button button-blue ml-5">Edit project</a>
            </div>

        </div>

    </header>

    <main>
        @include('components.errors')

        <div class="lg:flex lg:-mx-4">
            <div class="lg:w-2/3 px-4 mb-8">
                <section class="mb-6">
                    <div class="text-muted mb-3 flex justify-between items-end">
                        <h2 class="text-muted text-sm uppercase text-lg">Tasks</h2>
                    </div>
                    @foreach($project->tasks as $task)
                        <div class="card mb-2">
                            <form action="{{ $task->path() }}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="flex items-center">
                                    <input
                                        type="text"
                                        value="{{ $task->body }}"
                                        name="body"
                                        class="text-default bg-card w-full {{ $task->completed ? 'text-muted line-through' : '' }} outline-none">
                                    <input type="checkbox" name="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                        <form action="{{ $project->path() . '/tasks' }}" method="post">
                            @csrf
                            <input type="text" placeholder="Add a new task..." name="body" class="w-full card outline-none">
                        </form>
                </section>
                <section>

                    <h2 class="text-muted text-sm uppercase text-lg mb-3">General Notes</h2>

                    <form action="{{ $project->path() }}" method="POST">
                        @method('PATCH')
                        @csrf

                        <textarea
                            class="card w-full outline-none"
                            style="min-height: 200px"
                            placeholder="Anything special that you want to make a note of ?"
                            name="notes">{{ $project->notes }}</textarea>

                        <button class="button button-blue">Save</button>
                    </form>

                </section>
            </div>
            <div class="lg:w-1/3 px-4 lg:py-10">
                @include('projects.card')

                @can ('owner', $project)
                    @include('projects.invite')
                @endcan

                @include('projects.activity')
            </div>
        </div>
    </main>
@endsection
