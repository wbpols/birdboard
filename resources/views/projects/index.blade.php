@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-center w-full">
            <h2 class="text-gray-500 text-sm font-normal">My Projects</h2>
            <a href="{{ route('projects.create') }}" class="button">Create New Project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 py-6">
                <div class="bg-white rounded-lg p-5 shadow" style="height: 200px;">
                    <h3 class="font-normal text-xl mb-4 py-4 -ml-5 border-l-4 border-blue-300 pl-4">
                        <a href="{{ $project->path() }}" class="text-black no-underline">{{ $project->title }}</a>
                    </h3>
                    <div class="text-gray-500">{{ \Illuminate\Support\Str::limit($project->description, 100) }}</div>
                </div>
            </div>
        @empty
            <div>No Projects yet!</div>
        @endforelse
    </main>
@endsection
