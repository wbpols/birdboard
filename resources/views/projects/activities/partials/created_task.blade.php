{{ $activity->user->is(auth()->user()) ? 'You' : $activity->user->name }} created "{{ $activity->subject->body }}"
