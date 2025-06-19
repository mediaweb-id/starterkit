<?php

namespace AcitJazz\Starterkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class StarterkitCommand extends Command
{
    protected $signature = 'starterkit:adjusted-namespace';
    protected $description = 'Publish starterkit models, routes, seeders, and http files with adjusted namespaces';

    public function handle()
    {
        $this->publishModels();
        $this->publishTraits();
        $this->publishRoutes();
        $this->publishSeeders();
        $this->publishHttp();
        $this->publishTraits();
        $this->publishQueryFilters();
        $this->publishRules();
        $this->updateAuthConfig();
        $this->updateAppServiceProvider();
        $this->updateBootstrapApp();
    }

    protected function publishModels()
    {
        $source = base_path('vendor/acitjazz/starterkit/src/Models');
        $destination = app_path('Models');
        File::copyDirectory($source, $destination);

        foreach (File::allFiles($destination) as $file) {
            $contents = File::get($file->getPathname());
            $updated = str_replace('namespace AcitJazz\Starterkit\Models;', 'namespace App\Models;', $contents);
            File::put($file->getPathname(), $updated);
        }

        $this->info('✅ Models published with updated namespaces.');
    }

    protected function publishTraits()
    {
        $source = base_path('vendor/acitjazz/starterkit/src/Traits');
        $destination = app_path('Traits');
        File::copyDirectory($source, $destination);

        foreach (File::allFiles($destination) as $file) {
            $contents = File::get($file->getPathname());
            $updated = str_replace(['namespace AcitJazz\Starterkit', 'use AcitJazz\Starterkit'], ['namespace App', 'use App'], $contents);
            File::put($file->getPathname(), $updated);
        }

        $this->info('✅ Traits published with updated namespaces.');
    }

    protected function publishQueryFilters()
    {
        $source = base_path('vendor/acitjazz/starterkit/src/QueryFilters');
        $destination = app_path('QueryFilters');
        File::copyDirectory($source, $destination);

        foreach (File::allFiles($destination) as $file) {
            $contents = File::get($file->getPathname());
            $updated = str_replace(['namespace AcitJazz\Starterkit', 'use AcitJazz\Starterkit'], ['namespace App', 'use App'], $contents);
            File::put($file->getPathname(), $updated);
        }

        $this->info('✅ Traits published with updated namespaces.');
    }

    protected function publishRules()
    {
        $source = base_path('vendor/acitjazz/starterkit/src/Rules');
        $destination = app_path('Rules');
        File::copyDirectory($source, $destination);

        foreach (File::allFiles($destination) as $file) {
            $contents = File::get($file->getPathname());
            $updated = str_replace(['namespace AcitJazz\Starterkit', 'use AcitJazz\Starterkit'], ['namespace App', 'use App'], $contents);
            File::put($file->getPathname(), $updated);
        }

        $this->info('✅ Traits published with updated namespaces.');
    }


    protected function publishRoutes()
    {
        $source = base_path('vendor/acitjazz/starterkit/routes');
        $destination = base_path('routes');
        File::copyDirectory($source, $destination);

        foreach (File::allFiles($destination) as $file) {
            if ($file->getFilename() === 'backend.php') {
                $contents = File::get($file->getPathname());
                $updated = str_replace(
                    'use AcitJazz\Starterkit\Http\Controllers',
                    'use App\Http\Controllers',
                    $contents
                );
                File::put($file->getPathname(), $updated);
            }
        }

        $this->info('✅ Backend routes published with updated namespaces.');
    }

    protected function publishSeeders()
    {
        $source = base_path('vendor/acitjazz/starterkit/database/seeders');
        $destination = base_path('database/seeders');
        File::copyDirectory($source, $destination);

        foreach (File::allFiles($destination) as $file) {
            $contents = File::get($file->getPathname());
            $updated = str_replace('use AcitJazz\Starterkit', 'use App', $contents);
            File::put($file->getPathname(), $updated);
        }

        $this->info('✅ Seeders published with updated namespaces.');
    }

