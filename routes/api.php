<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;


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

Route::post('/users/register', [AuthController::class, 'register']);
Route::post('/users/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/animals', [AnimalController::class, 'index']);
    Route::get('/animals/filter/{sound}', [AnimalController::class, 'filter']);
    Route::get('/animals/{animal}', [AnimalController::class, 'show']);
    Route::post('/animals', [AnimalController::class, 'create']);
    Route::delete('/animals/{id}', [AnimalController::class, 'destroy']);
    Route::put('/animals/{animal}', [AnimalController::class, 'update']);
});

