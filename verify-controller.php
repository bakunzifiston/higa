 <?php
require 'vendor/autoload.php';
require 'app/Http/Controllers/ModuleController.php';

$rc = new ReflectionClass(App\Http\Controllers\ModuleController::class);
echo "Public methods in ModuleController:\n";
foreach ($rc->getMethods(ReflectionMethod::IS_PUBLIC) as $m) {
    if ($m->class === 'App\Http\Controllers\ModuleController') {
        echo "  - " . $m->getName() . "\n";
    }
}
echo "\nHas edit(): " . ($rc->hasMethod('edit') ? 'YES' : 'NO') . "\n";
