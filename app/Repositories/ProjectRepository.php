<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends AbstractRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Project::class;
    }
}