<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\Traits\ServiceProviderInjector;

class ServiceMakeCommand extends GeneratorCommand
{
    use ServiceProviderInjector;

    protected $signature = 'make:service {name}';
    protected $description = 'Create a new Service class';

    public function handle()
    {
        $codeToAdd = "\n\t\t\$this->app->bind(\n" .
                "\t\t\t\\App\\Interfaces\\" . str_replace('/', '\\', $this->argument('name')) . "Interface::class,\n" .
                "\t\t\t\\App\\Services\\" . str_replace('/', '\\', $this->argument('name')) . "::class\n" .
                "\t\t);\n";

        $appServiceProviderFile = app_path('Providers/AppServiceProvider.php');

        $this->injectCodeToRegisterMethod($appServiceProviderFile, $codeToAdd);

        Artisan::call('make:interface', [
            'name' => $this->argument('name') . 'Interface'
        ]);
        return parent::handle();
    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Services';
    }
}