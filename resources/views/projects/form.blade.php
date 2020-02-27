@csrf

@if($errors->any())
    <div class="mb-6">
        @foreach($errors->all() as $error)
            <p class="text-sm text-red-600">{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="field mb-6">
    <label for="title" class="text-sm mb-2 block">Title</label>
    <div class="control">
        <input
            type="text"
            class="input"
            name="title"
            placeholder="Title"
            required
            value="{{ $project->title }}"
        >
    </div>
</div>

<div class="field mb-6">
    <label for="description" class="label">Description</label>
    <div class="control">
        <textarea
            name="description"
            id="description"
            class="input h-56"
            placeholder="Lorem ipsum"
            required
        >{{ $project->description }}</textarea>
    </div>
</div>

<button class="button button-blue">{{ $buttonText }}</button>
<a href="{{ $project->path() }}" class="underline ml-2">Cancel</a>
