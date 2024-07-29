<?php

namespace App\Dto\Tasks;

use App\Dto\BaseDataObject;

class TaskDto extends BaseDataObject
{
    /**
     * @var int|null
     */
    public int|null $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var string
     */
    public string $priority;

    /**
     * @var string
     */
    public string $status;

    /**
     * @var string
     */
    public string $deadline;
}