<?php

namespace Tests\Unit;

use App\Models\Project\Project;
use App\Models\User\User;
use Facades\Tests\Setup\FactoryProject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        // Sign in a user.
        $user = $this->signIn();

        // Create a project.
        $project = FactoryProject::ownedBy($user)->create();

        // Get the activity of the project.
        $this->assertEquals($user->id, $project->activities()->first()->user_id);
    }
}