    protected function publishHttp()
    {
        $source = base_path('vendor/acitjazz/starterkit/src/Http');
        $destination = app_path('Http');
        File::copyDirectory($source, $destination);

        foreach (File::allFiles($destination) as $file) {
            $contents = File::get($file->getPathname());
            $updated = str_replace(['namespace AcitJazz\Starterkit', 'use AcitJazz\Starterkit'], ['namespace App', 'use App'], $contents);
            File::put($file->getPathname(), $updated);
        }

        $this->info('✅ Controllers & Http files published with updated namespaces.');
    }

    protected function updateAuthConfig()
    {
        $configPath = config_path('auth.php');

        if (!file_exists($configPath)) {
            $this->error('❌ auth.php not found.');
            return;
        }

        $contents = file_get_contents($configPath);

        // Add guard
        if (!str_contains($contents, "'admin' => [")) {
            $guard = <<<EOT
            'admin' => [
                'driver' => 'session',
                'provider' => 'admins',
            ],
        EOT;
            $contents = preg_replace("/('guards'\s*=>\s*\[\s*\n)/", "\$1" . $guard . "\n", $contents);
            $this->info('✅ Admin guard added.');
        } else {
            $this->info('⚠️ Admin guard already exists.');
        }

        // Add provider
        if (!str_contains($contents, "'admins' => [")) {
            $provider = <<<EOT
            'admins' => [
                'driver' => 'eloquent',
                'model' => App\Models\Admin::class,
            ],
        EOT;
            $contents = preg_replace("/('providers'\s*=>\s*\[\s*\n)/", "\$1" . $provider . "\n", $contents);
            $this->info('✅ Admin provider added.');
        } else {
            $this->info('⚠️ Admin provider already exists.');
        }

        file_put_contents($configPath, $contents);
        $this->info('✅ config/auth.php updated.');
    }

    protected function updateAppServiceProvider()
    {
        $providerPath = app_path('Providers/AppServiceProvider.php');

        if (!file_exists($providerPath)) {
            $this->error('❌ AppServiceProvider.php not found.');
            return;
        }

        $contents = file_get_contents($providerPath);
        $updated = false;

        // Add helpers loader
        if (!str_contains($contents, "glob(app_path().'/Helpers/*.php')")) {
            $helperCode = <<<EOT
            foreach (glob(app_path().'/Helpers/*.php') as \$filename) {
                require_once(\$filename);
            }
        EOT;

            $contents = preg_replace('/(public function boot\(\): void\s*\{\s*)/', "\$1\n" . $helperCode . "\n", $contents);
            $this->info('✅ Helpers loader added.');
            $updated = true;
        }

        if ($updated) {
            file_put_contents($providerPath, $contents);
            $this->info('✅ AppServiceProvider updated.');
        } else {
            $this->info('⚠️ Nothing to update. Code already exists.');
        }
    }

    protected function updateBootstrapApp()
    {
        $appFile = base_path('bootstrap/app.php');

        if (!file_exists($appFile)) {
            $this->error('❌ bootstrap/app.php not found.');
            return;
        }

        $contents = file_get_contents($appFile);

        if (str_contains($contents, "'auth.admin' =>")) {
            $this->info('⚠️ Middleware aliases already exist. No changes made.');
            return;
        }

        $aliasBlock = <<<PHP
            \$middleware->alias([
                'auth.admin' => \\App\\Http\\Middleware\\AuthAdmin::class,
                'permission' => \\Spatie\\Permission\\Middleware\\PermissionMiddleware::class,
                'role' => \\Spatie\\Permission\\Middleware\\RoleMiddleware::class,
                'role_or_permission' => \\Spatie\\Permission\\Middleware\\RoleOrPermissionMiddleware::class,
                'admin_permission' => \\App\\Http\\Middleware\\AdminPermission::class,
                'guest.admin' => \\App\\Http\\Middleware\\GuestAdmin::class,
            ]);
        PHP;

        if (preg_match('/->withMiddleware\s*\(\s*function\s*\(Middleware\s+\$middleware\)\s*\{/', $contents, $match, PREG_OFFSET_CAPTURE)) {
            $insertPos = $match[0][1] + strlen($match[0][0]);
            $contents = substr_replace($contents, "\n" . $aliasBlock . "\n", $insertPos, 0);
            file_put_contents($appFile, $contents);
            $this->info('✅ Middleware aliases added to bootstrap/app.php');
        } else {
            $this->error('❌ Failed to find the withMiddleware block.');
        }
    }
}
