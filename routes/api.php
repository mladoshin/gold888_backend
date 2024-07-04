<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function (){
    Route::get('check-auth',function (){
        if (!auth()->check())
            return response()->json(['success' => false, 'data' => false]);

        return response()->json(['success' => true, 'data' => true]);
    });
    Route::get('reports/last',[ReportController::class, 'getLastReport']);
    Route::apiResource('reports',ReportController::class);
    Route::get('reports/statistics',[ReportController::class, 'statisti']);
});
Route::post('auth/login', [AuthController::class, 'login']);

Route::get('test', [ReportController::class, 'test']);
