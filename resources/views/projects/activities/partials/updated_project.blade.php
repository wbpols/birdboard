@if (count($activity->changes['after']) === 1)
    {{ $activity->user->is(auth()->user()) ? 'You' : $activity->user->name }} {{ $activity->description }} the {{ array_key_first($activity->changes['after']) }} of the Project.
@else
    {{ $activity->user->is(auth()->user()) ? 'You' : $activity->user->name }} {{ $activity->description }} the Project
@endif
