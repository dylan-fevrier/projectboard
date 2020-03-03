@if (count($activity->changes['after']) === 1)
    {{ $activity->user->id === auth()->id() ? "You" : $activity->user->name }} updated {{ key($activity->changes['after']) }} of project
@else
    {{ $activity->user->id === auth()->id() ? "You" : $activity->user->name }} updated project
@endif
