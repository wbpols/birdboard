<?php

namespace Tests\Unit\Project;

use App\Models\Project\Project;
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
}
