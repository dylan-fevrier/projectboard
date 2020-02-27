<?php

namespace Tests\Feature;

use App\Project;
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
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/projects', $attributes);
        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /**
     * @test
     */
    public function a_user_can_update_their_projects()
    {
        $this->withoutExceptionHandling();
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
}
