<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleCalendarController;
use App\Models\Event;

Route::get('/', function () {return view('welcome');});

Route::get('auth/google', [GoogleCalendarController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback']);

Route::get('/events', [GoogleCalendarController::class, 'listEvents']);
Route::get('/events/refresh', [GoogleCalendarController::class, 'refreshEvents']);

Route::get('/api/events', function () {return Event::all();});