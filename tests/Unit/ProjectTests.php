<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTests extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_has_a_owner()
    {
        $project = factory('App\Project')->create();
        $this->assertInstanceOf(User::class, $project->owner);
    }

    /**
     * @test
     */
    public function it_can_add_tasks()
    {
        $this->actingAs(factory('App\User')->create());
        $project = factory('App\Project')->create();
        $task =  $project->addTask(['body' => 'Lorem Ipsum']);

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));

    }
}
