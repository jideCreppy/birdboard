<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_has_projects()
    {
        $user = factory('App\User')->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /**
     * @test
     */
    public function a_user_has_accessible_projects()
    {
        $jimmy = factory('App\User')->create();
        $this->signIn($jimmy);
        factory('App\Project')->create(['owner_id' => auth()->id()]);

        $sally = factory('App\User')->create();
        factory('App\Project')->create(['owner_id' => $sally->id])->invite($jimmy);
        $this->assertCount(2 ,$jimmy->accessibleProjects());
    }
}
