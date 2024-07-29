<?php

namespace App\Services;

use App\Dto\ProjectDto;
use App\Models\Project;
use App\Notifications\ProjectNotification;
use App\Notifications\TaskNotification;
use App\Repositories\ProjectRepository;
use App\Services\Notifications\NotificationInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    private ProjectRepository $projectRepository;
    private NotificationInterface $notification;
    private TaskService $taskService;

    public function __construct(
        ProjectRepository $projectRepository, NotificationInterface $notification, TaskService $taskService)
    {
        $this->projectRepository = $projectRepository;
        $this->notification = $notification;
        $this->taskService = $taskService;
    }

    public function getAll(): Collection
    {
        return $this->projectRepository->all();
    }

    public function createProject(ProjectDto $projectDto): Project
    {
        $project = $this->projectRepository->create($projectDto->except('tasks')->toArray());
        if ($projectDto->tasks) {
            $project->tasks()->createMany($projectDto->only('tasks')->toArray()['tasks']);
        }
        $this->notification->send($project->owner->email, new ProjectNotification($project));

        return $project;
    }

    public function updateProject(Project $project, ProjectDto $projectDto)
    {
        // Обновляем проект
        $project->update($projectDto->except('tasks')->toArray());

        // Получаем все текущие ID задач проекта
        $currentTaskIds = $project->tasks()->pluck('id')->toArray();

        // Получаем новые ID задач из входящих данных
        $newTaskIds = array_filter(array_map(function ($task) {
            return (int)$task->id ?? null;
        }, $projectDto->tasks), function ($id) {
            return !is_null($id);
        });

        // Находим удаленные задачи, которые больше не существуют в новых данных
        $removedIds = array_values(array_diff($currentTaskIds, $newTaskIds));

        // Обновляем или создаем задачи
        foreach ($projectDto->tasks as $taskData) {
            $task = $project->tasks()->updateOrCreate(['id' => $taskData->id], $taskData->toArray());
            if ($task->wasRecentlyCreated) {
                $this->notification->send($project->owner->email, new TaskNotification($task));
            }
        }

        // Удаляем задачи, которые больше не существуют в новых данных
        $this->taskService->deleteTasks($removedIds);
    }

    public function deleteProject(Project $project)
    {
        return $project->delete();
    }
}