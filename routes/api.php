<?php

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
Route::get('log-in', function () {
    return 'You need logged in';
})->name('login');
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('admin')->group(function () {

    });

    Route::middleware('job-seeker')->group(function () {
        Route::get('get-vacancies', [\App\Http\Controllers\VacancyController::class, 'index']);
        Route::get('vacancy/{id}', [\App\Http\Controllers\VacancyController::class, 'show']);
        Route::post('create-resume', [\App\Http\Controllers\ResumeController::class, 'store']);
        Route::put('update-resume/{id}', [\App\Http\Controllers\ResumeController::class, 'update']);
        Route::delete('delete-resume/{id}', [\App\Http\Controllers\ResumeController::class, 'delete']);
        Route::post('send-request', [\App\Http\Controllers\ResponseController::class, 'store']);
    });

    Route::middleware('employer')->group(function () {
        Route::get('get-resumes', [\App\Http\Controllers\ResumeController::class, 'index']);
        Route::get('resume/{id}', [\App\Http\Controllers\ResumeController::class, 'show']);
        Route::post('create-vacancy', [\App\Http\Controllers\VacancyController::class, 'store']);
        Route::put('update-vacancy/{id}', [\App\Http\Controllers\VacancyController::class, 'update']);
        Route::delete('delete-vacancy/{id}', [\App\Http\Controllers\VacancyController::class, 'delete']);
        Route::put('check-request/{id}', [\App\Http\Controllers\ResponseController::class, 'update']);
    });
});
