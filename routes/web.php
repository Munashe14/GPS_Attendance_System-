<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegionalAdminController;
use App\Http\Controllers\SysAdminController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route(Auth::user()->dashboardRoute());
    })->name('dashboard');
});

// Lecturer Routes
Route::middleware(['auth'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('/dashboard', [LecturerController::class, 'dashboard'])->name('dashboard');
    Route::get('/session/create', [LecturerController::class, 'createSession'])->name('create-session');
    Route::post('/session', [LecturerController::class, 'storeSession'])->name('store-session');
    Route::get('/session/{id}', [LecturerController::class, 'session'])->name('session');
    Route::post('/session/{id}/activate', [LecturerController::class, 'activateSession'])->name('activate-session');
    Route::post('/session/{id}/refresh-qr', [LecturerController::class, 'refreshQrCode'])->name('refresh-qr');
    Route::get('/session/{id}/qr', [LecturerController::class, 'generateQrCode'])->name('generate-qr');
    Route::post('/session/{id}/close', [LecturerController::class, 'closeSession'])->name('close-session');
});

// Student Routes
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/scan', [StudentController::class, 'scan'])->name('scan');
    Route::post('/validate-attendance', [StudentController::class, 'validateAttendance'])->name('validate-attendance');
});

// Regional Admin Routes
Route::middleware(['auth'])->prefix('regional-admin')->name('regional-admin.')->group(function () {
    Route::get('/dashboard', [RegionalAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/centres', [RegionalAdminController::class, 'centres'])->name('centres');
    Route::get('/centres/create', [RegionalAdminController::class, 'createCentre'])->name('create-centre');
    Route::post('/centres', [RegionalAdminController::class, 'storeCentre'])->name('store-centre');
    Route::get('/centres/{id}/edit', [RegionalAdminController::class, 'editCentre'])->name('edit-centre');
    Route::put('/centres/{id}', [RegionalAdminController::class, 'updateCentre'])->name('update-centre');
    Route::get('/reports', [RegionalAdminController::class, 'reports'])->name('reports');
});

// System Admin Routes
Route::middleware(['auth'])->prefix('sys-admin')->name('sys-admin.')->group(function () {
    Route::get('/dashboard', [SysAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [SysAdminController::class, 'users'])->name('users');
    Route::get('/audit-logs', [SysAdminController::class, 'auditLogs'])->name('audit-logs');
});

require __DIR__.'/auth.php';
