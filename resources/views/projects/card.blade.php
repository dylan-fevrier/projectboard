<div class="card" style="height: 200px;">
    <h3 class="card-title">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h3>
    <div class="text-grey mb-4">
        {{ \Illuminate\Support\Str::limit($project->description, 200) }}
    </div>

    <footer>
        <form action="{{ $project->path() }}"  method="post" class="text-right">
            @csrf
            @method('delete')
            <button type="submit" class="text-xs">Delete</button>
        </form>
    </footer>
</div>
