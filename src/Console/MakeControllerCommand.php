<?php

namespace SdV\Endpoint\Console;

class MakeControllerCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'endpoint:make:controller
                            {name : The name of the model}
                            {version : The api version}
                            {--module= : Generate under a namespace}';
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
     * Get the default Type namespace.
     *
     * @return string
     */
    protected function getTypeNamespace()
    {
        $apiVersion = $this->getApiVersionInput();

        return 'Http\Controllers\Api\\'.$apiVersion;
    }

    /**
     * Get the api version.
     *
     * @return string
     */
    protected function getApiVersionInput()
    {
        return strtoupper(trim($this->argument('version')));
    }
}
