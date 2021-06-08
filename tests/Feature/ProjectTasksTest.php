<?php

namespace Tests\Feature;

use App\Models\Project\Project;
use App\Models\Project\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\FactoryProject;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $project = FactoryProject::create();

        $this->actingAs($project->owner)
            ->post("{$project->path()}/tasks", ($task = Task::factory()->raw()));

        $this->get($project->path())
            ->assertSee($task["body"]);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $project = FactoryProject::create();

        $this->actingAs($this->signIn())
            ->post("{$project->path()}/tasks", ($task = Task::factory()->raw()))
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $task);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $project = FactoryProject::create();

        $this->actingAs($project->owner)
            ->post("{$project->path()}/tasks", ($task = Task::factory()->raw(["body" => null])))
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = FactoryProject::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), ["body" => "changed"]);

        $this->assertDatabaseHas($project->tasks->first()->getTable(), ["body" => "changed"]);
    }

    /** @test */
    public function only_the_owner_of_the_project_may_update_a_task()
    {
        $this->signIn();

        $project = FactoryProject::withTasks(1)->create();

        $this->patch($project->tasks->first()->path(), ["body" => "changed"])
            ->assertStatus(403);

        $this->assertDatabaseMissing($project->tasks->first()->getTable(), ["body" => "changed"]);
    }
}
