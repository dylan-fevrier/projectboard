<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function it_has_user()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $this->assertInstanceOf(User::class, $project->activities->first()->user);
    }
}
