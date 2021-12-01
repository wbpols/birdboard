{{ $activity->user->is(auth()->user()) ? 'You' : $activity->user->name }} completed {{ strtolower(class_basename($activity->subject)) }} "{{ $activity->subject->body }}"
