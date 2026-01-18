<?php

use Illuminate\Support\Facades\Route;
use Okorpheus\DocumentLibrary\Http\Controllers\DocumentLibraryController;


Route::prefix('document-library')->group(function () {
    Route::get('/', [DocumentLibraryController::class, 'index'])->name('document-library.index');
    Route::get('/{directory}', [DocumentLibraryController::class, 'index'])->name('document-library.directory');
    Route::post('/directory', [DocumentLibraryController::class, 'storeDirectory'])->name('document-library.directory.store');
    Route::post('/', [DocumentLibraryController::class, 'storeFile'])->name('document-library.file.store');
    Route::delete('/directory/{directory}', [DocumentLibraryController::class, 'destroyDirectory'])->name('document-library.directory.destroy');
});
