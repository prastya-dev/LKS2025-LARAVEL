<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GamesController;
Route::middleware('auth:sanctum')->group(function() {
    Route::post('/v1/auth/signout',[AuthController::class, 'signout']);

    Route::middleware('IsAdmin')->group(function () {
    Route::post('/v1/users',[AuthController::class, 'signup']);
    
    Route::get('/v1/admins',[UsersController::class, 'admins']);
    Route::get('/v1/users',[UsersController::class, 'users']);
    Route::put('/v1/users/{id}',[UsersController::class, 'update']);
    Route::delete('/v1/users/{id}',[UsersController::class, 'delete']);
    Route::get('/v1/users/{username}',[UsersController::class, 'getUsername']); 
    });
   Route::get('/v1/usersE',[UsersController::class, 'getUser']);
   Route::get('/v1/games', [GamesController::class, 'indexAll']);
   Route::post('/v1/games', [GamesController::class, 'create']);
   Route::get('/v1/games/{slug}', [GamesController::class, 'get']);
   Route::get('/v1/games/{slug}/scores', [GamesController::class, 'getScore']);

});

Route::post('/v1/auth/signin',[AuthController::class, 'login']);
Route::post('/v1/auth/signup',[AuthController::class, 'signup']);

