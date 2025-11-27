<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use App\Http\Controllers\RekapController;

// AUTH ROUTES (JWT)
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    // Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    // Route::post('reset-password', [AuthController::class, 'resetPassword']);
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// PROTECTED ROUTES (JWT)
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('posts', PostController::class);
    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('pemasukan', PemasukanController::class);
    Route::apiResource('pengeluaran', PengeluaranController::class);

    // Route for PDF Download
    Route::get('/rekap/download', [RekapController::class, 'download'])
    ->middleware('auth:api');
});
