<?php

namespace Mrtolouei\Structify\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\TestCase;

class MakeMdsrCommandTest extends TestCase
{
    /**
     * Test the structify:make-mdsr command.
     *
     * @return void
     */
    public function test_make_mdsr_command()
    {
        // Run the command
        Artisan::call('structify:make-mdsr', ['name' => 'TestEntity']);

        // Assert that files were created
        $this->assertTrue(File::exists(app_path('Models/TestEntity.php')));
        $this->assertTrue(File::exists(app_path('Dto/TestEntityDto.php')));
        $this->assertTrue(File::exists(app_path('Repositories/Interfaces/TestEntityRepositoryInterface.php')));
        $this->assertTrue(File::exists(app_path('Repositories/TestEntityRepository.php')));
        $this->assertTrue(File::exists(app_path('Services/Interfaces/TestEntityServiceInterface.php')));
        $this->assertTrue(File::exists(app_path('Services/TestEntityService.php')));

        // Clean up
        File::delete([
            app_path('Models/TestEntity.php'),
            app_path('Dto/TestEntityDto.php'),
            app_path('Repositories/Interfaces/TestEntityRepositoryInterface.php'),
            app_path('Repositories/TestEntityRepository.php'),
            app_path('Services/Interfaces/TestEntityServiceInterface.php'),
            app_path('Services/TestEntityService.php'),
        ]);
    }
}
