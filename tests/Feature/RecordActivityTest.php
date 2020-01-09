<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordActivityTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function creating_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory('App\Project')->create([ 'owner_id' => auth()->id()]);
        $this->assertCount(1, $project->activity);
    }


    /**
     * @test
     */
    public function updating_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory('App\Project')->create([ 'owner_id' => auth()->id()]);

        $originalTitle = $project->title;

        $project->update(['title' => 'changed']);
        $this->assertCount(2, $project->activity);
        $this->assertDatabaseHas('projects', ['title' => 'changed']);

        tap($project->activity->last(), function($activity) use ($originalTitle) {
            $this->assertEquals('updated_project', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after'  => ['title' => 'changed']  
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test */
    public function creating_a_new_task()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory('App\Project')->create([ 'owner_id' => auth()->id()]);
        $project->addTask(['body' => 'created task']);

        tap($project->activity->last(), function($activity){
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('created task', $activity->subject->body);
        });

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);

    }

    /** @test */
    public function completing_a_new_task_()
    {
        $this->signIn();
        $project = factory('App\Project')->create([ 'owner_id' => auth()->id()]);
        $task = $project->addTask(['body' => 'New Task']);
        $this->patch($task->path(), ['body' => 'Updated task', 'completed' => true]);
        $project->refresh();
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }


    /** @test */
    public function incompleting_a_new_task()
    {
        $this->signIn();
        $project = factory('App\Project')->create([ 'owner_id' => auth()->id()]);
        $task = $project->addTask(['body' => 'New Task']);

        $this->patch($task->path(), ['body' => 'Updated task', 'completed' => true]);
        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);


        $this->patch($task->path(), ['body' => 'Updated task to incomplete', 'completed' => false]);

        $project->refresh();
        $this->assertCount(4, $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }
}
