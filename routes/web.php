<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::middleware(['auth'])->group(function () {
    // File routes
    Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');
    Route::get('/files', [FileController::class, 'index'])->name('files.index');

    Route::delete('/files/{id}', [FileController::class, 'delete'])->name('files.delete');
    Route::get('/files/search', [FileController::class, 'search'])->name('files.search');
    Route::post('/files/share', [FileController::class, 'shareFile'])->name('files.share');

    // Folder routes
    Route::post('/folders', [FolderController::class, 'create'])->name('folders.create');
    Route::get('/folders', [FolderController::class, 'index'])->name('folders.index');
    Route::delete('/folders/{id}', [FolderController::class, 'delete'])->name('folders.delete');
    Route::post('/files/{file}/rename', [FileController::class, 'rename'])->middleware('auth')->name('files.rename');
    Route::post('/files/move', [FileController::class, 'move'])->middleware('auth')->name('files.move');;

    Route::get('/shared', [FileController::class, 'shared'])->name('files.shared');
    Route::get('/files/{id}', [FileController::class, 'show'])->name('files.show');
    Route::get('/files/search/results', [FileController::class, 'searchResults'])->name('files.search.results');
    Route::get('/demo', [FileController::class, 'demo'])->name('demo');


});
