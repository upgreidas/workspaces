<?php

namespace Tests\Unit\Project;

use App\Actions\Project\ProjectUpdateAction;
use App\Data\Project\ProjectUpdateData;
use App\Events\Project\ProjectUpdated;
use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ProjectUpdateActionTest extends TestCase
{
    public function test_project_updated_successfully(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['owner_id' => $user->id]);
        $project = Project::factory()->create(['author_id' => $user->id, 'workspace_id' => $workspace->id]);
        $data = Project::factory()->raw();

        resolve(ProjectUpdateAction::class)->handle($project, new ProjectUpdateData(
            title: $data['title'],
            color: $data['color'],
        ));

        Event::assertDispatched(ProjectUpdated::class);
    }
}
