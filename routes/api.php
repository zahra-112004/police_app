<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


    Route::post('/register', [AuthController::class,'register']);
    Route::post('/login', [AuthController::class,'login']);


Route::group(['prefix'=> 'panel-control','middleware'=>['auth:sanctum']], function (){
    Route::get('/profile', [AuthController::class,'profile']);
    Route::post('/logout', [AuthController::class,'logout']);

});