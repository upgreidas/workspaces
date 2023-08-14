<?php

namespace App\Http\Controllers;

use App\Actions\Project\ProjectCreateAction;
use App\Data\Project\ProjectCreateData;
use App\Http\Requests\Project\ProjectStoreRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request, ProjectCreateAction $action)
    {
        $data = new ProjectCreateData(
            title: $request->input('title'),
            color: $request->input('color'),
            workspaceId: $request->input('workspace_id'),
            authorId: $request->user()->id,
        );

        $project = $action->handle($data);

        return compact('project');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
