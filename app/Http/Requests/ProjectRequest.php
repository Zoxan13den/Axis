<?php

namespace App\Http\Requests;

use App\Dto\ProjectDto;
use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:24'],
            'description' => ['required', 'string'],
            'status' => ['required', 'boolean'],
            'user_id' => ['integer', 'exists:users,id'],
            'tasks' => ['array'],
            'tasks.*.id' => ['nullable', 'integer', 'exists:tasks,id'],
            'tasks.*.name' => ['required', 'string', 'max:24'],
            'tasks.*.description' => ['required', 'string', 'max:24'],
            'tasks.*.priority' => ['required', new Enum(TaskPriorityEnum::class)],
            'tasks.*.status' => ['required', new Enum(TaskStatusEnum::class)],
            'tasks.*.deadline' => ['required', 'date'],
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function getDto(): ProjectDto
    {
        return new ProjectDto($this->validated());
    }

    public function messages()
    {
        return [
            'name.required' => 'Deadline is required',
            'description.required' => 'Description is required',
            'status.required' => 'Status is required',
            'tasks.*.deadline' => 'Task deadline is required'
        ];
    }
}
