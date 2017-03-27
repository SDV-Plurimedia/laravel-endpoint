<?php

namespace SdV\Endpoint\Console;

class MakeTransformerCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'endpoint:make:transformer
                                                {name : The name of the model}
                                                {--module= : Generate under a namespace}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new transformer class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Transformer';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/transformer.stub';
    }
}
