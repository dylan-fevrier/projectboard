<div class="card flex flex-col" style="height: 200px;">
    <h3 class="card-title">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h3>
    <div class="text-muted flex-1 mb-4">
        {{ \Illuminate\Support\Str::limit($project->description, 200) }}
    </div>

    @can ('owner', $project)
        {{ $project->name }}
        <delete-project
            id="{{ $project->id }}"
            path="{{ $project->path() }}"
            title="{{ $project->title }}">
        </delete-project>
    @endcan
</div>
