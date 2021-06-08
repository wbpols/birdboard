<?php

namespace Tests\Setup;

use App\Models\Project\Project;
use App\Models\Project\Task;
use App\Models\User\User;

class FactoryProject
{
    /**
     * The User that owns the Project.
     *
     * @var  \App\Models\User\User|null
     */
    protected $user;

    /**
     * The amount of tasks to create.
     *
     * @var  int
     */
    protected $taskCount = 0;

    /**
     * Create a Project model.
     *
     * Also include Task models if the taskCount is specified.
     *
     * @return \App\Models\Project\Project
     */
    public function create()
    {
        // Create the Project.
        $project = Project::factory()->create([
            "owner_id" => $this->user ?? User::factory()->create(),
        ]);

        // Create the tasks if provided.
        Task::factory($this->taskCount)->create([
            "project_id" => $project,
        ]);

        // Return the Project.
        return $project;
    }

    /**
     * Set the owner of the Project by the specified User.
     *
     * @param  \App\Models\User\User
     * @return $this
     */
    public function ownedBy(User $user)
    {
        // Set the owner of the project.
        $this->user = $user;

        // Return the modified class.
        return $this;
    }

    /**
     * Set the amount of Task models to create along with the Project Model.
     *
     * @param  int  $count  The amount of Task models to create.
     * @return $this
     */
    public function withTasks(int $count)
    {
        // Set the amount of tasks to create.
        $this->taskCount = $count;

        // Return the modified class.
        return $this;
    }
}
