@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-500 text-sm font-normal">
                <a href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title}}
            </p>
            <a href="{{ route('projects.create') }}" class="button">Create New Project</a>
        </div>
    </header>

    <main class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3">
            <div class="mb-8">
                <h2 class="text-lg text-gray-500 font-normal mb-3">Tasks</h2>
                {{-- tasks --}}
                @foreach ($project->tasks as $task)
                    <div class="card mb-3">{{ $task->body }}</div>
                @endforeach
            </div>
            <div>
                <h2 class="text-lg text-gray-500 font-normal mb-3">General Notes</h2>

                {{-- general notes --}}
                <textarea class="card w-full" style="min-height: 200px;">Lorem ipsum.</textarea>
            </div>
        </div>
        <div class="lg:w-1/4 px-3 mt-10">
            @include('projects.partials.card', ["project" =>  $project])
        </div>
    </main>
@endsection
