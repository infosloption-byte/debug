<?php

namespace System\CrudGenerator\Commands;

use File;
use Illuminate\Console\Command;

class CrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generate
                            {name : The name of the Crud.}
                            {--fields= : Fields name for the form & migration.}
                            {--fields_from_file= : Fields from a json file.}
                            {--validations= : Validation details for the fields.}
                            {--controller-namespace= : Namespace of the controller.}
                            {--model-namespace= : Namespace of the model inside "app" dir.}
                            {--pk=id : The name of the primary key.}
                            {--pagination=25 : The amount of models per page for index pages.}
                            {--indexes= : The fields to add an index to.}
                            {--foreign-keys= : The foreign keys for the table.}
                            {--relationships= : The relationships for the model.}
                            {--route=yes : Include Crud route to routes.php? yes|no.}
                            {--route-group= : Prefix of the route group.}
                            {--view-path= : The name of the view path.}
                            {--localize=no : Allow to localize? yes|no.}
                            {--locales=en : Locales language type.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Crud including controller, model, views & migrations.';

    /** @var string  */
    protected $routeName = '';

    /** @var string  */
    protected $controller = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name                = $this->argument('name');
        $moduleName          = ucfirst($name).'Management';
        $modelName           = str_plural($name);
        $migrationName       = str_plural(snake_case($name));
        $tableName           = $migrationName;
        $routeGroup          = $this->option('route-group');         
        $routeName           = ($routeGroup) ? $routeGroup . '/' . snake_case($name, '-') : snake_case($name, '-');
        $perPage             = intval($this->option('pagination'));        
        $controllerNamespace = $this->option('controller-namespace');
        $modelNamespace      = $this->option('model-namespace');
        $fields              = rtrim($this->option('fields'), ';');
        $this->routeName     = $routeName;

        if ($this->option('fields_from_file')) {
            $fields = $this->processJSONFields($this->option('fields_from_file'));
        }

        $primaryKey = $this->option('pk');
        $viewPath = app_path('Modules'.'/'.$this->option('controller-namespace').'/'.'Views');

        $foreignKeys = $this->option('foreign-keys');

        if ($this->option('fields_from_file')) {
            $foreignKeys = $this->processJSONForeignKeys($this->option('fields_from_file'));
        }

        $fieldsArray = explode(';', $fields);
        $fillableArray = [];

        foreach ($fieldsArray as $item) {
            $spareParts = explode('#', trim($item));
            $fillableArray[] = $spareParts[0];
        }

        $commaSeparetedString = implode("', '", $fillableArray);
        $fillable = "['" . $commaSeparetedString . "']";

        $localize = $this->option('localize');
        $locales = $this->option('locales');

        $indexes = $this->option('indexes');
        $relationships = $this->option('relationships');

        $validations = trim($this->option('validations'));


        $this->call('crud:route',[
            'name'         => $controllerNamespace, 
            '--module-name'=> $controllerNamespace, 
            '--namespace'  => $controllerNamespace, 
            '--prefix'     => $routeGroup, 
            '--title'      => str_plural(snake_case($name)), 
            '--controller' => $name .'Controller'          
        ]);
        
        $this->call('crud:controller', [
            'name'                   => $name .'Controller', 
            '--module-name'          => $moduleName, 
            '--crud-name'            => $name, 
            '--model-name'           => $modelName, 
            '--controller-namespace' => $controllerNamespace, 
            '--model-namespace'      => $controllerNamespace, 
            '--view-path'            => $viewPath, 
            '--route-group'          => $routeGroup, 
            '--pagination'           => $perPage, 
            '--fields'               => $fields, 
            '--validations'          => $validations
        ]);

        $this->call('crud:logic', [
            'name'                   => $name .'Logic', 
            '--module-name'          => $moduleName, 
            '--crud-name'            => $name, 
            '--model-name'           => $modelName, 
            '--controller-namespace' => $controllerNamespace, 
            '--model-namespace'      => $controllerNamespace, 
            '--view-path'            => $viewPath, 
            '--route-group'          => $routeGroup, 
            '--pagination'           => $perPage, 
            '--fields'               => $fields, 
            '--validations'          => $validations
        ]);

        $this->call('crud:model', [
            'name'              => $modelNamespace, 
            '--model-namespace' => $controllerNamespace, 
            '--fillable'        => $fillable, 
            '--table'           => $tableName, 
            '--pk'              => $primaryKey, 
            '--relationships'   => $relationships
        ]);

        $this->call('crud:view', [
            'name' => $name, 
            '--namespace' => $controllerNamespace, 
            '--fields' => $fields, 
            '--validations' => $validations, 
            '--view-path' => $viewPath, 
            '--route-group' => $routeGroup, 
            '--localize' => $localize, 
            '--pk' => $primaryKey
        ]);
        

        // $this->call('crud:migration', ['name' => $migrationName, '--schema' => $fields, '--pk' => $primaryKey, '--indexes' => $indexes, '--foreign-keys' => $foreignKeys]);
       

        if ($localize == 'yes') {
            $this->call('crud:lang', ['name' => $name, '--fields' => $fields, '--locales' => $locales]);
        }
        // For optimizing the class loader
        $this->callSilent('optimize');

        
    }

    /**
     * Add routes.
     *
     * @return  array
     */
    protected function addRoutes()
    {
        return ["Route::resource('" . $this->routeName . "', '" . $this->controller . "');"];
    }

    /**
     * Process the JSON Fields.
     *
     * @param  string $file
     *
     * @return string
     */
    protected function processJSONFields($file)
    {
        //$json = File::get($file);
        $fields = json_decode($file);
    
        $fieldsString = '';
        foreach ($fields->fields as $field) {
           
            if ($field->type == 'select') {
                $fieldsString .= $field->name . '#' . $field->type . '#options=' . implode(',', $field->options) . ';';
            } else {
                $fieldsString .= $field->name . '#' . $field->type . ';';
            }
        }

        $fieldsString = rtrim($fieldsString, ';');

        return $fieldsString;
    }

    /**
     * Process the JSON Foreign keys.
     *
     * @param  string $file
     *
     * @return string
     */
    protected function processJSONForeignKeys($file)
    {
        //$json = File::get($file);
        $fields = json_decode($file);

        if (! property_exists($fields, 'foreign_keys')) {
            return '';
        }

        $foreignKeysString = '';
        foreach ($fields->foreign_keys as $foreign_key) {
            $foreignKeysString .= $foreign_key->column . '#' . $foreign_key->references . '#' . $foreign_key->on;

            if (property_exists($foreign_key, 'onDelete')) {
                $foreignKeysString .= '#' . $foreign_key->onDelete;
            }

            if (property_exists($foreign_key, 'onUpdate')) {
                $foreignKeysString .= '#' . $foreign_key->onUpdate;
            }

            $foreignKeysString .= ',';
        }

        $foreignKeysString = rtrim($foreignKeysString, ',');

        return $foreignKeysString;
    }



    //MODULE MAKING
    protected function generate($type) 
    {
        switch ($type) {
            case 'controller':
                $filename = studly_case($this->getNameInput()).ucfirst($type);
                break;

            case 'model':
                $filename = studly_case($this->modelNamespace);
                break;

            case 'view':
                $filename = 'index.blade';
                break;
                
            case 'business-logic':
                $folder   = 'BusinessLogics\\';
                $filename = studly_case($this->modelNamespace).'Logic';
                break;
            
            case 'routes':
                $filename = 'routes';
                break;

            case 'helper':
                $filename = 'helper';
                break;
        }

        if( ! isset($folder)) 
            $folder = ($type != 'routes' && $type != 'helper') ? ucfirst($type).'s\\'. ($type === 'translation' ? 'en\\':'') : '';

        $qualifyClass = method_exists($this, 'qualifyClass') ? 'qualifyClass' : 'parseName';
        $name = $this->$qualifyClass('Modules\\'.studly_case(ucfirst($this->getNameInput())).'\\'.$folder.$filename);

        if ($this->files->exists($path = $this->getPath($name)))
            return $this->error($this->type.' already exists!');

        $this->currentStub = __DIR__.'/stubs/'.$type.'.stub';

        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));
    }

    /**
     * Get the full namespace name for a given class.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        $name = str_replace('\\routes\\', '\\', $name);
        return trim(implode('\\', array_map('ucfirst', array_slice(explode('\\', studly_case($name)), 0, -1))), '\\');
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        return $this->replaceName($stub, $this->getNameInput())->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Replace the name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceName(&$stub, $name)
    {
        $stub = str_replace('DummyTitle', $name, $stub);
        $stub = str_replace('DummyUCtitle', ucfirst(studly_case($name)), $stub);
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
        $class = class_basename($name);
        return str_replace('DummyClass', $class, $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->currentStub;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            ['name', InputArgument::REQUIRED, 'Module name.'],
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            ['no-migration', null, InputOption::VALUE_NONE, 'Do not create new migration files.'],
            ['no-translation', null, InputOption::VALUE_NONE, 'Do not create module translation filesystem.'],
        );
    }
}
