<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::get('/', function () { return redirect()->route('notes.index'); });
Route::resource('notes', NoteController::class);
Route::post('/ocr', [NoteController::class, 'ocr'])->name('notes.ocr');
