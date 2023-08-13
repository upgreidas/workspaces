<?php

namespace Tests\Unit\Project;

use App\Actions\Project\ProjectCreateAction;
use App\Data\Project\ProjectCreateData;
use App\Events\Project\ProjectCreated;
use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ProjectCreateActionTest extends TestCase
{
    public function test_project_created_successfully(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user->id]);
        $data = Project::factory()->raw(['author_id' => $user->id, 'workspace_id' => $workspace->id]);
        $project = resolve(ProjectCreateAction::class)->handle(new ProjectCreateData(
            title: $data['title'],
            color: $data['color'],
            authorId: $user->id,
            workspaceId: $workspace->id,
        ));

        $this->assertInstanceOf(Project::class, $project);
        $this->assertModelExists($project);
        Event::assertDispatched(ProjectCreated::class);
    }
}
