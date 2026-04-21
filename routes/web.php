<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', [JobController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::get('/jobs/create', function () {
    return view('create-job'); 
})->middleware(['auth'])->name('jobs.create');

Route::post('/jobs/store', [JobController::class, 'store'])
    ->middleware(['auth'])
    ->name('jobs.store');

    Route::post('/job/create', [JobController::class, 'create']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';