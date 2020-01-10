<?php

namespace Tests\Feature;

use App\Project;
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
    public function a_user_can_create_a_project() 
    {
        $this->signIn();
        $attributes = [
            'title' => 'Some title',
            'description' => 'some description',
            'notes' => 'some note'
        ];
        $this->get('projects/create')->assertOk();

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects',$attributes);
    }

    /**
     * @test
     */
    public function a_user_can_update_a_project()
    {

        $this->withoutExceptionHandling();
        $this->signIn();
        $attributes = [
            'title' => 'Some title',
            'description' => 'some description',
            'notes' => 'some note'
        ];

        $response = $this->post('/projects', $attributes);
        $project = Project::where($attributes)->first();

        $this->get($project->path().'/edit')->assertOk();

        $this->patch($project->path(), [
            'title' => 'changed',
            'description' => 'Some description',
            'notes' => 'new note'
            ])
        ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'new note']);

    }

    /**
     * @test
     */

     public function authenticated_users_can_delete_a_project()
     {
         $this->withoutExceptionHandling();

         $this->signIn();

         $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
         
         $this->delete($project->path())->assertRedirect('/projects');

         $this->assertDatabaseMissing('projects', $project->only('id'));
     }

    /**
     * @test
     */
    public function a_user_can_only_update_a_projects_notes()
    {

        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create([ 'owner_id' => auth()->id()]);

        $this->patch($project->path(), [
            'notes' => 'Changed'
        ])
        ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'Changed']);

    }

     /**
     * @test
     */
    public function a_user_cannot_update_the_project_of_others()
    {
        $this->signIn();
        $project = factory('App\Project')->create();

        $this->patch($project->path(), ['notes' => 'new note'])
        ->assertStatus(403);

        $this->assertDatabaseMissing('projects', ['notes' => 'new note']);
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

    /**
     * @test
     */
    public function authenticated_users_can_view_their_project()
    {
        $this->signIn();

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

    /**
     * @test
     */
    public function a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $this->withoutExceptionHandling();
        
        $user = factory('App\User')->create();

        $this->signIn($user);

        $project = factory('App\Project')->create();

        $project->invite($user);

        $this->get('/projects')->assertSee($project->title);

    }
}
