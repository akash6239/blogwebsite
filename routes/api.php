<?php

use App\Http\Controllers\Api\AdminAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post('admin/register',[AdminAuthController::class,'adminregister']);
// Route::post('admin/verify',[AdminAuthController::class,'adminlogin']);
// Route::post('admin/logout',[AdminAuthController::class,'adminlogout'])->middleware('auth:sanctum');
