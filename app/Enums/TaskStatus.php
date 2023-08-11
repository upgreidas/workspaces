<?php

namespace App\Enums;

enum TaskStatus
{
    case Backlog;
    case Pending;
    case InProgress;
    case OnHold;
    case Completed;
}
