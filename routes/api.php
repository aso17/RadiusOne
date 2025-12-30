<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectInfoController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| PUBLIC API (NO AUTH, NO SANCTUM)
|--------------------------------------------------------------------------
*/

Route::middleware('api-public')->group(function () {
    Route::get('/ping', fn () => response()->json(['status' => 'ok']));
    Route::get('/project-info', [ProjectInfoController::class, 'show']);
});

/*
|--------------------------------------------------------------------------
| AUTH API (SANCTUM SPA)
|--------------------------------------------------------------------------
*/
Route::middleware('api')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me', fn (Request $request) => $request->user());

});
