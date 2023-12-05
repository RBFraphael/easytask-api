<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("setup")->namespace("App\\Http\\Controllers")->group(function(){
    Route::get("storage", "AppSetup@storage");
    Route::get("db-reset", "AppSetup@resetDatabase");
    Route::get("db-upgrade", "AppSetup@upgradeDatabase");
});

Route::prefix("v1")->namespace("App\\Http\\Controllers\\Api\\V1")->group(function(){

    #region Auth
    Route::prefix("auth")->group(function(){
        Route::post("login", "AuthController@login");
        Route::post("refresh", "AuthController@refresh");
        Route::get("me", "AuthController@me");
        Route::post("logout", "AuthController@logout");
    });
    #endregion

    Route::middleware("auth:api")->group(function(){
        
        #region Users
        Route::apiResource("users", "UserController");
        #endregion

        #region Projects
        Route::apiResource("projects", "ProjectController");
        #endregion

        #region Tasks
        Route::apiResource("tasks", "TaskController");
        #endregion

        #region Comments
        Route::apiResource("comments", "CommentController");
        #endregion

        #region Files
        Route::apiResource("files", "FileController");
        #endregion

        #region Parameters
        Route::prefix("params")->group(function(){
            Route::get("task-statuses", "ParamController@taskStatuses");
            Route::get("user-roles", "ParamController@userRoles");
        });
        #endregion

    });

});
