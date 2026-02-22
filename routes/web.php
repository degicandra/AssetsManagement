<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AssetImportController;
use App\Http\Controllers\AssetTypeController;

// Home page
Route::get('/', [AuthController::class, 'home'])->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password reset routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard/licenses-expired-soon', [DashboardController::class, 'getLicensesExpiredSoon'])->name('dashboard.licenses-expired-soon');
    Route::get('/api/dashboard/licenses-expired', [DashboardController::class, 'getLicensesExpired'])->name('dashboard.licenses-expired');
    
    // Assets - JSON endpoint BEFORE resource routes to prioritize matching
    Route::get('/assets/json', [AssetController::class, 'jsonIndex'])->name('assets.json');
    Route::get('/assets/search/{code}', [AssetController::class, 'searchByCode'])->name('assets.search');
    Route::get('/assets/import', [AssetImportController::class, 'showImportForm'])->name('assets.import-form');
    Route::post('/assets/import', [AssetImportController::class, 'import'])->name('assets.import');
    Route::get('/assets/download-template', [AssetImportController::class, 'downloadTemplate'])->name('assets.download-template');
    
    // Assets resource routes
    Route::resource('assets', AssetController::class);
    Route::post('/assets/{asset}/upgrade', [AssetController::class, 'upgrade'])->name('assets.upgrade');
    
    // Emails - JSON endpoint BEFORE resource routes
    Route::get('/emails/json/filter', [EmailController::class, 'jsonFilter'])->name('emails.json-filter');
    Route::resource('emails', EmailController::class);
    
    // Licenses
    Route::resource('licenses', LicenseController::class);
    
    // Users
    Route::resource('users', UserController::class, ['only' => ['index', 'store', 'destroy']]);
    
    // Departments
    Route::resource('departments', DepartmentController::class, ['only' => ['index', 'store', 'update', 'destroy']]);
    
    // Floors
    Route::resource('floors', FloorController::class, ['only' => ['index', 'store', 'update', 'destroy']]);
    
    // Locations
    Route::resource('locations', LocationController::class, ['only' => ['index', 'store', 'update', 'destroy']]);
    
    // Asset Types
    Route::resource('types', AssetTypeController::class, ['only' => ['index', 'store', 'update', 'destroy']]);
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/users', [SettingController::class, 'users'])->name('settings.users');
    Route::get('/settings/departments', [SettingController::class, 'departments'])->name('settings.departments');
    Route::get('/settings/floors', [SettingController::class, 'floors'])->name('settings.floors');
    Route::get('/settings/locations', [SettingController::class, 'locations'])->name('settings.locations');
    Route::post('/settings/departments', [SettingController::class, 'storeDepartment'])->name('settings.departments.store');
    Route::post('/settings/floors', [SettingController::class, 'storeFloor'])->name('settings.floors.store');
    Route::post('/settings/locations', [SettingController::class, 'storeLocation'])->name('settings.locations.store');
    
    // API endpoints for modals
    Route::get('/api/licenses', [LicenseController::class, 'modalView'])->name('api.licenses');
    Route::get('/api/settings/{type}', [SettingController::class, 'settingsModalView'])->name('api.settings');
});
