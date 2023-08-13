<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkspaceControllerTest extends TestCase
{
    public function test_workspace_created_successfully(): void
    {
        $user = User::factory()->create();
        $data = Workspace::factory()->raw();

        $this->actingAs($user);
        $response = $this->postJson('/api/workspaces', $data);
        $response->assertStatus(200);
        $response->assertJsonStructure(['workspace']);
    }

    public function test_workspace_validation_failed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->postJson('/api/workspaces');
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);
    }

    public function test_guest_cannot_create_workspace(): void
    {
        $data = Workspace::factory()->raw();

        $response = $this->postJson('/api/workspaces', $data);
        $response->assertStatus(401);
    }

    public function test_workspace_updated_successfully(): void
    {
        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user->id]);
        $data = Workspace::factory()->raw();

        $this->actingAs($user);
        $response = $this->putJson('/api/workspaces/' . $workspace->id, $data);
        $response->assertStatus(200);
        $response->assertJsonStructure(['workspace']);
    }

    public function test_cannot_update_not_owned_workspace(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user1->id]);
        $data = Workspace::factory()->raw();

        $this->actingAs($user2);
        $response = $this->putJson('/api/workspaces/' . $workspace->id, $data);
        $response->assertStatus(403);
    }

    public function test_workspace_deleted_successfully(): void
    {
        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->deleteJson('/api/workspaces/' . $workspace->id);
        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
        ]);
        $this->assertModelMissing($workspace);
    }

    public function test_cannot_delete_not_owned_workspace(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user1->id]);

        $this->actingAs($user2);
        $response = $this->deleteJson('/api/workspaces/' . $workspace->id);
        $response->assertStatus(403);
    }
}
