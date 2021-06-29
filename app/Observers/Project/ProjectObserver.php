<?php

namespace App\Observers\Project;

use App\Models\Project\Project;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Models\Project\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $this->record($project, 'created');
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Models\Project\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $this->record($project, 'updated');
    }

    /**
     * Handle the project "deleted" event.
     *
     * @param  \App\Models\Project\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        //
    }

    /**
     * Handle the project "restored" event.
     *
     * @param  \App\Models\Project\Project  $project
     * @return void
     */
    public function restored(Project $project)
    {
        //
    }

    /**
     * Handle the project "force deleted" event.
     *
     * @param  \App\Models\Project\Project  $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }


    /*
    |--------------------------------------------------------------------------
    | Custom Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Create a Activity for the Project.
     *
     * @param  \App\Models\Project\Project  $project  The Project to record an Activity on.
     * @param  string  $description  A description for the Activity.
     * @return \App\Models\Activity\Activity
     */
    private function record(Project $project, string $description)
    {
        return $project->activities()->create(["description" => $description]);
    }
}
