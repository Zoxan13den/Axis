<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tasks.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the task.
     */
    public function view(User $user, Task $task)
    {
        return true;
    }

    /**
     * Determine whether the user can create tasks.
     */
    public function create(User $user)
    {
        return $user->role === UserRoleEnum::ADMIN;
    }

    /**
     * Determine whether the user can update the task.
     */
    public function update(User $user, Task $task)
    {
        return $user->role === UserRoleEnum::ADMIN || $user->id === $task->project->user_id;
    }

    /**
     * Determine whether the user can delete the task.
     */
    public function delete(User $user, Task $task)
    {
        return $user->role === UserRoleEnum::ADMIN || $user->id === $task->project->user_id;
    }
}
