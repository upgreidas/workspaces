<?php

namespace App\Data\Project;

class ProjectCreateData
{
    public function __construct(public string $title, public string $color, public int $authorId, public int $workspaceId)
    {
    }
}
