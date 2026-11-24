<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipSettingsController;
use App\Http\Controllers\MembershipTransactionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/email/verify', function (Request $request) {
        return $request->user()->hasVerifiedEmail()
            ? to_route('dashboard')
            : view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        if (! $request->user()->hasVerifiedEmail()) {
            $request->fulfill();
        }

        return to_route('dashboard')->with('success', 'Your email address has been verified.');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

Route::get('/', function () {
    return auth()->check() ? to_route('dashboard') : to_route('register');
});

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/membership', [MembershipController::class, 'index'])->name('membership.index');
    Route::get('/membership/{level}/checkout', [MembershipController::class, 'checkout'])->name('membership.checkout');
    Route::post('/membership/{level}/purchase', [MembershipController::class, 'purchase'])->name('membership.purchase');
    Route::post('/membership/unsubscribe', [MembershipController::class, 'unsubscribe'])->name('membership.unsubscribe');
    Route::get('/transactions', [MembershipTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}/receipt', [MembershipTransactionController::class, 'receipt'])->name('transactions.receipt');
    Route::get('/tasks/{id}', [PageController::class, 'task'])->name('tasks.show');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::middleware('admin')->group(function (): void {
        Route::get('/membership-settings', [MembershipSettingsController::class, 'index'])->name('membership-settings.index');
        Route::post('/membership-settings/categories', [MembershipSettingsController::class, 'storeCategory'])->name('membership-settings.categories.store');
        Route::put('/membership-settings/categories/{category}', [MembershipSettingsController::class, 'updateCategory'])->name('membership-settings.categories.update');
        Route::delete('/membership-settings/categories/{category}', [MembershipSettingsController::class, 'destroyCategory'])->name('membership-settings.categories.destroy');
        Route::post('/membership-settings/levels', [MembershipSettingsController::class, 'storeLevel'])->name('membership-settings.levels.store');
        Route::put('/membership-settings/levels/{level}', [MembershipSettingsController::class, 'updateLevel'])->name('membership-settings.levels.update');
        Route::delete('/membership-settings/levels/{level}', [MembershipSettingsController::class, 'destroyLevel'])->name('membership-settings.levels.destroy');
        Route::get('/payments/create', [MembershipTransactionController::class, 'create'])->name('payments.create');
        Route::post('/payments', [MembershipTransactionController::class, 'store'])->name('payments.store');
        Route::patch('/transactions/{transaction}/approve', [MembershipTransactionController::class, 'approve'])->name('transactions.approve');
        Route::patch('/members/{member}/deactivate', [MemberController::class, 'deactivate'])->name('members.deactivate');
        Route::post('/members/orphaned-accounts', [MemberController::class, 'destroyOrphanedAccounts'])->name('members.orphaned-accounts.destroy');
        Route::resource('members', MemberController::class);
    });
});
