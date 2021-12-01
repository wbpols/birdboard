{{ $activity->user->is(auth()->user()) ? 'You' : $activity->user->name }} marked {{ strtolower(class_basename($activity->subject)) }} "{{ $activity->subject->body }}" as uncompleted
