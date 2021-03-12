<?php


namespace Lukeraymonddowning\Nightguard\Tests;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CreateAuthCommandTest extends TestCase
{

    /** @test */
    public function it_creates_a_migration_with_the_expected_columns()
    {
        $expectedContents = file_get_contents(__DIR__ . '/../stubs/create_auth_table.php.stub');
        $expectedContents = str_replace("__CLASS_NAME__", 'CreateAdministratorsTable', $expectedContents);
        $expectedContents = str_replace("__TABLE_NAME__", 'administrators', $expectedContents);

        File::partialMock()
            ->shouldReceive('put')
            ->once()
            ->with(
                database_path('migrations/' . now()->format('Y_m_d') . '_000000_create_administrators_table.php'),
                $expectedContents
            );

        Artisan::call('nightguard:model Administrator');
    }

    /** @test */
    public function the_migration_can_handle_bad_input()
    {
        $expectedContents = file_get_contents(__DIR__ . '/../stubs/create_auth_table.php.stub');
        $expectedContents = str_replace("__CLASS_NAME__", 'CreateAdministratorsTable', $expectedContents);
        $expectedContents = str_replace("__TABLE_NAME__", 'administrators', $expectedContents);

        File::partialMock()
            ->shouldReceive('put')
            ->once()
            ->with(
                database_path('migrations/' . now()->format('Y_m_d') . '_000000_create_administrators_table.php'),
                $expectedContents
            );

        Artisan::call('nightguard:model administrators');
    }

    /** @test */
    public function it_creates_a_model_with_the_expected_contents()
    {
        $expectedContents = file_get_contents(__DIR__ . '/../stubs/AuthModel.php.stub');
        $expectedContents = str_replace("__CLASS_NAME__", 'Administrator', $expectedContents);

        File::partialMock()
            ->shouldReceive('put')
            ->once()
            ->with(
                app_path('Models/Administrator.php'),
                $expectedContents
            );

        Artisan::call('nightguard:model Administrator');
    }

    /** @test */
    public function the_model_can_handle_bad_input()
    {
        $expectedContents = file_get_contents(__DIR__ . '/../stubs/AuthModel.php.stub');
        $expectedContents = str_replace("__CLASS_NAME__", 'Administrator', $expectedContents);

        File::partialMock()
            ->shouldReceive('put')
            ->once()
            ->with(
                app_path('Models/Administrator.php'),
                $expectedContents
            );

        Artisan::call('nightguard:model administrators');
    }

}
