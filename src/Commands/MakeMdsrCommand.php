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
     * Execute the console command.
     *
     * @return int
     * @throws FileNotFoundException
     */
	public function handle(): int {
		$name = $this->argument('name');
        $this->createModel($name);
		$this->createDto($name);
		$this->createRepositoryInterface($name);
		$this->createRepository($name);
		$this->createServiceInterface($name);
		$this->createService($name);
        $this->updateMdsrServiceProvider($name);
		$this->info("MDSR files for $name created successfully!");
        return 0;
	}

    /**
     * Get the contents of a stub file.
     *
     * @param string $type
     * @return string
     * @throws FileNotFoundException
     */
	protected function getStub(string $type): string {
		return $this->file->get(__DIR__ . "/../Stubs/mdsr/$type.stub");
	}

    /**
     * Replace placeholders in the stub with the given entity name.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
	protected function replacePlaceholders(string $stub, string $name): string
	{
		return str_replace('{{Entity}}', $name, $stub);
	}

    /**
     * Ensure the directory exists.
     *
     * @param string $path
     * @return void
     */
	protected function ensureDirectoryExists(string $path): void {
		if (!$this->file->isDirectory(dirname($path))) {
			$this->file->makeDirectory(dirname($path), 0755, true, true);
		}
	}

    /**
     * Create a Model file for the given entity.
     *
     * @param string $name
     * @return void
     */
    protected function createModel(string $name): void {
        $this->call('make:model', [
           'name' => $name,
            '--migration' => true
        ]);
    }

    /**
     * Create a DTO file for the given entity.
     *
     * @param string $name
     * @return void
     * @throws FileNotFoundException
     */
	protected function createDto(string $name): void {
		$stub = $this->getStub('dto');
		$path = App::path("Dto/{$name}Dto.php");
		$this->ensureDirectoryExists($path);
		$this->file->put($path, $this->replacePlaceholders($stub, $name));
	}

    /**
     * Create a Repository Interface file for the given entity.
     *
     * @param string $name
     * @return void
     * @throws FileNotFoundException
     */
	protected function createRepositoryInterface(string $name): void {
		$stub = $this->getStub('repository-interface');
		$path = App::path("Repositories/Interfaces/{$name}RepositoryInterface.php");
		$this->ensureDirectoryExists($path);
		$this->file->put($path, $this->replacePlaceholders($stub, $name));
	}

    /**
     * Create a Repository file for the given entity.
     *
     * @param string $name
     * @return void
     * @throws FileNotFoundException
     */
	protected function createRepository(string $name): void {
		$stub = $this->getStub('repository');
		$path = App::path("Repositories/{$name}Repository.php");
		$this->ensureDirectoryExists($path);
		$this->file->put($path, $this->replacePlaceholders($stub, $name));
	}

    /**
     * Create a Service Interface file for the given entity.
     *
     * @param string $name
     * @return void
     * @throws FileNotFoundException
     */
	protected function createServiceInterface(string $name): void {
		$stub = $this->getStub('service-interface');
		$path = App::path("Services/Interfaces/{$name}ServiceInterface.php");
		$this->ensureDirectoryExists($path);
		$this->file->put($path, $this->replacePlaceholders($stub, $name));
	}

    /**
     * Create a Service file for the given entity.
     *
     * @param string $name
     * @return void
     * @throws FileNotFoundException
     */
	protected function createService(string $name): void {
		$stub = $this->getStub('service');
		$path = App::path("Services/{$name}Service.php");
		$this->ensureDirectoryExists($path);
		$this->file->put($path, $this->replacePlaceholders($stub, $name));
	}

    /**
     * Update or create the MdsrServiceProvider and bind the repository and service interfaces to their implementations.
     *
     * @param string $name
     * @return void
     * @throws FileNotFoundException
     */
    protected function updateMdsrServiceProvider(string $name): void
    {
        $providerPath = App::path('Providers/MdsrServiceProvider.php');
        if (!$this->file->exists($providerPath)) {
            $this->call('make:provider', [
                'name' => 'MdsrServiceProvider',
            ]);
        }
        $bindings = [
            "\\App\\Repositories\\Interfaces\\{$name}RepositoryInterface" => "\\App\\Repositories\\{$name}Repository",
            "\\App\\Services\\Interfaces\\{$name}ServiceInterface" => "\\App\\Services\\{$name}Service",
        ];
        $providerContent = $this->file->get($providerPath);
        $bindingCode = '';
        foreach ($bindings as $interface => $implementation) {
            $bindingCode .= "\n        "."\$this->app->bind($interface::class, $implementation::class);";
        }
        if (str_contains($providerContent, 'public function register()')) {
            $registerMethodStart = strpos($providerContent, 'public function register()');
            $openingBracePos = strpos($providerContent, '{', $registerMethodStart);
            if ($openingBracePos !== false) {
                $providerContent = substr_replace(
                    $providerContent,
                    $bindingCode,
                    $openingBracePos + 1,
                    0
                );
            }
        }
        $this->file->put($providerPath, $providerContent);
    }
}
