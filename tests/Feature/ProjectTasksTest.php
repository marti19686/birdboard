<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
   use RefreshDatabase;

    public function guest_cannot_add_tasks_to_projects()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path(). '/tasks')->assertRedirect('login');
    }

    /** @test */
    function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    function only_the_owner_of_a_project_may_update_a_tasks()
    {
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();


        $this->patch($project->tasks->first()->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /** @test */
    public function a_project_can_have_task()
   {
       $project = ProjectFactory::create();

       $this->actingAs($project->owner)
           ->post($project->path(). '/tasks', ['body' => 'Test task']);

       $this->get($project->path())
           ->assertSee('Test task');
   }

   /** @test */
   function a_task_can_be_updated()
   {
       $project = ProjectFactory::withTasks(1)->create();

       $this->actingAs($project->owner)
           ->patch($project->tasks->first()->path(), [
           'body' => 'changed',
           'completed' => true
       ]);

       $this->assertDatabaseHas('tasks', [
           'body' => 'changed',
           'completed' => true
       ]);
   }

   /** @test */
   public function a_task_requires_a_body()
   {
       $project = ProjectFactory::create();

       $attributes = factory('App\Task')->raw(['body' => '']);

       $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
   }
}
