<?php

namespace Mrtolouei\Structify;

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
                __DIR__ . '/Stubs' => base_path('stubs/'),
            ], 'structify-stubs');
        }
    }

    public function register(): void
    {
        //
    }
}
