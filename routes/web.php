<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('notes.index');
    }
    return view('auth.login');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::middleware('auth')->group(function () {
    Route::resource('notes', NoteController::class);
    Route::post('/ocr', [NoteController::class, 'ocr'])->name('notes.ocr');
});
