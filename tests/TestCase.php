<?php

namespace Tests;

use App\Models\User\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Sign in as a application User.
     *
     * @param  \App\Models\User\User|null $user
     * @return \App\Models\User\User
     */
    protected function signIn($user = null)
    {
        // Set the specified User or create a new one.
        $user = $user ?: User::factory()->create();

        // Preform the test using this User.
        $this->actingAs($user);

        // Return the User.
        return $user;
    }
}
