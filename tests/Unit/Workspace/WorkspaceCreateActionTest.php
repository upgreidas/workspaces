<?php

namespace Tests\Unit\Workspace;

use App\Actions\Workspace\WorkspaceCreateAction;
use App\Data\Workspace\WorkspaceCreateData;
use App\Events\Workspace\WorkspaceCreated;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class WorkspaceCreateActionTest extends TestCase
{
    public function test_workspace_created(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $data = Workspace::factory()->raw(['owner_id' => $user->id]);
        $workspace = resolve(WorkspaceCreateAction::class)->handle(new WorkspaceCreateData(
            ownerId: $user->id,
            title: $data['title'],
        ));

        $this->assertInstanceOf(Workspace::class, $workspace);
        $this->assertModelExists($workspace);
        Event::assertDispatched(WorkspaceCreated::class);
    }
}
