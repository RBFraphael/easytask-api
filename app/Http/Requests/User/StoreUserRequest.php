<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'first_name' => "required|string",
            'last_name' => "required|string",
            'email' => "required|email|unique:users,email",
            'password' => "required|string|min:6",
            'role' => "required|in:".join(",", UserRole::cases()),
        ];
    }
}
