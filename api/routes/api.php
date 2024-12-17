<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'authLogin']);
Route::post('user/register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResources([
        'user' => UserController::class,
    ]);
    Route::post('auth/logout', [AuthController::class, 'authLogout']);

    // USER ROUTE
    Route::get('user/status/{status}', [UserController::class, 'getUserByStatus']);
    Route::get('user/status/{status}/{id}', [UserController::class, 'getUserByStatusExceptCurrent']);
    Route::get('user/status/name/{status}/{name}/{id}', [UserController::class, 'getUserByStatusAndName']);
    Route::get('user/name/{name}/{id}', [UserController::class, 'getUserByName']);
    Route::get('current/user', [UserController::class, 'getCurrentUser']);
    Route::get('user/except/current/{id}', [UserController::class, 'getAllUserExceptCurrent']);
});
