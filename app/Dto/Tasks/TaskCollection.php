<?php

namespace App\Dto\Tasks;

use App\Dto\DataTransferObjectCollection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TaskCollection extends DataTransferObjectCollection
{
    /**
     * @return TaskDto
     * @throws UnknownProperties
     */
    public function current(): TaskDto
    {
        return new TaskDto(parent::current());
    }
}