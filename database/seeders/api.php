<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('exercises', ExerciseController::class)->only(['index', 'show']); // Use 'store' instead of 'create'
Route::apiResource('performances', PerformanceController::class)->only(['index', 'show', 'store']);

Route::get('exercises/{id}/performances', [ExerciseController::class, 'index']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // PROTECTED ROUTES
    Route::apiResource('exercises', ExerciseController::class)->only(['edit', 'destroy', 'update', 'store']);
    Route::apiResource('performances', PerformanceController::class)->only(['edit', 'destroy', 'update']);
    Route::delete('exercises/{id}/performances', [PerformanceController::class, 'destroy']);
    Route::get('profile', function (Request $request) { return auth()->user(); });
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found'
    ], 404);
});
