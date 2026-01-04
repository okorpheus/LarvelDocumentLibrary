<?php

use Illuminate\Support\Facades\Route;
use Okorpheus\DocumentLibrary\Http\Controllers\DocumentLibraryController;


Route::prefix('document-library')->group(function () {
    Route::get('/', [DocumentLibraryController::class, 'index'])->name('document-library.index');
    Route::get('/{directory}', [DocumentLibraryController::class, 'index'])->name('document-library.directory');
    Route::post('/directory', [DocumentLibraryController::class, 'storeDirectory'])->name('document-library.directory.store');
});
