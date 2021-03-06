@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-gray-500 text-sm font-normal">My Projects</h2>
            <a href="{{ route('projects.create') }}" class="button">Create New Project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 py-6">
                @include('projects.partials.card', ["project" =>  $project])
            </div>
        @empty
            <div>No Projects yet!</div>
        @endforelse
    </main>
@endsection
