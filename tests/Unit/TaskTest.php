<?php

namespace Tests\Unit;

use App\Models\Project\Project;
use App\Models\Project\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_has_a_path()
    {
        $task = Task::factory()->create();

        $this->assertEquals("/projects/{$task->project->getRouteKey()}/tasks/{$task->getRouteKey()}", $task->path());
    }
}
