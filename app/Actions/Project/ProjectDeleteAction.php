<?php

namespace App\Actions\Project;

use App\Events\Project\ProjectDeleted;
use App\Models\Project;

class ProjectDeleteAction
{
    public function handle(Project $project)
    {
        $project->delete();

        ProjectDeleted::dispatch($project);
    }
}
