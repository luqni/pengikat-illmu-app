<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('notes.index');
    }
    return view('welcome');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
Route::get('/login', function() {
    return redirect()->route('google.login');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::resource('notes', NoteController::class);
    Route::post('/ocr', [NoteController::class, 'ocr'])->name('notes.ocr');
    
    // Profile & Logout
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
