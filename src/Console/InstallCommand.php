<?php

namespace Cirel\LaravelBasicsAuxs\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'laravel-basics-auxs:install';

    protected $description = 'Instala Laravel Basics Auxs en la aplicación';

    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'laravel-basics-auxs',
            '--force' => true,
        ]);

        $this->info('Laravel Basics Auxs se ha instalado correctamente.');
    }
}
