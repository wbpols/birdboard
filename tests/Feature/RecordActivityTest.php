<?php

namespace Tests\Feature;

use App\Models\Project\Task;
use Database\Factories\Project\ProjectFactory;
use Facades\Tests\Setup\FactoryProject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecordActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = FactoryProject::create();

        $this->assertCount(1, $project->activities);

        tap($project->activities->last(), function ($activity) {
            $this->assertEquals('created_project', $activity->description);

            $this->assertNull($activity->changes);
        });
    }

    /** @test */
    public function updating_a_project()
    {
        $project = FactoryProject::create();
        $attributes = [
            "title" => $project->title,
        ];

        $project->update(["title" => "changed"]);

        $this->assertCount(2, $project->activities);

        tap($project->activities->last(), function ($activity) use ($attributes) {
            $this->assertEquals('updated_project', $activity->description);

            $expected = [
                "before" => $attributes,
                "after" => ["title" => "changed"],
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test */
    public function creating_a_new_task()
    {
        $project = FactoryProject::create();

        $project->addTask('Some task');

        $this->assertCount(2, $project->activities);
        tap($project->activities->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Some task', $activity->subject->body);
        });
    }

    /** @test */
    public function completing_a_task()
    {
        $project = FactoryProject::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                "body" => "changed",
                "completed" => true,
            ]);

        $this->assertCount(3, $project->activities);
        $this->assertEquals('completed_task', $project->tasks->first()->activities->last()->description);
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = FactoryProject::withTasks(1)->create();

        $project->tasks->last()->delete();

        $this->assertCount(3, $project->activities);
        $this->assertEquals('deleted_task', $project->activities->last()->description);
    }

    /** @test */
    public function uncompleting_a_task()
    {
        $project = FactoryProject::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                "body" => "changed",
                "completed" => true,
            ]);

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                "body" => "changed",
                "completed" => false,
            ]);

        $this->assertCount(4, $project->activities);
        $this->assertEquals('uncompleted_task', $project->activities->last()->description);
    }
}
