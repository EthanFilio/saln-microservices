<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'service' => 'auth-service',
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
    ]);
});

Route::post('auth/send-code', [AuthController::class, 'sendCode']);
Route::post('auth/verify-login', [AuthController::class, 'verifyLogin']);
Route::post('auth/mail-test', [AuthController::class, 'mailTest']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
