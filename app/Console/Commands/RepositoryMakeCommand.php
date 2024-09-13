<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:repository-make-command';
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    protected $type = 'Repository';

    protected function getStub()
    {
        return __DIR__.'/stubs/repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        //注意儲存的目錄,我這裡把Repository目錄放在了Http下,可以根據自己的習慣自定義
        return $rootNamespace.'\Repositories';
    }

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     //
    // }
}
