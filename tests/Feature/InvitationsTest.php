<?php

namespace Tests\Feature;

use App\User;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */ 
    function a_project_can_invite_a_user()
    {
        // Given: I have a project.
        $project = app(ProjectFactory::class)->create();

        // The owner of the project invites another user
        $project->invite($newUser = factory(User::class)->create());

        // Then, that new user will have permission to add tasks
        $this->signIn($newUser);
        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
