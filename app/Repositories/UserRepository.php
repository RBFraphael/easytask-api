<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {

    public function createUser(array $userData)
    {
        $user = User::create($userData);
        return $user;
    }
    
    public function getAllUsers(string $load = "", string $filters = "", int $page = 1, int $per_page = 10, string $order = "ASC", string $orderBy = "id")
    {
        $users = User::query();

        if(strlen($filters) > 0){
            $filters = explode(",", $filters);
            foreach($filters as $filter){
                [$cond, $value] = explode(":", $filter);
                $users->where($cond, $value);
            }
        }
        
        if(strlen($load) > 0){
            $users->with(
                explode(",", $load)
            );
        }

        $users = $users->orderBy($orderBy, $order);
        $users = $users->paginate($per_page, ["*"], "page", $page);

        $data = [
            'current_page' => $users->currentPage(),
            'data' => $users->items(),
            'from' => $users->firstItem(),
            'last_page' => $users->lastPage(),
            'order' => $order,
            'order_by' => $orderBy,
            'per_page' => $users->perPage(),
            'to' => $users->lastItem(),
            'total' => $users->total(),
        ];
        
        return $data;
    }

    public function getUserById(int $userId, string $load = "")
    {
        $user = User::findOrFail($userId);
        
        if(strlen($load) > 0){
            $user->load(
                explode(",", $load)
            );
        }
        
        return $user;
    }

    public function updateUser(int $userId, array $userData)
    {
        $user = User::findOrFail($userId);
        $user->update($userData);
        return $user;
    }

    public function deleteUser(int $userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
    }

}
