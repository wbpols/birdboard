<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use App\Models\Project\Task;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Project\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Project\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        // Validate the attributes.
        $attributes = $request->validate([
            "body" => [
                "required",
                "string",
                "min:5",
            ],
        ]);

        // Add the Task to the Project.
        $project->addTask($attributes["body"]);

        // Return to the Project show page.
        return redirect($project->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project\Project  $project
     * @param  \App\Models\Project\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project\Project  $project
     * @param  \App\Models\Project\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project\Project  $project
     * @param  \App\Models\Project\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, Task $task)
    {
        $this->authorize('update', $project);

        // Validate that the Project is associated to the Task.
        abort_if($project->isNot($task->project), 403);

        // Validate the request and update the Task.
        $task->update(
            $request->validate([
                "body" => [
                    "required",
                    "string",
                    "min:5",
                ],
            ])
        );

        // Determine the method to execute regarding the completion of the Task.
        $method = $request->completed ? 'complete' : 'uncomplete';

        // Execute the action.
        $task->$method();

        // Redirect to another route.
        return redirect($project->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project\Project  $project
     * @param  \App\Models\Project\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Task $task)
    {
        //
    }
}
