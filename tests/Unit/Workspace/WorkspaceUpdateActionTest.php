<?php

namespace Tests\Unit\Workspace;

use App\Actions\Workspace\WorkspaceUpdateAction;
use App\Data\Workspace\WorkspaceUpdateData;
use App\Events\Workspace\WorkspaceUpdated;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class WorkspaceUpdateActionTest extends TestCase
{
    public function test_workspace_updated(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user->id]);
        $data = Workspace::factory()->raw();
        resolve(WorkspaceUpdateAction::class)->handle($workspace, new WorkspaceUpdateData(
            title: $data['title'],
        ));

        Event::assertDispatched(WorkspaceUpdated::class);
    }
}
