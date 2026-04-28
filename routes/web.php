<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use App\Models\Material;

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) { 
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::redirect('/', '/login');
Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', [JobController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');




Route::get('/jobs/create', function () {
    $materials = Material::all(); 
    return view('create-job-v2', compact('materials'));
})->middleware(['auth'])->name('jobs.create');

Route::get('/materials/{id}/details', [JobController::class, 'getMaterialDetails'])
    ->middleware(['auth'])
    ->name('materials.details');




Route::post('/jobs/store', [JobController::class, 'store'])
    ->middleware(['auth'])
    ->name('jobs.store');

Route::post('/job/create', [JobController::class, 'create']);

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');

Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');

require __DIR__ . '/auth.php';