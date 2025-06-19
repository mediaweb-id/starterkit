<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

		foreach (glob(app_path().'/Helpers/*.php') as $filename) {
			require_once ($filename);
		}
        
        Route::middleware(['web']) // or 'api'
            ->prefix('backend') // optional
            ->group(base_path('routes/backend.php'));
    }
}
