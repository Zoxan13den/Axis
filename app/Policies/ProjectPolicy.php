<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any projects.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the project.
     */
    public function view(User $user, Project $project)
    {
        return true;
    }

    /**
     * Determine whether the user can create projects.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the project.
     */
    public function update(User $user, Project $project)
    {
        return $user->role === UserRoleEnum::ADMIN || $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can delete the project.
     */
    public function delete(User $user, Project $project)
    {
        return $user->role === UserRoleEnum::ADMIN || $user->id === $project->user_id;
    }
}
