<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
    */
    public function a_project_owner_can_invite_a_user(){
        $this->withoutExceptionHandling();
        $user = factory('App\User')->create();
        $this->signIn($user);
        $user_to_invite = factory('App\User')->create();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $this->post($project->path().'/invitations', [ 'email' => $user_to_invite->email ])
        ->assertRedirect($project->path());
        $this->assertTrue($project->members->contains($user_to_invite));
    }

    /**
     * @test
    */
    public function the_invited_email_address_must_be_associated_with_a_valid_birdboard_account()
    {
        $user = factory('App\User')->create();
        $this->signIn($user);
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $this->post($project->path().'/invitations', [ 'email' => 'foo@bar.com' ])
            ->assertSessionHasErrors(
                    ['email' => 'The user you are inviting must have a Birdboard account.'],
                    null, 'invitations');
    }

    /**
     * @test
    */
    public function invited_users_may_update_project_details()
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();
        $new_user= factory('App\User')->create();
        $this->signIn($new_user);
        $project->invite($new_user);
        $this->post(action('ProjectsTasksController@store', $project) , $task =['body' => 'Foo Task']);
        $this->assertDatabaseHas('tasks', $task);

    }

    /**
     * @test
     */
    public function non_owners_may_not_invite_users(){
        $user = factory('App\User')->create();
        $this->signIn($user);
        $project = factory('App\Project')->create();
        $this->post($project->path().'/invitations', [ 'email' => 'foo@bar.com' ])
            ->assertStatus(403);
    }
}
