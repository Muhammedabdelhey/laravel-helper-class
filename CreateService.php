<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateService extends Command
{
    protected $signature = 'make:service {ServiceName}';
    protected $description = 'Create Service class ';

    public function handle()
    {
        $ServiceName = ucfirst($this->argument('ServiceName')) . 'Service';
        // Create Service file
        $ServicePath = app_path("Services/{$ServiceName}.php");
        $this->createFile($ServicePath,$this->getServiceTemplate($ServiceName));

        // Create or update Service service provider
        $this->info(" {$ServiceName}  created successfully and bindings added!");
    }

    private function createFile($path, $content)
    {
        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true, true);
        }

        File::put($path, $content);
    }
    private function getServiceTemplate($ServiceName)
    {
        return "<?php\n\nnamespace App\Services;\n\nclass {$ServiceName}\n{\n    // Implement interface methods here\n}\n";
    }
}
