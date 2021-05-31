<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\RegistrationController;

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

Route::get('/', [IndexController::class, 'onPageLoad'])->name('home');
Route::post('/', [IndexController::class, 'onSubmit']);

Route::get('/events/{id}', [EventsController::class, 'onPageLoad']);
Route::post('/events/{id}', [EventsController::class, 'onSubmit']);

Auth::routes();

Route::get('organise-event', [App\Http\Controllers\CreateEventController::class, 'onPageLoad']);
Route::post('organise-event', [App\Http\Controllers\CreateEventController::class, 'onSubmit']);
