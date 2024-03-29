<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact("projects"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = auth()->user()->projects()->create($this->validateRequest($request));

        return redirect()->route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return view('projects.show', compact("project"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact("project"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Project\UpdateProjectRequest  $form
     * @param  \App\Models\Project\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $form, Project $project)
    {
        return redirect($form->save()->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        // Determine if the user is authorized to delete the project.
        $this->authorize('update', $project);

        // Delete the project.
        $project->delete();

        // Redirect to the index page.
        return redirect()->route('projects.index');
    }

    /**
     * Validate the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function validateRequest(Request $request)
    {
        return $request->validate([
            "title" => [
                "required",
            ],
            "description" => [
                "required",
            ],
            "notes" => [
                "max:255",
            ],
        ]);
    }
}
