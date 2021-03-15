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
     * @return $this
     */
    protected function signIn($user = null)
    {
        return $this->actingAs($user ?: User::factory()->create());
    }
}
