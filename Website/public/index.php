<?php
declare(strict_types=1);

use Sys\Core\Registry;
use Sys\Core\Router;
use Sys\Core\View;
use Sys\Library\Document;
use Sys\Library\Response;

date_default_timezone_set('Australia/Sydney');

const REQUIRED_PHP_VERSION = '8.2'; // This can be changed to match but must be 8+

if (version_compare(PHP_VERSION, REQUIRED_PHP_VERSION, '<')) {
    die(
        'Fatal Error: PHP Version ' . REQUIRED_PHP_VERSION . 
        ' or higher is required to run this application. Current version: ' . PHP_VERSION
    );
}

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(__DIR__));

define('APP_PATH', BASE_PATH . DS . 'app');
define('CONFIG_PATH', BASE_PATH . DS . 'config');
define('DB_PATH', BASE_PATH . DS . 'database');
define('PUBLIC_PATH', BASE_PATH . DS . 'public');
define('SYS_PATH', BASE_PATH . DS . 'sys');
define('STORAGE_PATH', BASE_PATH . DS . 'storage');

require_once SYS_PATH . DS . 'Core' . DS . 'Router.php';
require_once SYS_PATH . DS . 'Core' . DS . 'Controller.php';
require_once SYS_PATH . DS . 'Core' . DS . 'Model.php';
require_once SYS_PATH . DS . 'Library' . DS . 'Database.php';

spl_autoload_register(function ($class) {
    $baseDir = BASE_PATH . DS;

    $class = str_replace('\\', '/', $class);
    $file = $baseDir . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }

});
$registry = new Registry();

$document = new Document();
$registry->add('document', $document);

$view = new View(APP_PATH . DS . 'Views', $document);
$registry->add('view', $view);

$router = new Router($registry);

$router->add('GET', '/', 'App\Controllers\HomeController@index');

$router->add('GET', '/customer/login', 'App\Controllers\CustomerController@login');
$router->add('GET', '/customer/dashboard', 'App\Controllers\CustomerController@index');

$router->add('GET', '/staff/login', 'App\Controllers\StaffController@login');
// $router->add('POST', '/tasks/quick-add', 'App\Controllers\TaskController@quickAdd');

$response = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], );
if ($response instanceof Response) {
    $response->send();
} else {
    echo $response;
}