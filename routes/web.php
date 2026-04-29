<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobTagController;
use App\Http\Controllers\TagController;
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


Route::get('/jobs/{job}/download-stl', [JobController::class, 'downloadStl'])
    ->middleware(['auth'])
    ->name('jobs.downloadStl');

Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');

Route::get('/tags/create', [TagController::class, 'create'])->name('tag.create');
Route::post('/tags', [TagController::class, 'store'])->name('tags.store');

Route::get('/jobs/{job}/tags/create', [TagController::class, 'assign'])->name('jobs.tags.create');
Route::post('/jobs/{job}/tags', [TagController::class, 'storeRelation'])->name('jobs.tags.update');
Route::delete('/jobs/{job}/tags/{tag}', [JobTagController::class, 'destroy'])->name('jobs.tags.destroy');

Route::delete('/tags/delete-permanently', [TagController::class, 'destroy'])->name('tags.destroy_permanent');

require __DIR__ . '/auth.php';