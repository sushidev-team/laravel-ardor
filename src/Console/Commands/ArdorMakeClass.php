<?php

namespace AMBERSIVE\Ardor\Console\Commands;

use Illuminate\Console\Command;

use Str;
use File;

use Carbon\Carbon;

use Illuminate\Console\GeneratorCommand;

class ArdorMakeClass extends GeneratorCommand
{

    private String $classType;

    private array $allowed = ['bundler', 'contract'];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ardor:make {name} {--type= : bundler|contrat}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will run all your bundler/contract classes.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if (! $this->hasOption('type') || $this->option('type') === null || !in_array($this->option('type'), $this->allowed)) {
            $this->error("A valid type must be provied!");
            return;
        }

        $this->classType = $this->option('type');

        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($name);
        
        if ((! $this->hasOption('force') ||
             ! $this->option('force')) &&
             $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);


        $this->files->put($path, $this->sortImports($this->buildClassCustom($name, $this->classType)));

        $this->info($this->type.' created successfully (data class and blade file).');

    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClassCustom(String $name, String $stubname)
    {
        $stub = $this->files->get($this->getStubFilePath($stubname));

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace():String
    {
        return $this->laravel->getNamespace().(ucfirst(Str::plural($this->classType)));
    }

    /**
     * Returns the path to the stubs folder
     */
    protected function getStub(): String {
        return __DIR__."/../../Stubs/";
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStubFilePath(String $stubname):String
    {
        return $this->getStub()."${stubname}.stub";
    }
    
    /**
     * Returns the path for the document class
     *
     * @param  mixed $name
     * @return String
     */
    protected function getPath($name):String {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $type = ucfirst(Str::plural($this->classType));
        return $this->getPathFolder($name, "app/${type}");
    }


        
    /**
     * Returns the base path for the file
     *
     * @param  mixed $name
     * @param  mixed $folder
     * @return String
     */
    protected function getPathFolder(String $name, String $folder = ''): String {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $type = ucfirst($this->classType);
        return base_path($folder.str_replace('\\', '/', $name."${type}").".php");
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
        
        $bladename = strtolower(str_replace("\\", ".", str_replace($this->rootNamespace()."\\", "printables.", $name)));

        $stub = str_replace(
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyUserModel', 'DummyBladeName'],
            [$this->getNamespace($name), $this->rootNamespace(), $this->userProviderModel()],
            $stub
        );

        return $this;
    }

}
