<?php

namespace System\CrudGenerator\Commands;

use Illuminate\Console\GeneratorCommand;

class CrudRouteCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:route
                            {name : The name of the route.}
                            {--namespace= : The name of the schema.}
                            {--module-name= : The name of the schema.}
                            {--namespace= : The name of the schema.}
                            {--prefix= : prefix.}
                            {--title= : title.}
                            {--controller= : controller.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new route.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Route';

    
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/route.stub';
    }


    /**
     * Get the destination class path.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        return app_path('Modules').'/'.$this->option('module-name').'/routes.php';

    }

     /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {        
        return false;;
    }

    /**
     * Build the model class with the given name.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        
        $title      = $this->option('title');
        $name       = $this->argument('name');
        $prefix     = $this->option('prefix');
        $namespace  = $this->option('namespace');
        $controller = $this->option('controller');

        $aa =  $this->replaceTitle($stub, $title)
            ->replacePrefix($stub, $prefix)
            ->replaceNamespace($stub, $namespace)
            ->replaceController($stub, $controller)
            ->replaceClass($stub, 'routes.php');

        return $aa;
    }

    /**
     * Replace the schema_up for the given stub.
     *
     * @param  string  $stub
     * @param  string  $schemaUp
     *
     * @return $this
     */
    protected function replaceTitle(&$stub, $title)
    {
        $stub = str_replace(
            '{{title}}', $title, $stub
        );
        return $this;
    }

    /**
     * Replace the schema_up for the given stub.
     *
     * @param  string  $stub
     * @param  string  $schemaUp
     *
     * @return $this
     */
    protected function replacePrefix(&$stub, $prefix)
    {
        $stub = str_replace(
            '{{prefix}}', $prefix, $stub
        );
        return $this;
    }

     /**
     * Replace the schema_up for the given stub.
     *
     * @param  string  $stub
     * @param  string  $schemaUp
     *
     * @return $this
     */
    protected function replaceNamespace(&$stub, $namespace)
    {
        $stub = str_replace(
            '{{namespace}}', $namespace, $stub
        );
        return $this;
    }

    /**
     * Replace the schema_up for the given stub.
     *
     * @param  string  $stub
     * @param  string  $schemaUp
     *
     * @return $this
     */
    protected function replaceController(&$stub, $controller)
    {
        $stub = str_replace(
            '{{controller}}', $controller, $stub
        );
        return $this;
    }

   
}
