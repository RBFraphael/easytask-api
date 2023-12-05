<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $logged_in = !is_null(auth()->user());
        $role = $logged_in ? auth()->user()->role : null;
        return $logged_in && ($role == UserRole::ADMIN || $role == UserRole::MANAGER);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => "required|numeric|exists:projects,id",
            'title' => "required|string",
            'description' => "required|string",
            'user_id' => "required|numeric|exists:users,id",
            'status' => "required|in:".join(",", TaskStatus::cases()),
        ];
    }
}
