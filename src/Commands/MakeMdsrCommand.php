<?php

namespace Mrtolouei\Structify\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

class MakeMdsrCommand extends Command {
	/** @var string */
	public $signature = 'structify:make-mdsr {name}';

	/** @var string */
	public $description = 'Create Model, DTO, Service, and Repository for a given entity.';

	/**
	 * @param Filesystem $file
	 */
	public function __construct(
		protected Filesystem $file,
	) {
		parent::__construct();
	}

	/**
	 * @return void
	 * @throws FileNotFoundException
	 */
	public function handle(): void {
		$name = $this->argument('name');
		$this->createDto($name);
		$this->createRepositoryInterface($name);
		$this->createRepository($name);
		$this->createServiceInterface($name);
		$this->createService($name);
		$this->info("MDSR files for $name created successfully!");
	}

	/**
	 * @throws FileNotFoundException
	 */
	protected function getStub($type): string {
		return $this->file->get(__DIR__ . "/../Stubs/mdsr/{$type}.stub");
	}

	/**
	 * @param $stub
	 * @param $name
	 * @return string
	 */
	protected function replacePlaceholders($stub, $name): string
	{
		return str_replace('{{Entity}}', $name, $stub);
	}

	/**
	 * @param $path
	 * @return void
	 */
	protected function makeDirectory($path): void {
		if (!$this->file->isDirectory(dirname($path))) {
			$this->file->makeDirectory(dirname($path), 0755, true, true);
		}
	}

	/**
	 * @param string $name
	 * @return void
	 * @throws FileNotFoundException
	 */
	protected function createDto(string $name): void {
		$stub = $this->getStub('dto');
		$path = App::path("Dto/{$name}Dto.php");
		$this->makeDirectory($path);
		$this->file->put($path, $this->replacePlaceholders($stub, $name));
	}

	/**
	 * @param string $name
	 * @return void
	 * @throws FileNotFoundException
	 */
	protected function createRepositoryInterface(string $name): void {
		$stub = $this->getStub('repository-interface');
		$path = App::path("Repositories/Interfaces/{$name}RepositoryInterface.php");
		$this->makeDirectory($path);
		$this->file->put($path, $this->replacePlaceholders($stub, $name));
	}

	/**
	 * @param string $name
	 * @return void
	 * @throws FileNotFoundException
	 */
	protected function createRepository(string $name): void {
		$stub = $this->getStub('repository');
		$path = App::path("Repositories/{$name}Repository.php");
		$this->makeDirectory($path);
		$this->file->put($path, $this->replacePlaceholders($stub, $name));
	}

	/**
	 * @param string $name
	 * @return void
	 * @throws FileNotFoundException
	 */
	protected function createServiceInterface(string $name): void {
		$stub = $this->getStub('service-interface');
		$path = App::path("Services/Interfaces/{$name}ServiceInterface.php");
		$this->makeDirectory($path);
		$this->file->put($path, $this->replacePlaceholders($stub, $name));
	}

	/**
	 * @param string $name
	 * @return void
	 * @throws FileNotFoundException
	 */
	protected function createService(string $name): void {
		$stub = $this->getStub('service');
		$path = App::path("Services/{$name}Service.php");
		$this->makeDirectory($path);
		$this->file->put($path, $this->replacePlaceholders($stub, $name));
	}
}