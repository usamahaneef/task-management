<?php

use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('admin.')->group(
    function () {
        Route::middleware('guest:admin')->group(function () {
            Route::view('/admin', 'auth.admin.login')->name('login');
            Route::view('/admin/login', 'auth.admin.login')->name('login');
            Route::post('/admin/login', [AuthController::class, 'login']);

            Route::get('admin/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
            Route::post('admin/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('forgot.password.send-email');
            Route::get('admin/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
            Route::post('admin/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
        });
        Route::middleware('auth')->group(function () {
            Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/admin/update-password', [AuthController::class, 'updatePassword'])->name('update-password');
            Route::post('/admin/store-password', [AuthController::class, 'storePassword'])->name('store-password');
            Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            /**
             * Tasks Routes
             */
            Route::prefix('admin')->group(function(){
                Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
                Route::get('/task/create', [TaskController::class, 'create'])->name('task.create');
                Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');
                Route::get('/task/edit/{task}', [TaskController::class, 'edit'])->name('task.edit');
                Route::post('/task/update/{task}', [TaskController::class, 'update'])->name('task.update');
                Route::delete('/task/delete/{task}', [TaskController::class, 'delete'])->name('task.delete');
            });       
        });
    }
);