<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */ 
    function it_has_a_path()
    {
        /** @var Project $project */
        $project = factory(Project::class)->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    function it_belongs_to_an_owner()
    {
        /** @var Project $project */
        $project = factory(Project::class)->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    function it_can_add_a_task()
    {
        /** @var Project $project */
        $project = factory(Project::class)->create();

        $task = $project->addTask('Test Task');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));

    }

}
