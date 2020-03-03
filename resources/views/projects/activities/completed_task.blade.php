{{ $activity->user->id === auth()->id() ? "You" : $activity->user->name }} complete task <span class="italic">{{ $activity->subject->body }}</span>
