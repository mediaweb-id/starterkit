<?php

namespace AcitJazz\Starterkit;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use AcitJazz\Starterkit\Commands\StarterkitCommand;

class StarterkitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('starterkit')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations([
                'create_admins_table',
                'create_admin_passwords_table',
                'create_medias_table',
                'create_pages_table',
                'create_permission_tables',
            ])
            ->hasCommand(StarterkitCommand::class);
            // Hapus .hasRoutes() untuk manual handling
    }

    public function packageBooted()
    {
        // Load route dari publish path jika ada, fallback ke default
        $publishedRoutePath = base_path('routes/backend.php');
        $defaultRoutePath = __DIR__ . '/../routes/backend.php';

        if (file_exists($publishedRoutePath)) {
            $this->loadRoutesFrom($publishedRoutePath);
        } else {
            $this->loadRoutesFrom($defaultRoutePath);
        }

        // Publish Routes
        $this->publishes([
            __DIR__ . '/../routes' => base_path('routes'),
        ], 'starterkit-routes');

        // Asset & Resource Publishing
        $this->publishes([
            __DIR__ . '/../resources/js/' => resource_path('js/'),
            __DIR__ . '/../resources/css/' => resource_path('css/'),
            __DIR__ . '/../resources/views/' => resource_path('views/'),
            __DIR__ . '/../vite.config.ts' => base_path('vite.config.ts'),
            __DIR__ . '/../.env.example' => base_path('.env.example'),
        ], 'starterkit-assets');

        $this->publishes([
            __DIR__ . '/../database/seeders/' => base_path('database/seeders/'),
        ], 'starterkit-seeders');

        // Source Code Publishing
        $this->publishes([__DIR__ . '/Models' => app_path('Models')], 'starterkit-models');
        $this->publishes([__DIR__ . '/Rules' => app_path('Rules')], 'starterkit-rules');
        $this->publishes([__DIR__ . '/QueryFilters' => app_path('QueryFilters')], 'starterkit-queryfilters');
        $this->publishes([__DIR__ . '/Traits' => app_path('Traits')], 'starterkit-traits');
        $this->publishes([__DIR__ . '/Helpers' => app_path('Helpers')], 'starterkit-helpers');
        $this->publishes([__DIR__ . '/Http/Controllers' => app_path('Http/Controllers')], 'starterkit-controllers');
        $this->publishes([__DIR__ . '/Http/Repositories' => app_path('Http/Repositories')], 'starterkit-repositories');
        $this->publishes([__DIR__ . '/Http/Requests' => app_path('Http/Requests')], 'starterkit-requests');
        $this->publishes([__DIR__ . '/Http/Resources' => app_path('Http/Resources')], 'starterkit-resources');
        $this->publishes([__DIR__ . '/Http/Middleware' => app_path('Http/Middleware')], 'starterkit-middleware');
    }
}
