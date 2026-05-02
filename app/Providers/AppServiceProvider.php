<?php
<<<<<<< HEAD
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
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
if (env('APP_ENV') === 'production') {
URL::forceScheme('https');
}
}
}
=======

namespace App\Providers;

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
        //
    }
}
>>>>>>> 65b51754ff66c222a1d9fdc027683d09d9afc9cc
