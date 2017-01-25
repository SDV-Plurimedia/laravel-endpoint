<?php

namespace Fab\Larapi\Console;

class MakeControllerCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'larapi:make:controller
                            {name : The name of the model}
                            {version : The api version}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/controller.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $apiVersion = $this->getApiVersionInput();

        return $rootNamespace.'\Http\Controllers\Api\\'.$apiVersion;
    }

    protected function getApiVersionInput()
    {
        return strtoupper(trim($this->argument('version')));
    }
}
