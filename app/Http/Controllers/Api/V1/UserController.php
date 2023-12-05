<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $repository
    ) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->repository->getAllUsers(
            request("with", ""),
            request("filters", ""),
            request("page", 1),
            request("per_page", 10),
            request("order", "ASC"),
            request("order_by", "id")
        );

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        return response()->json(
            $this->repository->createUser($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = $this->repository->getUserById(
            $user->id,
            request("with", "")
        );
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        return response()->json(
            $this->repository->updateUser($user->id, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->repository->deleteUser($user->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
