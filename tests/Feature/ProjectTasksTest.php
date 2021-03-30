<?php

namespace Tests\Feature;

use App\Models\Project\Project;
use App\Models\Project\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $this->post("{$project->path()}/tasks", ($task = Task::factory()->raw()));

        $this->get($project->path())
            ->assertSee($task["body"]);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post("{$project->path()}/tasks", ($task = Task::factory()->raw()))
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $task);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $this->post("{$project->path()}/tasks", ($task = Task::factory()->raw(["body" => null])))
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $task = $project->addTask(Task::factory()->raw()["body"]);

        $this->patch($task->path(), ["body" => "changed"]);

        $this->assertDatabaseHas($task->getTable(), ["body" => "changed"]);
    }

    /** @test */
    public function only_the_owner_of_the_project_may_update_a_task()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $task = $project->addTask(Task::factory()->raw()["body"]);

        $this->patch($task->path(), ["body" => "changed"])
            ->assertStatus(403);

        $this->assertDatabaseMissing($task->getTable(), ["body" => "changed"]);
    }
}
