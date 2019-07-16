<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

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
    function a_task_requires_a_body()
    {
        $this->signIn();


        /** @var Project $project */
        $project = factory(Project::class)->create(['owner_id' => auth()->user()->id]);

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
