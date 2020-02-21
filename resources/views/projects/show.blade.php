@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-4 py-4 mx-4 lg:mx-0">
        <div class="flex w-full items-end">
            <p class="text-grey text-sm font mr-2">
                <a href="/projects">My Projects </a>
                / {{ $project->title }}
            </p>
        </div>
    </header>

    <main>
        <div class="lg:flex lg:-mx-4">
            <div class="lg:w-2/3 px-4 mb-8">
                <section class="mb-6">
                    <div class="text-grey mb-2 flex justify-between items-end">
                        <h2 class="text-grey text-sm uppercase text-lg">Tasks</h2>
                        <a href="/projects/create" class="button button-blue">New task</a>
                    </div>
                    <div class="card mb-2">one task</div>
                    <div class="card">one task</div>
                </section>
                <section>
                    <h2 class="text-grey text-sm uppercase text-lg mb-2">General Notes</h2>
                    <textarea class="card w-full" style="min-height: 200px">Lorem ipsum.</textarea>
                </section>
            </div>
            <div class="lg:w-1/3 px-4">
                @include('projects.card')
            </div>
        </div>
    </main>
@endsection
