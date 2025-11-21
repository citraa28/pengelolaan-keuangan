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

// ROUTE VERIFIKASI EMAIL
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id) {
    $user = User::find($id);

    if (!$user || !hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
        return redirect(config('app.frontend_url').'/login?message=verification_failed');
    }

    if ($user->hasVerifiedEmail()) {
        return redirect(config('app.frontend_url').'/login?message=already_verified');
    }

    if ($user->markEmailAsVerified()) {
        event(new \Illuminate\Auth\Events\Verified($user));
    }

    return redirect(config('app.frontend_url').'/login?message=verification_success');
})->middleware('signed')->name('verification.verify');

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
        
        // KIRIM ULANG VERIFIKASI EMAIL
        Route::post('email/resend', function (Request $request) {
            if ($request->user()->hasVerifiedEmail()) {
                return response()->json(['message' => 'Email sudah diverifikasi'], 400);
            }

            $request->user()->sendEmailVerificationNotification();

            return response()->json(['message' => 'Email verifikasi telah dikirim ulang!']);
        });
    });
});

// PROTECTED ROUTES (JWT)
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('posts', PostController::class);
    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('pemasukan', PemasukanController::class);
    Route::apiResource('pengeluaran', PengeluaranController::class);
});
