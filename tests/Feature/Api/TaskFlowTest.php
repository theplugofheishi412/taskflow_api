<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskFlowTest extends TestCase
{
    use RefreshDatabase;

    // AUTH
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['token', 'user']);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'user']);
    }

    public function test_login_fails_with_wrong_password()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422);
    }

    // TASKS
    public function test_authenticated_user_can_create_task()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/tasks', [
            'title'       => 'Ma tâche',
            'description' => 'Description',
            'status'      => 'todo',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Ma tâche']);
    }

    public function test_authenticated_user_can_list_tasks()
    {
        $user = User::factory()->create();
        Task::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_unauthenticated_user_cannot_access_tasks()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(401);
    }

    public function test_user_can_update_task_status()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id, 'status' => 'todo']);

        $response = $this->actingAs($user)->putJson("/api/tasks/{$task->id}", [
            'status' => 'done',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'done']);
    }

    public function test_user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
