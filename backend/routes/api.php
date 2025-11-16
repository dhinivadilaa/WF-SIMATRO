<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\FeedbackController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Tanpa Login)
|--------------------------------------------------------------------------
*/

// Register
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::post('/login', [AuthController::class, 'login']);

// Daftar event (public)
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

// Absensi (peserta input email + PIN)
Route::post('/attendance', [AttendanceController::class, 'store']);

// Download sertifikat (public)
Route::get('/certificate/{token}', [CertificateController::class, 'download']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Harus pakai token Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Event Management (Admin)
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);

    // Materials
    Route::post('/materials', [MaterialController::class, 'store']);
    Route::get('/materials/{event_id}', [MaterialController::class, 'index']);
    Route::delete('/materials/{id}', [MaterialController::class, 'destroy']);

    // Feedback
    Route::post('/feedback', [FeedbackController::class, 'store']);

    // Certificate Generate (Admin)
    Route::post('/certificate/generate', [CertificateController::class, 'generate']);

    // Logout
    Route::post('/logout', function (Request $request) {
        $request->user()->tokens()->delete();
        return ['message' => 'Logout berhasil'];
    });
});
