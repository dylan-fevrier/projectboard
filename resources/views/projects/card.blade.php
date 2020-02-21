<div class="card" style="height: 200px;">
    <h3 class="card-title">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h3>
    <div class="text-grey">
        {{ \Illuminate\Support\Str::limit($project->description, 200) }}
    </div>
</div>
