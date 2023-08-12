<?php

namespace App\Actions\Workspace;

use App\Events\Workspace\WorkspaceDeleted;
use App\Models\Workspace;

class WorkspaceDeleteAction
{
    public function handle(Workspace $workspace)
    {
        $workspace->delete();

        WorkspaceDeleted::dispatch($workspace);
    }
}
