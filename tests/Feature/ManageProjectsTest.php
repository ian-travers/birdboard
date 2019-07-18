<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
//use Tests\Setup\ProjectFactory;
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
    function user_can_update_a_project()
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
