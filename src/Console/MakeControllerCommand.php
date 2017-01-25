<?php

namespace SdV\Larapi\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;

class MakeControllerCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'larapi:make:controller {name : The name of the model} {version : The api version}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class.';
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * The api version
     *
     * @var string
     */
    protected $apiVersion;
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
        $this->apiVersion = strtoupper($this->argument('version'));

        // Generate a controller.
        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info('Controller class created successfully.');
    }
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
            $this->getNamespace($name).'\\Http\\Controllers\\Api\\'.$this->apiVersion,
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
        $stub = str_replace('Dummyy', $modelWithoutNamespace, $stub);
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

        $name = 'Http\\Controllers\\Api\\'.$this->apiVersion.'\\' . $name;

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'Controller.php';
    }
}
