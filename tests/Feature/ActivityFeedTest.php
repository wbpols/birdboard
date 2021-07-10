<?php

namespace Tests\Feature;

use Database\Factories\Project\ProjectFactory;
use Facades\Tests\Setup\FactoryProject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project_records_activity()
    {
        $project = FactoryProject::create();

        $this->assertCount(1, $project->activities);
        $this->assertEquals('created', $project->activities->last()->description);
    }

    /** @test */
    public function updating_a_project_records_activity()
    {
        $project = FactoryProject::create();

        $project->update(["title" => "changed"]);

        $this->assertEquals('updated', $project->activities->last()->description);
    }

    /** @test */
    public function creating_a_new_task_records_project_activity()
    {
        $project = FactoryProject::create();

        $project->addTask('Some task');

        $this->assertCount(2, $project->activities);
        $this->assertEquals('created_task', $project->activities->last()->description);
    }

    /** @test */
    public function completing_a_task_records_project_activity()
    {
        $project = FactoryProject::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                "body" => "changed",
                "completed" => true,
            ]);

        $this->assertCount(3, $project->activities);
        $this->assertEquals('completed_task', $project->activities->last()->description);
    }
}
