<?php

namespace Tests\Unit;

use App\User;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */ 
    function it_has_a_user()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)->create();

        $this->assertInstanceOf(User::class, $project->activity->first()->user);
    }
}
