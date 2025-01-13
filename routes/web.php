<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KomponenController;
use App\Http\Controllers\KaryawanKomponenController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\GajiKomponenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeluhanController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\CheckUserRole;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [GajiController::class, 'dashboard'])->name('dashboard');
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('/notification/send', [NotificationController::class, 'showSendNotificationForm'])->name('notification.sendForm');
    Route::post('/notification/send', [NotificationController::class, 'sendNotifications'])->name('notification.send');

    Route::prefix('karyawan')->middleware(CheckUserRole::class . ':Admin')->group(function () {
        Route::get('/index', [KaryawanController::class, 'index'])->name('karyawan');
        Route::get('/create', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::post('/store', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::get('/edit/{id}', [KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::put('/update/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/destroy/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    });

    Route::prefix('komponen')->group(function () {
        Route::get('/index', [KomponenController::class, 'index'])->name('komponen.index');
        Route::get('/create', [KomponenController::class, 'create'])->name('komponen.create');
        Route::post('/store', [KomponenController::class, 'store'])->name('komponen.store');
        Route::get('/edit/{id}', [KomponenController::class, 'edit'])->name('komponen.edit');
        Route::put('/update/{id}', [KomponenController::class, 'update'])->name('komponen.update');
        Route::delete('/destroy/{id}', [KomponenController::class, 'destroy'])->name('komponen.destroy');
    });

    Route::prefix('karyawan_komponen')->group(function () {
        Route::get('/create/{karyawan_id}', [KaryawanKomponenController::class, 'create'])->name('karyawan_komponen.create');
        Route::post('/store', [KaryawanKomponenController::class, 'store'])->name('karyawan_komponen.store');
        Route::get('/show/{karyawan_id}', [KaryawanKomponenController::class, 'show'])->name('karyawan_komponen.show');
        Route::get('/edit/{id}', [KaryawanKomponenController::class, 'edit'])->name('karyawan_komponen.edit');
        Route::put('/update/{id}', [KaryawanKomponenController::class, 'update'])->name('karyawan_komponen.update');
        Route::delete('/destroy/{id}', [KaryawanKomponenController::class, 'destroy'])->name('karyawan_komponen.destroy');
    });

    Route::prefix('gaji')->group(function () {
        Route::get('/index', [GajiController::class, 'index'])->name('gaji.index');
        Route::get('/create', [GajiController::class, 'create'])->name('gaji.create');
        Route::post('/store', [GajiController::class, 'store'])->name('gaji.store');
        Route::get('/edit/{id}', [GajiController::class, 'edit'])->name('gaji.edit');
        Route::put('/update/{id}', [GajiController::class, 'update'])->name('gaji.update');
        Route::delete('/destroy/{id}', [GajiController::class, 'destroy'])->name('gaji.destroy');
        Route::post('/import', [GajiController::class, 'import'])->name('gaji.import');
        Route::get('/print', [GajiController::class, 'print'])->name('gaji.print');
    });

    Route::prefix('slip-gaji')->group(function () {
        Route::get('/show/{karyawan_id}', [GajiController::class, 'show'])->name('slip-gaji.index');
        Route::get('/print/{gaji_id}', [GajiController::class, 'slipPrint'])->name('slip-gaji.print');
    });

    Route::prefix('gaji_komponen')->group(function () {
        Route::get('/create/{gaji_id}', [GajiKomponenController::class, 'create'])->name('gaji_komponen.create');
        Route::post('/store', [GajiKomponenController::class, 'store'])->name('gaji_komponen.store');
        Route::get('/show/{gaji_id}', [GajiKomponenController::class, 'show'])->name('gaji_komponen.show');
        Route::get('/edit/{id}', [GajiKomponenController::class, 'edit'])->name('gaji_komponen.edit');
        Route::put('/update/{id}', [GajiKomponenController::class, 'update'])->name('gaji_komponen.update');
        Route::delete('/destroy/{id}', [GajiKomponenController::class, 'destroy'])->name('gaji_komponen.destroy');
    });

    Route::prefix('keluhan')->group(function () {
        Route::get('/index', [KeluhanController::class, 'index'])->name('keluhan.index');
        Route::get('/create/{gaji_id}', [KeluhanController::class, 'create'])->name('keluhan.create');
        Route::post('/store', [KeluhanController::class, 'store'])->name('keluhan.store');
        Route::put('/approve/{id}', [KeluhanController::class, 'approve'])->name('keluhan.approve');
        Route::put('/reject/{id}', [KeluhanController::class, 'reject'])->name('keluhan.reject');
    });
});

