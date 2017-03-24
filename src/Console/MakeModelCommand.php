<?php

namespace SdV\Endpoint\Console;

class MakeModelCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'endpoint:make:model
                            {name : The name of the model}
                            {--mongo : Generate a Laravel MongoDB Model (https://github.com/jenssegers/laravel-mongodb)}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = '';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('mongo')) {
            return __DIR__.'/stubs/model-mongodb.stub';
        }

        return __DIR__.'/stubs/model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }
}
