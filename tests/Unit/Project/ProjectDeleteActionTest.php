<?php

namespace Tests\Unit\Project;

use App\Actions\Project\ProjectDeleteAction;
use App\Events\Project\ProjectDeleted;
use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ProjectDeleteActionTest extends TestCase
{
    public function test_project_deleted_successfully(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user->id]);
        $project = Project::factory()->create(['author_id' => $user->id, 'workspace_id' => $workspace->id]);

        resolve(ProjectDeleteAction::class)->handle($project);

        $this->assertModelMissing($project);
        Event::assertDispatched(ProjectDeleted::class);
    }
}
