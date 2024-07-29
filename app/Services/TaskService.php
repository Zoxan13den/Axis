<?php

namespace App\Services;

use App\Dto\Tasks\TaskDto;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $projectRepository)
    {
        $this->taskRepository = $projectRepository;
    }

    public function getAll(): Collection
    {
        return $this->taskRepository->all();
    }

    public function createTask(TaskDto $dto): Task
    {
        return $this->taskRepository->create($dto->toArray());
    }

    public function updateTask(Task $task, TaskDto $dto): bool
    {
        return $task->update($dto->toArray());
    }

    public function deleteTasks(array $ids)
    {
        foreach ($ids as $id){
            $this->taskRepository->deleteWhereIn(['id' => $id]);
        }
    }
}