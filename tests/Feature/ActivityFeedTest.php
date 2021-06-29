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
    public function creating_a_project_generates_activity()
    {
        $project = FactoryProject::create();

        $this->assertCount(1, $project->activities);
        $this->assertEquals('created', $project->activities->last()->description);
    }

    /** @test */
    public function updating_a_project_generates_activity()
    {
        $project = FactoryProject::create();

        $project->update(["title" => "changed"]);

        $this->assertEquals('updated', $project->activities->last()->description);
    }
}
