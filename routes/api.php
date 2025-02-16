<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//contact CRUD
Route::apiResource('contacts', ContactController::class)->middleware('auth:sanctum');


//User register,login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//User profile,logout
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


//recipe CRUD
Route::apiResource('recipes', RecipeController::class);
Route::post('/recipes/upload', [RecipeController::class, 'upload']);
