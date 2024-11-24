<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HospitalController;

Route::middleware(['auth'])->group(function () {
    // Rol ve izin yönetimi (sadece yöneticiler)
    Route::middleware(['permission:ayarları-yönet'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });
    
    // Kullanıcı rol yönetimi
    Route::middleware(['permission:kullanıcı-yönet'])->group(function () {
        Route::get('users/{user}/roles', [UserController::class, 'roles'])
            ->name('users.roles');
        Route::post('users/{user}/assign-role', [UserController::class, 'assignRole']);
        Route::post('users/{user}/revoke-role', [UserController::class, 'revokeRole']);
        Route::post('users/{user}/assign-permission', [UserController::class, 'assignPermission']);
        Route::post('users/{user}/revoke-permission', [UserController::class, 'revokePermission']);
        Route::post('/users/{user}/roles', [UserController::class, 'assignRoles'])->name('users.roles.assign');
    });

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/permissions', [UserController::class, 'permissions'])->name('users.permissions');
    Route::post('users/{user}/permissions', [UserController::class, 'assignPermission'])->name('users.permissions.assign');
    Route::delete('users/{user}/permissions', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile')->middleware('auth');

    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
    Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    
    Route::get('/hospitals', [HospitalController::class, 'index'])->name('hospitals.index');

    Route::get('/users/{user}/model-permissions', [UserController::class, 'modelPermissions'])->name('users.model-permissions');
    Route::delete('/users/{user}/model-permissions/{modelPermission}', [UserController::class, 'revokeModelPermission'])->name('users.model-permissions.revoke');
    Route::post('/users/{user}/model-permissions', [UserController::class, 'assignModelPermission'])->name('users.model-permissions.assign');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


