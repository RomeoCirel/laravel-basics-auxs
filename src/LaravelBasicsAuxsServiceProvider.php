<?php
namespace Cirel\LaravelBasicsAuxs;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class LaravelBasicsAuxsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // nada por aqui
    }

    public function boot(Filesystem $filesystem)
    {

        $paths = [
            'Auxs' => app_path('Auxs'),
            'Traits' => app_path('Traits'),
            'Handlers' => app_path('Exceptions'),
            'Requests' => app_path('Http/Requests'),
        ];

        foreach ($paths as $key => $path) {
            if (!$filesystem->exists($path)) {
                $filesystem->makeDirectory($path, 0755, true);
            }
        }

        $this->publishes([
            __DIR__ . '/Auxs/' => $paths['Auxs'],
            __DIR__ . '/Traits/' => $paths['Traits'],
            __DIR__ . '/Handlers/' => $paths['Handlers'],
            __DIR__ . '/Http/Requests/' => $paths['Requests'],
        ], 'laravel-basics-auxs');

        $this->copyDirectoryContents($filesystem, __DIR__ . '/Auxs', $paths['Auxs']);
        $this->copyDirectoryContents($filesystem, __DIR__ . '/Traits', $paths['Traits']);
        $this->copyDirectoryContents($filesystem, __DIR__ . '/Handlers', $paths['Handlers']);
        $this->copyDirectoryContents($filesystem, __DIR__ . '/Http/Requests', $paths['Requests']);



        $filesystem->copy(__DIR__ . '/Handlers/InvalidJsonResponseHandler.php', $paths['Handlers'] . '/InvalidJsonResponseHandler.php');
    }

    protected function copyDirectoryContents(Filesystem $filesystem, $sourceDir, $destinationDir)
    {
        $files = $filesystem->allFiles($sourceDir);

        foreach ($files as $file) {
            $filesystem->copy($file->getRealPath(), $destinationDir . '/' . $file->getFilename());
        }
    }
}
