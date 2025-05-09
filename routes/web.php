<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthController::Class, 'index']);
Route::get('/register',[AuthController::class,'registerpage']);

Route::group(['prefix' => 'panel-control'], function () {
    Route::get('/dashboard',[DashboardController::class, 'index']);
});
