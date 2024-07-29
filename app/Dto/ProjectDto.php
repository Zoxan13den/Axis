<?php

namespace App\Dto;

use App\Dto\Tasks\TaskDto;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class ProjectDto extends BaseDataObject
{
    /**
     * @var int|null
     */
    public int|null $user_id;

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
    public string $status;

    /**
     * @var array|null
     */
    /** @var TaskDto[] */
    #[CastWith(ArrayCaster::class, itemType: TaskDto::class)]
    public array|null $tasks;
}