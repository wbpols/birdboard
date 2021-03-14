@extends('layouts.app')

@section('content')
    <div class="flex items-center mb-3">
        <a href="{{ route('projects.create') }}">Create New Project</a>
    </div>

    <div class="flex">
        @forelse ($projects as $project)
            <div class="bg-white mr-4 rounded p-5 shadow w-1/3" style="height: 200px;">
                {{-- <a href="{{ $project->path() }}"> --}}
                    <h3 class="font-normal text-xl mb-4 py-4">{{ $project->title }}</h3>
                {{-- </a> --}}
                <div class="text-gray-500">{{ \Illuminate\Support\Str::limit($project->description, 100) }}</div>
            </div>
        @empty
            <div>No Projects yet!</div>
        @endforelse
    </div>
@endsection
