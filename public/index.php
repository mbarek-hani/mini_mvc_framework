<?php
declare(strict_types= 1);

require "../vendor/autoload.php";

use App\Controllers\HomeController;
use Core\Router;

$router = new Router();
$controller = new HomeController();

echo $controller->index();