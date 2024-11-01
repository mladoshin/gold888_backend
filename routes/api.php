<?php

use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;
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
    $user =  \App\Models\User::with(['branch:id,name', 'branches:id,name'])->find($request->user()->id);
    return new \App\Http\Resources\UserResource($user);
});

Route::get('roles', function (){
    return \App\Models\User::roles();
});
Route::prefix('overdue')->name('overdue.')->group(function() {
    Route::post('create', [\App\Http\Controllers\Api\OverdueController::class, 'create'])->name('create');
    Route::put('update', [\App\Http\Controllers\Api\OverdueController::class, 'update'])->name('update');
    Route::get('status-list', [\App\Http\Controllers\Api\OverdueController::class, 'statusList'])->name('statusList');
    Route::get('list', [\App\Http\Controllers\Api\OverdueController::class, 'list'])->name('list');
    Route::get('item/{id}', [\App\Http\Controllers\Api\OverdueController::class, 'item'])->name('item');
    Route::delete('del/{id}', [\App\Http\Controllers\Api\OverdueController::class, 'del'])->name('del');

});
Route::middleware('auth:sanctum')->group(function (){

    Route::middleware('admin')->group(function (){
        Route::apiResource('regions',RegionController::class);
        Route::apiResource('users',UserController::class);
        Route::apiResource('branches',BranchController::class);
    });
    Route::apiResource('cities',CityController::class);

    Route::post('user/update-password', [UserController::class, 'updatePassword']);


    //reports
    Route::get('reports/last',[ReportController::class, 'getLastReport']);
    Route::get('reports/statistics',[ReportController::class, 'statistics']);
    Route::apiResource('reports',ReportController::class);


    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('check-auth',function (){
        if (!auth()->check())
            return response()->json(['success' => false, 'data' => false]);
        return response()->json(['success' => true, 'data' => true]);
    });
});
Route::post('auth/login', [AuthController::class, 'login']);
