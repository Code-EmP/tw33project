<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipSettingsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [PageController::class, 'about']);
Route::get('/dashboard', DashboardController::class)->name('dashboard');
Route::get('/membership-settings', [MembershipSettingsController::class, 'index'])
    ->name('membership-settings.index');
Route::post('/membership-settings/categories', [MembershipSettingsController::class, 'storeCategory'])
    ->name('membership-settings.categories.store');
Route::put('/membership-settings/categories/{category}', [MembershipSettingsController::class, 'updateCategory'])
    ->name('membership-settings.categories.update');
Route::post('/membership-settings/levels', [MembershipSettingsController::class, 'storeLevel'])
    ->name('membership-settings.levels.store');
Route::put('/membership-settings/levels/{level}', [MembershipSettingsController::class, 'updateLevel'])
    ->name('membership-settings.levels.update');
Route::patch('/members/{member}/deactivate', [MemberController::class, 'deactivate'])
    ->name('members.deactivate');
Route::resource('members', MemberController::class);
Route::get('/tasks/{id}', [PageController::class, 'task']);

Route::get('/tasks', [TaskController::class, 'index'])
    ->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])
    ->name('tasks.store');
