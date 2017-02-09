<?php

namespace SdV\Endpoint\Console;

use Illuminate\Console\Command;

class MakeEndpointCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'endpoint:make:all
                            {name : The name of the endpoint}
                            {version : The api version}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new endpoint. (Model, Repository, Transformer, Controller)';

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
        $this->call('endpoint:make:model', [
            'name' => $name
        ]);

        // Generate a repository.
        $this->call('endpoint:make:repository', [
            'name' => $name
        ]);

        // Generate a transformer.
        $this->call('endpoint:make:transformer', [
            'name' => $name
        ]);

        // Generate a controller.
        $this->call('endpoint:make:controller', [
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
