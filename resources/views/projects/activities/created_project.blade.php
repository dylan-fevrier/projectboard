{{ $activity->user->id === auth()->id() ? "You" : $activity->user->name }} created project
