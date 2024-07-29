<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case OPEN = 'open';
    case PROCESSING = 'processing';
    case FINISHED = 'finished';
}
