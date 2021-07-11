@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-500 text-sm font-normal">
                <a href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title}}
            </p>
            <a href="{{ "{$project->path()}/edit" }}" class="button">Edit Project</a>
        </div>
    </header>

    <main class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3">
            <div class="mb-8">
                <h2 class="text-lg text-gray-500 font-normal mb-3">Tasks</h2>
                {{-- tasks --}}
                @foreach ($project->tasks as $task)
                    <form action="{{ $task->path() }}" method="POST">
                        <div class="card mb-3">
                            <div class="flex">
                                <input id="body" name="body" type="text" class="w-full @if ($task->completed)text-gray-500 @endif" value="{{ $task->body }}">
                                <input id="completed" name="completed" type="checkbox" value="1" onchange="this.form.submit()" @if ($task->completed)checked @endif>
                            </div>
                        </div>
                        @method("PATCH")
                        @csrf
                    </form>
                @endforeach

                <div class="card mb-3">
                    <form action="{{ route('projects.tasks.store', $project) }}" method="POST">
                        <input id="body" name="body" type="text" class="w-full" placeholder="Add a new task...">
                        @csrf
                    </form>
                </div>
            </div>
            <div>
                <h2 class="text-lg text-gray-500 font-normal mb-3">General Notes</h2>

                {{-- general notes --}}
                <form action="{{ $project->path() }}" method="post">
                    <textarea id="notes" name="notes" class="card w-full mb-4" style="min-height: 200px;" placeholder="Anything special you want to make a note of?">{{ $project->notes }}</textarea>
                    @method("PATCH")
                    @csrf
                    <button type="submit" class="button">Save</button>
                </form>
            </div>
        </div>
        <div class="lg:w-1/4 px-3 mt-10">
            @include('projects.partials.card', ["project" =>  $project])
            @include('projects.activities.partials.card', ["project" => $project])
        </div>
    </main>
@endsection
