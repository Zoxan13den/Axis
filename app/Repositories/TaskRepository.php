<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends AbstractRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Task::class;
    }
}