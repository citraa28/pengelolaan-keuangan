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

// ROUTE VERIFIKASI EMAIL (Public)
Route::get('/auth/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $user = User::find($request->route('id'));

    // Pastikan user ada dan hash cocok (handled by signed middleware and EmailVerificationRequest)
    if (!$user) {
        return redirect(config('app.frontend_url') . '/login?message=verification_failed');
    }

    if ($user->hasVerifiedEmail()) {
        return redirect(config('app.frontend_url') . '/login?message=already_verified');
    }

    $request->fulfill(); // Tandai email sebagai diverifikasi

    return redirect(config('app.frontend_url') . '/login?message=verification_success');
})->middleware(['signed'])->name('verification.verify');


// ROUTE UNTUK MENGIRIM ULANG VERIFIKASI EMAIL (Public)
Route::post('/auth/email/resend', [AuthController::class, 'resendVerificationEmail'])->middleware(['throttle:6,1'])->name('verification.send');


// AUTH ROUTES (JWT)
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    
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
});
