<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParamController extends Controller
{
    public function taskStatuses()
    {
        $statuses = [];

        foreach(TaskStatus::cases() as $status){
            $statuses[] = [
                'label' => TaskStatus::label($status),
                'value' => $status,
                'color' => TaskStatus::color($status)
            ];
        }

        return response()->json($statuses);
    }

    public function userRoles()
    {
        $roles = [];
        
        foreach(UserRole::cases() as $role){
            $roles[] = [
                'label' => UserRole::label($role),
                'value' => $role,
            ];
        }

        return response()->json($roles);
    }
}
