<?php

namespace Mrtolouei\Structify;

use Illuminate\Support\ServiceProvider;
use Mrtolouei\Structify\Commands\MakeMdsrCommand;

class StructifyServiceProvider extends ServiceProvider {

	public function boot(): void {
		if ($this->app->runningInConsole()) {
			$this->commands([
				MakeMdsrCommand::class,
			]);
		}
	}

	public function register(): void {
		//
	}
}