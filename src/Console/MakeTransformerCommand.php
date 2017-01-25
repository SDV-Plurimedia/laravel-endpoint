<?php

namespace SdV\Larapi\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;

class MakeTransformerCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'larapi:make:transformer {name : The name of the model}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new transformer class.';
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
    * Create a new Endpoint creator command instance.
    *
    * @param  \Illuminate\Filesystem\Filesystem  $files
    * @return void
    */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);

        $this->files = $files;
    }
    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $name = $this->qualifyClass($this->getNameInput());

        // Generate a repository.
        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info('Transformer class created successfully.');
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/transformer.stub';
    }
    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            'DummyNamespace',
            $this->getNamespace($name).'\\Transformers',
            $stub
        );

        return $this;
    }
    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $modelWithoutNamespace = str_replace($this->getNamespace($name).'\\', '', $name);
        $stub = str_replace('Dummy', $modelWithoutNamespace, $stub);
        $stub = str_replace('dummyInstance', strtolower($modelWithoutNamespace), $stub);

        return $stub;
    }
    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace_first($this->laravel->getNamespace(), '', $name);

        $name = 'Transformers\\' . $name;

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'Transformer.php';
    }
}
