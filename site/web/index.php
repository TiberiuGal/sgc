<?php
$path = isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : $_SERVER["REQUEST_URI"];

if( substr($path, 0, 10 ) == '/index.php') {
    $path = substr($path, 10);
}
$_SERVER['REQUEST_URI'] = $path;
// web/index.php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();


require_once  __DIR__ . '/../libs/bootstrap.php';

$app->run();


