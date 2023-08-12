<?php

namespace App\Data\Workspace;

class WorkspaceCreateData
{
    public function __construct(public string $title, public int $ownerId)
    {
    }
}
