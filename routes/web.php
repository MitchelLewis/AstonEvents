<?php

use App\Http\Controllers\ChangeEventController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MyEventsController;
use App\Http\Controllers\CreateEventController;
use App\Http\Controllers\EmailController;
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

Route::get('events/{id}', [EventsController::class, 'onPageLoad']);
Route::post('events/{id}', [EventsController::class, 'onSubmit']);

Auth::routes();

Route::get('organise-event', [CreateEventController::class, 'onPageLoad']);
Route::post('organise-event', [CreateEventController::class, 'onSubmit']);

Route::get('my-events', [MyEventsController::class, 'onPageLoad']);

Route::get('edit-event/{id}', [ChangeEventController::class, 'onPageLoad']);
Route::post('edit-event/{id}', [ChangeEventController::class, 'onSubmit']);

Route::get('send-mail/{id}', [EmailController::class, 'onPageLoad']);
Route::post('send-mail/', [EmailController::class, 'onSubmit']);