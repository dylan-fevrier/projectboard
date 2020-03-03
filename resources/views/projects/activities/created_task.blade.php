{{ $activity->user->id === auth()->id() ? "You" : $activity->user->name }} created task <span class="italic">{{ $activity->subject->body }}</span>
