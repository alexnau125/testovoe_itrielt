<?php

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

//Route::get('/', function () {
//    return view('welcome');
//})->name('home');

Route::middleware("auth")->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::resource('/admin/event', App\Http\Controllers\Admin\EventController::class );

    Route::get('/event', [App\Http\Controllers\EventController::class, 'index'] )->name('event_list');
    Route::get('/event/{id}', [App\Http\Controllers\EventController::class, 'show'] )->name('event_show');
    Route::post('/event/join', [App\Http\Controllers\EventController::class, 'join'] )->name('event_join');
    Route::get('/event/visit_confirm/{event_id}/{code}', [App\Http\Controllers\EventController::class, 'visitConfirm'] )->name('event_visit_confirm');


    Route::get('/qrcode_viewer', function () {
        return view('welcome');
    } )->name('qrcode_viewer');

});



Route::middleware("guest")->group(function () {
    Route::get('/', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login_process', [\App\Http\Controllers\AuthController::class, 'login'])->name('login_process');


});
