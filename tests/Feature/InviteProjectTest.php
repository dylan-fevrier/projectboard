<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InviteProjectTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function invite_a_members()
    {
        $project = ProjectFactory::create();
        $project->invite($user = factory(User::class)->create());

        $this->actingAs($user);

        $this->post($project->path() . '/tasks', ['body' => 'New Tasks'])
            ->assertRedirect($project->path());

    }
}
