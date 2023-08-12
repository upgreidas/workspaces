<?php

namespace App\Actions\Workspace;

use App\Data\Workspace\WorkspaceCreateData;
use App\Events\Workspace\WorkspaceCreated;
use App\Models\Workspace;

class WorkspaceCreateAction
{
    public function handle(WorkspaceCreateData $data)
    {
        $workspace = Workspace::create([
            'owner_id' => $data->ownerId,
            'title' => $data->title,
        ]);

        WorkspaceCreated::dispatch($workspace);

        return $workspace;
    }
}
