<?php

namespace Cirel\LaravelBasicsAuxs;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class LaravelBasicsAuxsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Aquí puedes registrar cualquier binding en el contenedor de servicios
    }

    public function boot(Filesystem $filesystem)
    {
        $this->publishes([
            __DIR__ . '/Auxs/' => app_path('Auxs'),
            __DIR__ . '/Traits/' => app_path('Traits'),
            __DIR__ . '/Handlers/' => app_path('Exceptions'),
            __DIR__ . 'Http/Requests/' => app_path('Http/Requests'),
        ], 'laravel-basics-auxs');

        $filesystem->copy(__DIR__ . '/Handlers/InvalidJsonResponseHandler.php', app_path('Exceptions/Handler.php'));
    }
}