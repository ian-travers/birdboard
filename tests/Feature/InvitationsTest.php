<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Http\Response;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */ 
    function non_owner_may_not_invite_users()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs(factory(User::class)->create())
            ->post($project->path() . '/invitations', [])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function a_project_owner_can_invite_a_user()
    {
        $project = app(ProjectFactory::class)->create();

        /** @var User $tom */
        $tom = factory(User::class)->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', ['email' => $tom->email])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($tom));
    }

    /** @test */
    function the_email_must_be_associated_with_a_valid_birdboard_account()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', ['email' => 'not_a_user@fake.ml'])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have a Birdboard account.',
            ]);

    }

    /** @test */
    function invited_users_may_update_project_details()
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
