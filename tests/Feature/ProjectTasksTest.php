<?php

namespace Tests\Feature;

use App\Task;
use Illuminate\Http\Response;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function quests_cannot_add_tasks_to_project()
    {
        $project = app(ProjectFactory::class)->create();

        $this->post($project->path() . '/tasks')->assertRedirect('/login');
    }

    /** @test */
    function only_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    function only_owner_of_a_project_may_update_a_task()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), ['body' => 'changed'])
            ->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /** @test */
    function a_project_can_have_tasks()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    /** @test */
    function a_task_can_be_updated()
    {
        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
            'body' => 'changed',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
        ]);
    }

    /** @test */
    function a_task_can_be_completed()
    {
        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                'body' => 'changed',
                'completed' => true,
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true,
        ]);
    }

    /** @test */
    function a_task_can_be_marked_as_incomplete()
    {
        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                'body' => 'changed',
                'completed' => true,
            ]);

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                'body' => 'changed',
                'completed' => false,
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false,
        ]);
    }

    /** @test */
    function a_task_requires_a_body()
    {
        $project = app(ProjectFactory::class)->create();

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }
}
