<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InviteProjectTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function a_project_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $user = factory(User::class)->create();

        $this->post($project->path() . '/invitations', ['email' => $user->email]);

        $this->assertTrue($project->members->contains($user));
    }

    /**
     * @test
     */
    public function the_invited_email_address_must_be_as_a_valid_account()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->post($project->path() . '/invitations', ['email' => 'invalid@email.fr'])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have an account.'
            ]);
    }

    /**
     * @test
     */
    public function non_owners_may_not_invite_users()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $project->invite($user = factory(User::class)->create());

        $this->actingAs($user);

        $this->post($project->path() . '/invitations', ['email' => factory(User::class)->create()->email])
            ->assertForbidden();
    }

    /**
     * @test
     */
    public function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();
        $project->invite($user = factory(User::class)->create());

        $this->actingAs($user);

        $this->post($project->path() . '/tasks', ['body' => 'New Tasks'])
            ->assertRedirect($project->path());
    }
}
