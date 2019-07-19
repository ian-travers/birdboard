<?php

namespace Tests\Unit;

use App\Project;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */ 
    function it_belongs_to_a_project()
    {
        /** @var Task $task */
        $task = factory(Task::class)->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }
   
    /** @test */ 
    function it_has_a_path()
    {
        /** @var Task $task */
        $task = factory(Task::class)->create();

        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    /** @test */
    function it_can_be_completed()
    {
        /** @var Task $task */
        $task = factory(Task::class)->create();

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }
}
