<?php

use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\PerformanceController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('roles', RoleController::class);
Route::apiResource('exercises', ExerciseController::class)->only(['index', 'show']);
Route::apiResource('performances', PerformanceController::class);
Route::apiResource('users', ProfileController::class);
Route::put('/user/{user}', [AuthenticationController::class, 'update'])->name('user.update');
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // PROTECTED ROUTES
    Route::apiResource('roles', RoleController::class)->only(['edit', 'destroy', 'update', 'store']);
    Route::apiResource('exercises', ExerciseController::class)->only(['edit', 'destroy', 'update']);
    Route::apiResource('performances', PerformanceController::class)->only(['edit', 'destroy', 'update']);
    Route::apiResource('users', ProfileController::class)->only(['edit', 'destroy', 'update']);
    Route::get('profile', function (Request $request) { return auth()->user(); });Route::get('/profile/edit', [ProfileController::class, 'edit']);
    Route::put('/user', [ProfileController::class, 'update']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::delete('/user', [AuthenticationController::class, 'delete']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});
Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found'
    ], 404);
});
