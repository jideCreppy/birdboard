<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTests extends TestCase
{
    use WithFaker, RefreshDatabase;

     /**
     * @test
     */
    public function guests_cannot_create_a_project()
    {
        $attributes = factory('App\Project')->raw();
        
        $this->get('projects/create')->assertRedirect('login');

        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /**
     * @test
     */
    public function guests_may_not_view_projects()
    {
        // $this->withoutExceptionHandling();
        $this->get('/projects')->assertRedirect('login');
    }

    /**
     * @test
     */
    public function guests_cannot_view_a_single_project()
    {
        $project = factory('App\Project')->create();
        $this->get($project->path())->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_user_can_create_a_post() 
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $attributes = factory('App\Project')->raw();
        $this->get('projects/create')->assertOk();
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        $this->get('/projects')->assertSee($attributes['title']);
        $this->assertDatabaseHas('projects',['title' => $attributes['title']]);
    }

    /**
     * @test
     */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw([
            'title' => ''
        ]);
        $this->post('/projects',$attributes)->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw([
            'description' => ''
        ]);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }


    // view their project
    /**
     * @test
     */
    public function authenticated_users_can_view_their_project()
    {
        $this->signIn();
        $this->withOutExceptionHandling();
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $this->get($project->path())->assertSee($project->title)->assertSee($project->description);
    }

    /**
     * @test
     */
    public function authenticated_users_cannot_view_the_project_of_others()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $this->get($project->path())->assertStatus(403);
    }
}
