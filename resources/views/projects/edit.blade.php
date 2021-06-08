@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p6 md:py-12 md:px-16 rounded shadow">
        <form method="POST" action="{{ $project->path() }}" class="container">
            <h1 class="text-2xl font-normal mb-10 text-center">Edit Your Project</h1>
            @include('projects._form', [
                "project" => $project,
                "buttonText" => "Update Project",
            ])
            @method("PATCH")
        </form>
    </div>
@endsection
