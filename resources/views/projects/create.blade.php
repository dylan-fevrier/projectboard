@extends('layouts.app')

@section('content')
    <form action="{{ route('projects.store') }}" method="POST">
        <h1 class="heading is-size-4">Create a Project</h1>

        @csrf

        <div class="field">
            <label for="title" class="label">Title</label>
            <div class="control">
                <input type="text" class="input" name="title" placeholder="Title">
            </div>
        </div>

        <div class="field">
            <label for="description" class="label">Description</label>
            <div class="control">
                <textarea name="description" id="description" class="textarea" ></textarea>
            </div>
        </div>

        <button class="button is-primary">Add</button>
        <a href="/projects">Cancel</a>
    </form>
@endsection
