<?php

namespace App\Console\Commands;

use App\Models\FixtureEventType;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenerateFixtureEvent extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:fixture-event {name} {title?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate fixture event entry';

    /**
     * The class type.
     *
     * @var string
     */
    protected $type = 'Fixture Event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $created_event = null;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $key = Str::snake($this->argument('name'));

        $this->checkEventExists($key)->createEventType($key);

        parent::handle();
    }

    /**
     * Check if event exists.
     *
     * @return string
     */
    protected function checkEventExists($key)
    {
        $event_exists = FixtureEventType::where('key', $key)->count();

        if ($event_exists) {
            $this->error('Event type already exists!');
            exit;
        }

        return $this;
    }

    /**
     * Create new event type.
     *
     * @return string
     */
    protected function createEventType($type)
    {
        $event_type = new FixtureEventType;
        $event_type->name = $this->argument('title') ?? $this->argument('name');
        $event_type->key = $type;
        $event_type->class = 'App\Fixtures\EventType\\'.str_replace(' ', '', $this->argument('name'));
        $event_type->save();

        return $this;
    }

    /**
     * Replace the filename.
     *
     * @param string $stub
     * @return string
     */
    protected function replaceFilename(&$stub)
    {
        $stub = str_replace(
            'DummyFilename',
            $this->argument('name'),
            $stub
        );

        return $stub;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $config = $this->laravel['config'];

        return $config->get('fixtureevents.stub')
            ? base_path().$config->get('fixtureevents.stub')
            : __DIR__.'../../Fixtures/Stubs/FixtureEventType.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\'.$this->laravel['config']->get('fixtureevents.namespace.base', 'Fixtures\EventType');
    }
}
