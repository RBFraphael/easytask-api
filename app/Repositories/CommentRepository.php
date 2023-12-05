<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository {

    public function createComment(array $commentData)
    {
        $comment = Comment::create($commentData);
        return $comment;
    }
    
    public function getAllComments(string $load = "", string $filters = "")
    {
        $comments = Comment::query();

        if(strlen($filters) > 0){
            $filters = explode(",", $filters);
            foreach($filters as $filter){
                [$cond, $value] = explode(":", $filter);
                $comments->where($cond, $value);
            }
        }

        $comments = $comments->get();
        
        if(strlen($load) > 0){
            $comments->load(
                explode(",", $load)
            );
        }
        
        return $comments;
    }
    
    public function getCommentById(int $commentId, string $load = "")
    {
        $comment = Comment::findOrFail($commentId);
        
        if(strlen($load) > 0){
            $comment->load(
                explode(",", $load)
            );
        }
        
        return $comment;
    }
    
    public function updateComment(int $commentId, array $commentData)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->update($commentData);
        return $comment;
    }
    
    public function deleteComment(int $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();
    }

}
