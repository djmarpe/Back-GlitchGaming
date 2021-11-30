<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Extendemos el Storage de Laravel agregando nuestro nuevo driver.
        Storage::extend('dropbox', function ($app, $config) { 
            $client = new DropboxClient(
                $config['sl.A8c9LbOr-vFPQyhEdDIFBsIctfUxuQSxBMKjsQvlv78wCQl2ZdfFhOT3IIpRAXHcf1f81s-MvK_5pRPXfjNmXNG8FfeZgHuEGOky7pMua5RdQxzANEeb1umLY_0Lm_srEsabhdA'] // Hacemos referencia al hash
            );
            return new Filesystem(new DropboxAdapter($client)); 
        });
    }
}
