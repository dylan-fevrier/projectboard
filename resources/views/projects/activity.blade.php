<div class="mt-3 card">
    <ul>
        @foreach($project->activities()->latest()->get() as $activity)
            <li>
                @include("projects.activities.{$activity->description}")
                <span class="text-muted">{{ $activity->created_at->diffForHumans(null, true) }}</span>
            </li>
        @endforeach
    </ul>
</div>
