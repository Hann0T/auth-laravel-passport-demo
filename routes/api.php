<?php

use App\Http\Controllers\GradeController;
use App\Http\Controllers\GradePersonalController;
use App\Http\Controllers\GradeM2MController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalAccessTokenController;
use App\Http\Middleware\AddScopesByRole;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->prefix('grades')->group(function () {
    Route::middleware('scopes:view-grades')
        ->get('/', [GradeController::class, 'index']);
    Route::middleware('scopes:update-grades')
        ->post('/update/{grade}', [GradeController::class, 'update']);
});

Route::prefix('m2m/grades')->group(function () {
    Route::middleware('client:view-grades')
        ->get('/', [GradeM2MController::class, 'index']);
    Route::middleware('client:update-grades')
        ->post('/update/{grade}', [GradeM2MController::class, 'update']);
});

Route::middleware('auth:api')->prefix('personal/grades')->group(function () {
    Route::middleware('client:view-grades')
        ->get('/', [GradePersonalController::class, 'index']);
    Route::middleware('client:update-grades')
        ->post('/update/{grade}', [GradePersonalController::class, 'update']);
});

Route::middleware(AddScopesByRole::class)
    ->post('personal/token/issue', [PersonalAccessTokenController::class, 'getToken']);
