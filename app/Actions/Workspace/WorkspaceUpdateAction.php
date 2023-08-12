<?php

namespace App\Actions\Workspace;

use App\Data\Workspace\WorkspaceUpdateData;
use App\Events\Workspace\WorkspaceUpdated;
use App\Models\Workspace;

class WorkspaceUpdateAction
{
    public function handle(Workspace $workspace, WorkspaceUpdateData $data)
    {
        $workspace->update([
            'title' => $data->title,
        ]);

        WorkspaceUpdated::dispatch($workspace);
    }
}
