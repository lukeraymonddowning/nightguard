<?php


namespace Lukeraymonddowning\Nightshift\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateAuthCommand extends Command
{
    protected $signature = "nightguard:model {model}";
    protected $description = "Creates a new authenticatable model and migration.";

    public function handle()
    {
        File::put(database_path("migrations/{$this->migrationName()}"), $this->migrationStub());
        File::put(app_path("Models/{$this->className()}.php"), $this->modelStub());

        $this->info("Your new {$this->className()} awaits!");
        $this->info("Migration: database/migrations/{$this->migrationName()}");
        $this->info("Model: app/Models/{$this->className()}");
        $this->alert("Don't forget to add your service provider binding!");
    }

    protected function migrationName()
    {
        return now()->format('Y_m_d') . "_000000_create_" . $this->tableName() . "_table.php";
    }

    protected function tableName()
    {
        return Str::of($this->argument('model'))->plural()->snake();
    }

    protected function migrationStub()
    {
        return Str::of(file_get_contents(__DIR__ . '/../../stubs/create_auth_table.php.stub'))
            ->replace("__CLASS_NAME__", Str::studly("create_{$this->tableName()}_table"))
            ->replace("__TABLE_NAME__", $this->tableName())
            ->__toString();
    }

    protected function className()
    {
        return Str::of($this->argument('model'))->singular()->studly();
    }

    protected function modelStub()
    {
        return Str::of(file_get_contents(__DIR__ . '/../../stubs/AuthModel.php.stub'))
            ->replace("__CLASS_NAME__", $this->className())
            ->__toString();
    }
}
