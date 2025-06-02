<?php

use App\Http\Controllers\CsvController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

Route::post('/csv/show', [CsvController::class, 'show'])->name('show');

Route::middleware('auth')->group(function () {
    Route::get('/csv/search', [CsvController::class, 'search'])->name('search');
    Route::resource('/csv',CsvController::class);
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';