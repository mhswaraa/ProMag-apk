<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AttendanceController; 

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Tambahkan ini SEBELUM resource attendances
    Route::get('/attendances/report/pdf', [AttendanceController::class, 'downloadPdf'])->name('attendances.pdf');
    Route::resource('attendances', AttendanceController::class);

    Route::resource('materials', MaterialController::class);
    
    // Feature: Steps / Sub-Points
    Route::post('/materials/step/add', [MaterialController::class, 'storeStep'])->name('materials.step.store');
    Route::put('/materials/step/{id}', [MaterialController::class, 'updateStep'])->name('materials.step.update');
    
    // TAMBAHKAN BARIS INI:
    Route::delete('/materials/step/{id}', [MaterialController::class, 'destroyStep'])->name('materials.step.destroy');
});

require __DIR__.'/auth.php';
