<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Models\Organization;
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

Route::controller(LoginController::class)->name('user.')->group(function () {
    Route::post('/user/login', 'authenticate')->name('login');

    Route::get('/user/list', function (){
        return Organization::all(['name', 'email']);
    })->name('list');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(EventController::class)->name('event.')->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::get('/{event}', 'show')->name('show');
        Route::put('/{event}', 'replace')->name('replace');
        Route::patch('/{event}', 'update')->name('update');
        Route::delete('/{event}', 'delete')->name('delete');
    });
});
