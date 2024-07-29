<?php

namespace App\Http\Requests;

use App\Dto\Tasks\TaskDto;
use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TaskRequest extends FormRequest
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
            'description' => ['required', 'string', 'max:24'],
            'priority' => ['required', new Enum(TaskPriorityEnum::class)],
            'status' => ['required', new Enum(TaskStatusEnum::class)],
            'deadline' => ['required', 'date'],
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function getDto(): TaskDto
    {
        return new TaskDto($this->validated());
    }

    public function messages()
    {
        return [
            'name.required' => 'Deadline is required',
            'description.required' => 'Description is required',
            'priority.required' => 'Priority is required',
            'status.required' => 'Status is required',
            'deadline.required' => 'Deadline is required'
        ];
    }
}
