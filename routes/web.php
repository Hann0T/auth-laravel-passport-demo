<?php

use App\Http\Controllers\GradeController;
use App\Http\Controllers\PassportClientsController;
use App\Http\Controllers\PassportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PassportClientsController::class, 'index'])
    ->middleware(['auth']);

Route::prefix('grades')->group(function () {
    Route::get('/', [GradeController::class, 'index'])->name('grades.index');
    Route::get('/create', [GradeController::class, 'create']);
    Route::post('/store', [GradeController::class, 'store']);
    Route::get('/edit/{grade}', [GradeController::class, 'edit']);
    Route::post('/update/{grade}', [GradeController::class, 'update']);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('passport')->group(function () {
    Route::get('/redirect', [PassportController::class, 'redirect']);
});
