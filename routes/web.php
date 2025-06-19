<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfficerController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'registerPage']);

Route::group(['prefix' => 'panel-control'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/vehicles', [VehicleController::class, 'indexPage']);

     Route::get('/officers', [OfficerController::class, 'index'])->name('officers.index');
    Route::get('/officers/create', [OfficerController::class, 'create'])->name('officers.create');
    Route::post('/officers', [OfficerController::class, 'store'])->name('officers.store');
    Route::get('/officers/{id}', [OfficerController::class, 'show'])->name('officers.show');
    Route::get('/officers/{id}/edit', [OfficerController::class, 'edit'])->name('officers.edit');
    Route::put('/officers/{id}', [OfficerController::class, 'update'])->name('officers.update');
    Route::delete('/officers/{id}', [OfficerController::class, 'destroy'])->name('officers.destroy');
});