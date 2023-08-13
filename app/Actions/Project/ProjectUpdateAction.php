<?php

namespace App\Actions\Project;

use App\Data\Project\ProjectUpdateData;
use App\Events\Project\ProjectUpdated;
use App\Models\Project;

class ProjectUpdateAction
{
    public function handle(Project $project, ProjectUpdateData $data)
    {
        $project->update([
            'title' => $data->title,
            'color' => $data->color,
        ]);

        ProjectUpdated::dispatch($project);

        return $project;
    }
}
