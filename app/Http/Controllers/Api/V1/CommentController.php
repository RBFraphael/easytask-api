<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function __construct(
        private CommentRepository $repository
    ) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = $this->repository->getAllComments(
            request("with", ""),
            request("filters", "")
        );

        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        return response()->json(
            $this->repository->createComment($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $comment = $this->repository->getCommentById(
            $comment->id,
            request("with", "")
        );
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        return response()->json(
            $this->repository->updateComment($comment->id, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->repository->deleteComment($comment->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
