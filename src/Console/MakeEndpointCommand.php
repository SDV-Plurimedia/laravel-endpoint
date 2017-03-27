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
                            {version : The api version}
                            {--mongo : Generate a Laravel MongoDB Model (https://github.com/jenssegers/laravel-mongodb)}
                            {--module= : Generate under a namespace}';

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
        $name = $this->model();

        // Generate a model.
        $this->call('endpoint:make:model', [
            'name' => $name,
            '--mongo' => $this->option('mongo'),
            '--module' => $this->option('module'),
        ]);

        // Generate a repository.
        $this->call('endpoint:make:repository', [
            'name' => $name,
            '--module' => $this->option('module'),
        ]);

        // Generate a transformer.
        $this->call('endpoint:make:transformer', [
            'name' => $name,
            '--module' => $this->option('module'),
        ]);

        // Generate a controller.
        $this->call('endpoint:make:controller', [
            'name' => $name,
            'version' => $this->apiVersion(),
            '--module' => $this->option('module'),
        ]);

        $this->info('Endpoint created successfully');
        $this->info('Add the resource in your routes/api.php file.');
        $this->info("
            Route::resource('".$this->resource()."', '".$name."Controller', ['except' => [
                'create', 'edit'
            ]]);
        ");
    }

    /**
     * Returns the endpoint name.
     *
     * @return string
     */
    private function resource()
    {
        return str_plural(kebab_case(trim($this->argument('name'))));
    }

    /**
     * Returns the model name.
     *
     * @return string
     */
    private function model()
    {
        return trim($this->argument('name'));
    }

    /**
     * Returns the api version.
     *
     * @return string
     */
    private function apiVersion()
    {
        return strtoupper($this->argument('version'));
    }
}
