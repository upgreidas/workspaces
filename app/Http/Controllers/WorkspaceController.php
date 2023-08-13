<?php

namespace App\Http\Controllers;

use App\Actions\Workspace\WorkspaceCreateAction;
use App\Actions\Workspace\WorkspaceDeleteAction;
use App\Actions\Workspace\WorkspaceUpdateAction;
use App\Data\Workspace\WorkspaceCreateData;
use App\Data\Workspace\WorkspaceUpdateData;
use App\Http\Requests\Workspace\WorkspaceDeleteRequest;
use App\Http\Requests\Workspace\WorkspaceStoreRequest;
use App\Http\Requests\Workspace\WorkspaceUpdateRequest;
use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkspaceStoreRequest $request, WorkspaceCreateAction $action)
    {
        $data = new WorkspaceCreateData(
            title: $request->input('title'),
            ownerId: $request->user()->id,
        );

        $workspace = $action->handle($data);

        return compact('workspace');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkspaceUpdateRequest $request, Workspace $workspace, WorkspaceUpdateAction $action)
    {
        $data = new WorkspaceUpdateData(
            title: $request->input('title'),
        );

        $workspace = $action->handle($workspace, $data);

        return compact('workspace');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkspaceDeleteRequest $request, Workspace $workspace, WorkspaceDeleteAction $action)
    {
        $action->handle($workspace);

        return response()->json([
            'success' => true,
        ]);
    }
}
