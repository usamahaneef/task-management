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


Route::get('tasks/list',[\App\Http\Controllers\Api\TaskController::class , 'index']);
Route::post('task/create',[\App\Http\Controllers\Api\TaskController::class , 'create']);
Route::put('task/update/{id}',[\App\Http\Controllers\Api\TaskController::class , 'update']);
Route::delete('task/delete/{id}',[\App\Http\Controllers\Api\TaskController::class , 'delete']);
Route::post('task/status/{id}',[\App\Http\Controllers\Api\TaskController::class , 'status']);
Route::get('task/filter/{status}', [\App\Http\Controllers\Api\TaskController::class, 'filter']);


