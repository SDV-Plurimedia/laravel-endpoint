<?php

namespace Fab\Larapi\Console;

use Illuminate\Console\Command;

class MakeEndpointCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'larapi:make:endpoint
                            {name : The name of the endpoint}
                            {version : The api version}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new endpoint';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $name = trim($this->argument('name'));
        $apiVersion = strtoupper($this->argument('version'));

        // Generate a model.
        $this->call('make:model', [
            'name' => $name
        ]);

        // Generate a repository.
        $this->call('larapi:make:repository', [
            'name' => $name
        ]);

        // Generate a transformer.
        $this->call('larapi:make:transformer', [
            'name' => $name
        ]);

        // Generate a controller.
        $this->call('larapi:make:controller', [
            'name' => $name,
            'version' => $apiVersion
        ]);

        $this->info('Endpoint created successfully');
        $this->info('Add the resource in your routes/api.php file.');
        $this->info("
            Route::resource('resources', 'ResourceController', ['except' => [
                'create', 'edit'
            ]]);
        ");
    }
}
