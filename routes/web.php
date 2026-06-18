<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PartnerController;

// Page d'accueil
Route::get('/', function () {
    return view('index');
})->name('index');

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboards
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard')->middleware('user');
    
    Route::prefix('partner')->middleware('partner')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'partnerDashboard'])->name('partner.dashboard');
        Route::get('/profile', [PartnerController::class, 'editProfile'])->name('partner.profile');
        Route::post('/profile', [PartnerController::class, 'updateProfile'])->name('partner.profile.post');
        Route::get('/analytics', [PartnerController::class, 'analytics'])->name('partner.analytics');
    });
    
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        
        Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.users');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');
        
        Route::get('/partners', [AdminController::class, 'listPartners'])->name('admin.partners');
        Route::get('/partners/{partner}', [AdminController::class, 'viewPartner'])->name('admin.partners.view');
        Route::patch('/partners/{partner}/approve', [AdminController::class, 'approvePartner'])->name('admin.partners.approve');
        Route::patch('/partners/{partner}/reject', [AdminController::class, 'rejectPartner'])->name('admin.partners.reject');
    });
});
