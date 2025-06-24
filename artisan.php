<?php
class Artisan {
    
    public function run($argv) {
        if (count($argv) < 2) {
            $this->showHelp();
            return;
        }
        
        $command = $argv[1];
        
        switch ($command) {
            case 'make:controller':
                if (isset($argv[2])) {
                    $this->makeController($argv[2]);
                } else {
                    echo "Error: Controller name is required.\n";
                    echo "Usage: php artisan make:controller <name>\n";
                }
                break;
                
            case 'make:model':
                if (isset($argv[2])) {
                    $this->makeModel($argv[2]);
                } else {
                    echo "Error: Model name is required.\n";
                    echo "Usage: php artisan make:model <name>\n";
                }
                break;
                
            case 'serve':
                $this->serve();
                break;
                
            case 'help':
            case '--help':
            case '-h':
                $this->showHelp();
                break;
                
            default:
                echo "Unknown command: $command\n";
                $this->showHelp();
                break;
        }
    }
    
    private function makeController($name) {
        if (!is_dir('controllers')) {
            mkdir('controllers', 0755, true);
            echo "Created controllers directory.\n";
        }
        
        // Add Controller suffix if not present
        $className = $name;
        if (!str_ends_with($name, 'Controller')) {
            $className = $name . 'Controller';
        }
        
        $filename = "controllers/{$className}.php";
        
        if (file_exists($filename)) {
            echo "Error: Controller {$className} already exists!\n";
            return;
        }
        
        $template = $this->getControllerTemplate($className);
        
        if (file_put_contents($filename, $template)) {
            echo "Controller created successfully: {$filename}\n";
        } else {
            echo "Error: Could not create controller file.\n";
        }
    }
    
    private function makeModel($name) {
        if (!is_dir('models')) {
            mkdir('models', 0755, true);
            echo "Created models directory.\n";
        }
        
        $className = $name;
        $filename = "models/{$className}.php";
        
        if (file_exists($filename)) {
            echo "Error: Model {$className} already exists!\n";
            return;
        }
        
        $tableName = strtolower($this->pluralize($name));
        
        $template = $this->getModelTemplate($className, $tableName);
        
        if (file_put_contents($filename, $template)) {
            echo "Model created successfully: {$filename}\n";
        } else {
            echo "Error: Could not create model file.\n";
        }
    }
    
    private function serve() {
        $host = '127.0.0.1';
        $port = '8000';
        $docroot = 'public';
        
        if (!is_dir($docroot)) {
            echo "Error: Public directory not found!\n";
            return;
        }
        
        echo "Starting PHP development server...\n";
        echo "Server running at: http://{$host}:{$port}\n";
        echo "Document root: {$docroot}\n";
        echo "Press Ctrl+C to stop the server.\n\n";
        
        $command = "cd {$docroot} && php -S {$host}:{$port}";
        passthru($command);
    }

    private function getControllerTemplate($className) {
        return "<?php
require_once \"../app/Controller.php\";

class {$className} extends Controller {
    public function index() {
        
    }
}
";
    }
    
    private function getModelTemplate($className, $tableName) {
        return "<?php
require_once \"../app/Model.php\";

class {$className} extends Model {
    protected \$table = \"{$tableName}\";
}
";
    }
    
    private function pluralize($word) {
        $word = strtolower($word);
        
        if (str_ends_with($word, 'y')) {
            return substr($word, 0, -1) . 'ies';
        } elseif (str_ends_with($word, 's') || str_ends_with($word, 'x') || str_ends_with($word, 'z') || 
                  str_ends_with($word, 'ch') || str_ends_with($word, 'sh')) {
            return $word . 'es';
        } else {
            return $word . 's';
        }
    }
    
    private function showHelp() {
        echo "\n";
        echo "PHP Artisan - Command Line Tool\n";
        echo "================================\n\n";
        echo "Usage:\n";
        echo "  php artisan <command> [arguments]\n\n";
        echo "Available commands:\n";
        echo "  make:controller <name>    Create a new controller\n";
        echo "  make:model <name>         Create a new model\n";
        echo "  serve                     Start the PHP development server\n";
        echo "  help                      Show this help message\n\n";
        echo "Examples:\n";
        echo "  php artisan make:controller User\n";
        echo "  php artisan make:controller UserController\n";
        echo "  php artisan make:model User\n";
        echo "  php artisan serve\n\n";
    }
}

$artisan = new Artisan();
$artisan->run($argv);