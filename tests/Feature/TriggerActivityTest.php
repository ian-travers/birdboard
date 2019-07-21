<?php

namespace Tests\Feature;

use App\Task;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */ 
    function creating_a_project()
    {
        $project = app(ProjectFactory::class)->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    /** @test */
    function updating_a_project()
    {
        $project = app(ProjectFactory::class)->create();
        $originalTitle = $project->title;

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('updated', $activity->description);
            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Changed'],
            ];
            $this->assertEquals($expected, $activity->changes);
        });

    }
    
    /** @test */ 
    function creating_a_task()
    {
        $project = app(ProjectFactory::class)->create();

        $project->addTask('New task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('New task', $activity->subject->body);
        });
    }

    /** @test */
    function completing_a_task()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path() ,[
            'body' => 'boofar',
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);


        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /** @test */
    function incompleting_a_task()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path() ,[
            'body' => 'boofar',
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);

        $this->actingAs($project->owner)->patch($project->tasks[0]->path() ,[
            'body' => 'boofar',
            'completed' => false,
        ]);

        $project = $project->refresh();
        $this->assertCount(4, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('uncompleted_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }
    
    /** @test */ 
    function deleting_a_task()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    }
}
