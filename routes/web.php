<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\GameWinnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('teams', TeamController::class)
    ->except(['show']);
Route::resource('games', GameController::class)
    ->except(['show']);
Route::get('games/{game}/winners', [GameWinnerController::class, 'edit'])->name('games.winners.edit');
Route::post('games/{game}/winners', [GameWinnerController::class, 'update'])->name('games.winners.update');
Route::view('positions', 'positions')->name('positions');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
