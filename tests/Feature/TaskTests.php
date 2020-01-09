<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTests extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_has_a_path()
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();
        $task = $project->addTask(['body' => 'Lorem Ipsum']);

        $this->assertEquals($task->path(), $task->path());
    }

    /**
     * @test
     */
    public function it_belongs_to_a_project()
    {
        $task = factory('App\Task')->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /**
     * @test
     */
    public function it_can_be_completed(){

        $this->withoutExceptionHandling();

        $task = factory('App\Task')->create();

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);

    }

    /**
     * @test
     */
    public function it_can_be_incomplete(){

        $this->withoutExceptionHandling();

        $task = factory('App\Task')->create();

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);
    }
}
