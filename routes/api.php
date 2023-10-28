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

Route::post('user/signup',[\App\Http\Controllers\Api\AuthController::class, 'signup']);
Route::post('user/login',[\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('user/forgot-password',[\App\Http\Controllers\Api\AuthController::class, 'forgotPassword']);
Route::post('user/otp-verify',[\App\Http\Controllers\Api\AuthController::class, 'otpVerify']);
Route::post('user/reset-password',[\App\Http\Controllers\Api\AuthController::class, 'resetPassword']);
Route::post('user/verify-email',[\App\Http\Controllers\Api\AuthController::class, 'verifyEmail']);
Route::get('user/email/verify/{id}/{hash}', [\App\Http\Controllers\Api\AuthController::class, 'verify'])->name('verification.verify');

Route::get('universities/list',[\App\Http\Controllers\Api\UniversityController::class, 'index']);
Route::middleware('auth:user_api')->group(function(){
    Route::get('dashboard',[App\Http\Controllers\Api\DashboardController::class, 'index']);
    /**Societies routes */
    Route::get('societies/list',[App\Http\Controllers\Api\SocietiesController::class, 'index']);
    Route::get('society/detail/{id}',[App\Http\Controllers\Api\SocietiesController::class, 'detail']);
    /**Student Profile */
    Route::post('user/profile/{id}',[\App\Http\Controllers\Api\AuthController::class, 'profile']);
    Route::post('user/update-password/{id}',[\App\Http\Controllers\Api\AuthController::class, 'updatePassword']);

    /** Venue Routes */
    Route::get('venues/list',[App\Http\Controllers\Api\VenuesController::class, 'index']);
    Route::get('venue/detail/{id}',[App\Http\Controllers\Api\VenuesController::class, 'detail']);

    /** Events Routes  */
    Route::get('events/list',[App\Http\Controllers\Api\EventsController::class, 'index']);
    Route::get('event/detail/{id}',[App\Http\Controllers\Api\EventsController::class, 'detail']);
    Route::get('delete-account',[App\Http\Controllers\Api\AuthController::class, 'deleteMyAccount']);
});

