<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    public function test_project_created_successfully(): void
    {
        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user->id]);
        $data = Project::factory()->raw(['workspace_id' => $workspace->id]);

        $this->actingAs($user);
        $response = $this->postJson('/api/projects', $data);
        $response->assertStatus(200);
        $response->assertJsonStructure(['project']);
    }

    public function test_project_color_validation_failed(): void
    {
        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user->id]);
        $data = Project::factory()->raw(['workspace_id' => $workspace->id, 'color' => 'any']);

        $this->actingAs($user);
        $response = $this->postJson('/api/projects', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['color']);
    }

    public function test_project_workspace_validation_failed(): void
    {
        $user = User::factory()->create();
        $data = Project::factory()->raw(['workspace_id' => 1]);

        $this->actingAs($user);
        $response = $this->postJson('/api/projects', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['workspace_id']);
    }

    public function test_guest_cannot_create_project(): void
    {
        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user->id]);
        $data = Project::factory()->raw(['workspace_id' => $workspace->id]);

        $response = $this->postJson('/api/projects', $data);
        $response->assertStatus(401);
    }
}
