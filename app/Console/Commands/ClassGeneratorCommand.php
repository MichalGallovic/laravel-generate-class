<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ClassGeneratorCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate class example';

    /**
     * Get the stub file for the generator.
     * 
     * @param string
     * @return string
     */
    protected function getStub()
    {
        return base_path('resources/stubs/ExampleClass.stub');
    }

    /**
     * Get the console command arguments.
     * 
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputOption::VALUE_REQUIRED, 'The name of the class'],
            ['method', InputOption::VALUE_REQUIRED, 'The name of the method']
        ];
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $method = $this->argument('method');

        return $this->replaceNamespace($stub, $name)
                ->replaceMethodName($stub, $method)
                ->replaceClass($stub, $name);
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
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('ExampleClass', $class, $stub);
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
        $stub = str_replace('ExampleNamespace', $this->getNamespace($name), $stub);

        return $this;
    }

    /**
     * Replace the method name for the given stub.
     *
     * @param  string $stub
     * @param  string $method
     * @return $this
     */
    protected function replaceMethodName(&$stub, $method)
    {
        $stub = str_replace('exampleMethodName', $method, $stub);

        return $this;
    }
}
