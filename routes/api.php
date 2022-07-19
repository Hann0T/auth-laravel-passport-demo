<?php

use App\Http\Controllers\GradeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
