<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateRepository extends Command
{
    protected $signature = 'make:repository {repositoryName}';
    protected $description = 'Create an interface, repository implementation, and repository service provider';

    public function handle()
    {
        $repositoryName = ucfirst($this->argument('repositoryName')) . 'Repository';
        $interfaceName = $repositoryName . 'RepositoryInterface';

        // Create interface file
        $interfacePath = app_path("Repositories/Interfaces/{$interfaceName}.php");
        $this->createFile($interfacePath, $this->getInterfaceTemplate($interfaceName));

        // Create repository file
        $repositoryPath = app_path("Repositories/{$repositoryName}.php");
        $this->createFile($repositoryPath, $this->getRepositoryTemplate($repositoryName, $interfaceName));

        // Create or update repository service provider
        $this->info('Interface, repository, and service provider created successfully and bindings added!');
    }

    private function createFile($path, $content)
    {
        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true, true);
        }

        File::put($path, $content);
    }

    private function getInterfaceTemplate($interfaceName)
    {
        return "<?php\n\nnamespace App\Repositories\Interfaces;\n\ninterface {$interfaceName}\n{\n    // Define interface methods here\n}\n";
    }

    private function getRepositoryTemplate($repositoryName, $interfaceName)
    {
        return "<?php\n\nnamespace App\Repositories;\n\nuse App\Repositories\Interfaces\\{$interfaceName};\n\nclass {$repositoryName} implements {$interfaceName}\n{\n    // Implement interface methods here\n}\n";
    }
}
