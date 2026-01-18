<?php

namespace Okorpheus\DocumentLibrary;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Okorpheus\DocumentLibrary\Models\Directory;
use Okorpheus\DocumentLibrary\Models\Document;
use Okorpheus\DocumentLibrary\Policies\DirectoryPolicy;
use Okorpheus\DocumentLibrary\Policies\DocumentPolicy;

class DocumentLibraryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/documentlibrary.php',
            'documentlibrary'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(Directory::class, DirectoryPolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);

        $this->publishes([
            __DIR__.'/../config/documentlibrary.php' => config_path('documentlibrary.php'),
        ], 'documentlibrary-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/document-library'),
        ], 'documentlibrary-views');

        // Register route model binding BEFORE loading routes
        Route::bind('directory', function ($value) {
            return \Okorpheus\DocumentLibrary\Models\Directory::findOrFail($value);
        });

        // Load routes with web middleware group to enable route model binding
        Route::middleware('web')
            ->group(__DIR__ . '/../routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'document-library');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
