<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function quests_cannot_add_tasks_to_project()
    {
        /** @var Project $project */
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks')->assertRedirect('/login');
    }

    /** @test */
    function only_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        /** @var Project $project */
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    function only_owner_of_a_project_may_update_a_task()
    {
        $this->signIn();

        /** @var Project $project */
        $project = factory(Project::class)->create();
        $task = $project->addTask('test task');

        $this->patch($project->path() . '/tasks/' . $task->id, ['body' => 'changed'])
            ->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /** @test */
    function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        /** @var Project $project */
        $project = factory(Project::class)->create(['owner_id' => auth()->user()->id]);

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    /** @test */
    function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        /** @var Project $project */
        $project = factory(Project::class)->create(['owner_id' => auth()->user()->id]);

        /** @var Task $task */
        $task = $project->addTask('test task');

        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true,
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true,
        ]);
    }

    /** @test */
    function a_task_requires_a_body()
    {
        $this->signIn();


        /** @var Project $project */
        $project = factory(Project::class)->create(['owner_id' => auth()->user()->id]);

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
