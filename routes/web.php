<?php

use Illuminate\Support\Facades\Route;
use Okorpheus\DocumentLibrary\Http\Controllers\DocumentLibraryController;


Route::prefix('document-library')->group(function () {
    Route::get('/', [DocumentLibraryController::class, 'index'])->name('document-library.index');
    Route::get('/{directory}', [DocumentLibraryController::class, 'index'])->name('document-library.directory');
    Route::post('/directory', [DocumentLibraryController::class, 'storeDirectory'])->name('document-library.directory.store');
    Route::post('/', [DocumentLibraryController::class, 'storeFile'])->name('document-library.file.store');
    Route::delete('/directory/{directory}', [DocumentLibraryController::class, 'destroyDirectory'])->name('document-library.directory.destroy');
    Route::delete('/file/{document}', [DocumentLibraryController::class, 'destroyDocument'])->name('document-library.document.destroy');
    Route::patch('/directory/{directory}', [DocumentLibraryController::class, 'updateDirectory'])->name('document-library.directory.update');
    Route::patch('/file/{document}', [DocumentLibraryController::class, 'updateDocument'])->name('document-library.document.update');
});
