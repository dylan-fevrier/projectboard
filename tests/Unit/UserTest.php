<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_has_project()
    {
        $user = factory('App\User')->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /**
     * @test
     */
    public function a_user_has_projects()
    {
        $john = $this->signIn();
        ProjectFactory::ownedBy($john)->create();

        $this->assertCount(1, $john->allProjects());

        $doe = factory(User::class)->create();
        $nick = factory(User::class)->create();

        ProjectFactory::ownedBy($doe)->create()->invite($nick);

        $this->assertCount(1, $john->allProjects());

        ProjectFactory::ownedBy($doe)->create()->invite($john);

        $this->assertCount(2, $john->allProjects());
    }
}
