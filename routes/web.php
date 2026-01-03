<?php

use Illuminate\Support\Facades\Route;
use Okorpheus\DocumentLibrary\Http\Controllers\DocumentLibraryController;


Route::prefix('document-library')->group(function () {
    Route::get('/', [DocumentLibraryController::class, 'public'])->name('document-library.public');
});
