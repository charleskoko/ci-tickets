<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\EventTypeController;
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

Route::prefix('v1')->group(function () {
    Route::post('/registration', [AuthenticationController::class, 'registration'])->name('api.v1.registration');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('api.v1.login');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthenticationController::class, 'logout'])->name('api.v1.logout');

        Route::prefix('event-type')->group(function () {
            Route::get('/', [EventTypeController::class, 'index'])->name('api.v1.event_type-index');
            Route::middleware('isAdmin')->group(function (){
                Route::post('/', [EventTypeController::class, 'store'])->name('api.v1.event_type-store');
                Route::patch('/{eventType}', [EventTypeController::class, 'update'])->name('api.v1.event_type-update');
                Route::delete('/{eventType}', [EventTypeController::class, 'destroy'])->name('api.v1.event_type-destroy');
            });
        });
    });
});
