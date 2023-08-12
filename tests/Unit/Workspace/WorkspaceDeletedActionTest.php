<?php

namespace Tests\Unit\Workspace;

use App\Actions\Workspace\WorkspaceDeleteAction;
use App\Events\Workspace\WorkspaceDeleted;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class WorkspaceDeletedActionTest extends TestCase
{
    public function test_workspace_deleted(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user->id]);

        resolve(WorkspaceDeleteAction::class)->handle($workspace);

        Event::assertDispatched(WorkspaceDeleted::class);
    }
}
