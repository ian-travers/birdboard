<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {

        /** @var User $user */
        $user = $user ?: factory('App\User')->create();
        $this->actingAs($user);

        return $user;
    }
}
