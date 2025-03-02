<?php

namespace Mrtolouei\Structify;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Mrtolouei\Structify\Commands\MakeMdsrCommand;

class StructifyServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeMdsrCommand::class,
            ]);
            $this->publishes([
                __DIR__ . '/Stubs' => App::basePath('stubs/'),
            ], 'structify-stubs');
        }
    }

    public function register(): void
    {
        //
    }
}
