<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    function guest_cannot_manage_projects()
    {
        $project = app(ProjectFactory::class)->create();

        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path() . '/edit')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    /** @test */
    function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(Response::HTTP_OK);

        $attributes = [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/projects', $attributes);
        $response->assertStatus(Response::HTTP_FOUND);

        /** @var Project $project */
        $project = Project::where($attributes)->first();
        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee(Str::limit($attributes['description'], 60, ''))
            ->assertSee($attributes['notes']);
    }
    
    /** @test */ 
    function tasks_can_be_included_as_part_of_a_new_project()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw();
        $attributes['tasks'] = [
            ['body' => 'Task 1'],
            ['body' => 'Task 2'],
        ];

        $this->post('projects', $attributes);

        $this->assertCount(2, Project::first()->tasks);
    }

    /** @test */
    function a_user_cam_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        // given we're signed in
        // and we're been invited to a project that was not created by us
        $project = tap(app(ProjectFactory::class)->create())->invite($this->signIn());

        // when I visit my dashboard I should see that project
        $this->get(route('projects.index'))
            ->assertSee($project->title);
    }

    /** @test */
    function unauthorized_users_cannot_delete_projects()
    {
        $project = app(ProjectFactory::class)->create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $user = $this->signIn();

        $this->delete($project->path())
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $project->invite($user);

        $this->actingAs($user)
            ->delete($project->path())
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function user_can_delete_a_project()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    function user_can_update_a_project()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['title' => 'Changed', 'description' => 'Changed', 'notes' => 'Changed'])
            ->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    function user_can_update_a_project_general_notes()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['notes' => 'Changed'])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    function a_user_can_view_their_project()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description_for_card);
    }

    /** @test */
    function an_authenticated_user_cannot_view_other_projects()
    {
        $this->signIn();

        /** @var Project $project */
        $project = factory(Project::class)->create();

        $this->get($project->path())->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function an_authenticated_user_cannot_update_other_projects()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)->create();

        $this->patch($project->path(), [])->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
