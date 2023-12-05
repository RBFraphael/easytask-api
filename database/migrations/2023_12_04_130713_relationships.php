<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("projects", function(Blueprint $table){
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
        });

        Schema::table("tasks", function(Blueprint $table){
            $table->foreign("project_id")->references("id")->on("projects")->cascadeOnDelete();
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
        });

        Schema::table("comments", function(Blueprint $table){
            $table->foreign("task_id")->references("id")->on("tasks")->cascadeOnDelete();
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
        });

        Schema::table("task_files", function(Blueprint $table){
            $table->foreign("task_id")->references("id")->on("tasks")->cascadeOnDelete();
            $table->foreign("file_id")->references("id")->on("files")->cascadeOnDelete();
        });

        Schema::table("comment_files", function(Blueprint $table){
            $table->foreign("comment_id")->references("id")->on("comments")->cascadeOnDelete();
            $table->foreign("file_id")->references("id")->on("files")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("tasks", function(Blueprint $table){
            $table->dropForeign(["project_id", "user_id"]);
        });

        Schema::table("comments", function(Blueprint $table){
            $table->dropForeign(["project_id", "user_id"]);
        });

        Schema::table("task_files", function(Blueprint $table){
            $table->dropForeign(["task_id", "file_id"]);
        });

        Schema::table("task_files", function(Blueprint $table){
            $table->dropForeign(["comment_id", "file_id"]);
        });
    }
};
