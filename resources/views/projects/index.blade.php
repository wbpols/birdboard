@extends('layouts.app')

@section('content')
    <div class="flex items-center mb-3">
        <a href="{{ route('projects.create') }}">Create New Project</a>
    </div>

    <ul>
        @forelse ($projects as $project)
            <li>
                <a href="{{ $project->path() }}">{{ $project->title }}</a>
            </li>
        @empty
            <li>No Projects yet!</li>
        @endforelse
    </ul>
@endsection
