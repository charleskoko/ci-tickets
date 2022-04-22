<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EventController;
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
            Route::middleware('isAdmin')->group(function () {
                Route::post('/', [EventTypeController::class, 'store'])->name('api.v1.event_type-store');
                Route::patch('/{eventType}', [EventTypeController::class, 'update'])->name('api.v1.event_type-update');
                Route::delete('/{eventType}', [EventTypeController::class, 'destroy'])->name('api.v1.event_type-destroy');
            });
        });
        Route::prefix('company')->group(function () {
            Route::get('/', [CompanyController::class, 'index'])->middleware('isAdmin')->name('api.v1.company-index');
            Route::post('/', [CompanyController::class, 'store'])->middleware('isProUserOrAdmin')->name('api.v1.company-store');
            Route::middleware('isCompanyOwnerOrAdmin')->group(function () {
                Route::prefix('{company}')->group(function () {
                    Route::patch('/', [CompanyController::class, 'update'])->name('api.v1.company-update');
                    Route::get('/', [CompanyController::class, 'show'])->name('api.v1.company-show');
                    Route::delete('/', [CompanyController::class, 'destroy'])->name('api.v1.company-destroy');
                });
            });
        });
        Route::prefix('event')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('api.v1.event-index');
            Route::post('/', [EventController::class, 'store'])->name('api.v1.event-store');
            Route::patch('/{event}', [EventController::class, 'update'])->name('api.v1.event-update');
            Route::delete('/{event}', [EventController::class, 'destroy'])->name('api.v1.event-destroy');
        });
    });
});
