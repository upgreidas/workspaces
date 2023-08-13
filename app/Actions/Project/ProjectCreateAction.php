<?php

namespace App\Actions\Project;

use App\Data\Project\ProjectCreateData;
use App\Events\Project\ProjectCreated;
use App\Models\Project;

class ProjectCreateAction
{
    public function handle(ProjectCreateData $data)
    {
        $project = Project::create([
            'workspace_id' => $data->workspaceId,
            'author_id' => $data->authorId,
            'title' => $data->title,
            'color' => $data->color,
        ]);

        ProjectCreated::dispatch($project);

        return $project;
    }
}
