<?php

namespace App\Http\Requests\Project;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $logged_in = !is_null(auth()->user());
        $role = $logged_in ? auth()->user()->role : null;
        return $logged_in && $role == UserRole::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'label' => "string",
            'user_id' => "numeric|exists:users,id"
        ];
    }
}
