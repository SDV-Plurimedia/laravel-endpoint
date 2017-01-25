<?php

namespace Fab\Endpoint\Console;

class MakeRepositoryCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'endpoint:make:repository {name : The name of the model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }
}
