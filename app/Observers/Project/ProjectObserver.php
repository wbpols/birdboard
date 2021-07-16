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
        $project->record('created');
    }

    /**
     * Handle the project "updating" event.
     *
     * @param  \App\Models\Project\Project  $project
     * @return void
     */
    public function updating(Project $project)
    {
        $project->old = $project->getOriginal();
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Models\Project\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $project->record('updated');
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
}
