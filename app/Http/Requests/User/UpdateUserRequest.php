<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $user = request()->route("user");

        return [
            'first_name' => "string",
            'last_name' => "string",
            'email' => "email|unique:users,email,".$user->id,
            'password' => "string|min:6",
            'role' => "in:".join(",", UserRole::cases()),
        ];
    }
}
