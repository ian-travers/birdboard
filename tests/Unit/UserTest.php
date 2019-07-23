<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */ 
    function a_user_has_projects()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
    
    /** @test */ 
    function a_user_has_accessible_projects()
    {
        $john = $this->signIn();

        app(ProjectFactory::class)->ownedBy($john)->create();

        $this->assertCount(1, $john->accessibleProjects());

        $tom = factory(User::class)->create();
        $nick = factory(User::class)->create();

        $tomProject = app(ProjectFactory::class)->ownedBy($tom)->create();
        $tomProject->invite($nick);

        $this->assertCount(1, $john->accessibleProjects());
        $this->assertCount(1, $tom->accessibleProjects());
        $this->assertCount(1, $nick->accessibleProjects());

        $tomProject->invite($john);

        $this->assertCount(2, $john->accessibleProjects());
    }
}
