<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationController;
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

Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('organization/list', [OrganizationController::class, 'list'])->name('organization.list');

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(EventController::class)->prefix('event')->name('event.')->group(function () {

        Route::get('/list', 'list')->name('list');

        Route::middleware('can:manage,event')->group(function () {
            Route::get('/{event}', 'show')->name('show');
            Route::put('/{event}', 'replace')->name('replace');
            Route::patch('/{event}', 'update')->name('update');
            Route::delete('/{event}', 'delete')->name('delete');
        });
    });
});
