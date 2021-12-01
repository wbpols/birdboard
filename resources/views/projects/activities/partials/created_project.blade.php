{{ $activity->user->is(auth()->user()) ? 'You' : $activity->user->name }} {{ $activity->description }} the Project
