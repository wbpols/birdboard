<div class="card mt-3">
    <ul class="text-xs list-reset">
        @foreach ($project->activities as $activity)
            <li @if (! $loop->last)class="mb-1"@endif>
                @include("projects.activities.partials.{$activity->description}", ["activity" => $activity])
                <span class="text-gray-500">
                    {{ $activity->created_at->diffForHumans(null, true) }}
                </span>
            </li>
        @endforeach
    </ul>
</div>
