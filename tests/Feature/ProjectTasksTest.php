<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(factory('App\Project')->raw());

        $this->post($project->path() . '/tasks', ['body' => 'Nick Canon']);

        $this->get($project->path())->assertSee('Nick Canon');
    }

    /**
     * @test
     */
    public function a_task_requires_a_body()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(factory('App\Project')->raw());
        $task = factory('App\Task')->raw(['body' => null]);
        $this->post($project->path() . '/tasks', $task)->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function only_a_project_owner_can_create_a_task()
    {
        $this->signIn();

        $project = factory('App\Project')->create();;

        $this->post($project->path() . "/tasks", ['body' => 'Test Body'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test Body']);
    }

    /**
     * @test
     */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(factory('App\Project')->raw());
        $task = $project->addTask(['body' => 'Lorem Ipsum']);

        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /**
     * @test
     */
    public function a_task_can_be_complete()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(factory('App\Project')->raw());
        $task = $project->addTask(['body' => 'Lorem Ipsum']);

        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertTrue($task->fresh()->completed);
    }

    /**
     * @test
     */
    public function a_task_can_be_incomplete()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(factory('App\Project')->raw());
        $task = $project->addTask(['body' => 'Lorem Ipsum']);

        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertFalse($task->fresh()->completed);
    }

    /**
     * @test
     */
    public function only_a_project_owner_can_update_a_task()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $task = $project->addTask(['body' => 'Lorem Ipsum']);

        $this->patch($task->path(), ['body' => 'changed', 'completed' => true])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }
}
