<?php

namespace Tests\Unit\Project;

use App\Models\Project\Project;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = Project::factory()->create();

        $this->assertEquals("projects/{$project->getKey()}", $project->path());
    }

    /** @test */
    public function it_belongs_to_an_onwer()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function it_can_add_a_task()
    {
        $project = Project::factory()->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }
}
