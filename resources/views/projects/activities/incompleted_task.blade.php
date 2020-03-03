{{ $activity->user->id === auth()->id() ? "You" : $activity->user->name }} incomplete task <span class="italic">{{ $activity->subject->body }}</span>
