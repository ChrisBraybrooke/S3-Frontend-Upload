<?php

namespace ChrisBraybrooke\Helpers\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeModelResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model-api {names* : The name(s) of the models} {--p|pivot}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a model api resource with all the required files.';

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
        $names = $this->argument('names');
        $pivot = $this->option('pivot') ?: false;

        foreach ($names as $key => $name) {
            $namePlural = Str::plural($name);
            $modelName = $name;
            if ($pivot) {
                $modelName = "Pivots/{$name}";
            }
            $this->call('make:model', ['name' => $modelName, '--migration' => true, '--pivot' => $pivot]);
            $this->call('make:controller', ['name' => "Api/{$namePlural}Controller", '--api' => true, '--model' => $name]);
            $this->call('make:resource', ['name' => $name]);
            $this->call('make:policy', ['name' => "{$name}Policy", '--model' => $name]);
            $this->call('make:request', ['name' => "{$name}CreateRequest"]);
            $this->call('make:request', ['name' => "{$name}UpdateRequest"]);
        }
    }
}
