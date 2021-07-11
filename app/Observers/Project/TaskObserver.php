<?php

namespace App\Observers\Project;

use App\Models\Project\Task;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Models\Project\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->record('created_task');
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Models\Project\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        // Only create an Activity when the Task completed column is updated.
        if ($task->wasChanged('completed')) {
            $task->record($task->completed ? 'completed_task' : 'uncompleted_task');
        }
    }

    /**
     * Handle the task "deleted" event.
     *
     * @param  \App\Models\Project\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $task->project->record('deleted_task');
    }

    /**
     * Handle the task "restored" event.
     *
     * @param  \App\Models\Project\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the task "force deleted" event.
     *
     * @param  \App\Models\Project\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
