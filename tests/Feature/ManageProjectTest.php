<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class ManageProjectTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->patch($project->path())->assertRedirect('login');
        $this->get($project->path() . '/edit')->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $this->followingRedirects()
            ->post('/projects', $attributes = factory(Project::class)->raw())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /**
     * @test
     */
    public function a_user_can_update_their_projects()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->patch($project->path(), [
            'title' => 'Changed',
            'description' => 'New description',
            'notes' => 'New note for project'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'notes' => 'New note for project',
            'title' => 'Changed',
            'description' => 'New description'
        ]);
    }

    /**
     * @test
     */
    public function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->patch($project->path(), [
            'notes' => 'New notes'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'notes' => 'New notes'
        ]);
    }

    /**
     * @test
     */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description, 200));
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();
        $project = ProjectFactory::create();
        $this->get($project->path())
            ->assertForbidden();
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $this->patch($project->path(), ['notes' => "Test update an authenticated update"])
            ->assertForbidden();
        $this->assertDatabaseMissing('projects', ['notes' => 'Test update an authenticated update']);
    }

    /**
     * @test
     */
    public function a_owner_can_delete_a_project()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->toArray());
    }

    /**
     * @test
     */
    public function a_user_cannot_delete_a_project()
    {
        $project = ProjectFactory::create();

        $user = factory(User::class)->create();

        $project->invite($user);

        $this->actingAs($user);

        $this->delete($project->path())
            ->assertForbidden();
    }

    /**
     * @test
     */
    public function unauthorized_cannot_delete_projects()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_user_can_projects_have_been_invited_on_dashboard()
    {
        $user = $this->signIn();

        $project = ProjectFactory::create();

        $project->invite($user);

        $this->get('/projects')
            ->assertSee($project->title);
    }
}
