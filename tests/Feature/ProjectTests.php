<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTests extends TestCase
{
    use WithFaker, RefreshDatabase;
    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    /**
     * @test
     */
    public function a_user_can_create_a_post() 
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->get('/projects')->assertSee($attributes['title']);

        $this->assertDatabaseHas('projects',$attributes);

    }

    /**
     * @test
     */
    public function a_project_requires_a_title()
    {
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
        $attributes = factory('App\Project')->raw([
            'description' => ''
        ]);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
