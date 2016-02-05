<?php

use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app['debug'] = isset($_SERVER['PHP_WEB_DEBUG_ENABLED'] ) ? $_SERVER['PHP_WEB_DEBUG_ENABLED'] : true; 

$app['gallery'] = $app->share(function () {
    return new \ImageGalleryService();
});
$app['mailer'] = $app->share(function () {
    return new \PHPMailer();
});

$app->register(new Silex\Provider\SessionServiceProvider());

$app['db.pdo'] = $app->share(function() {


    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );
    $dbname = isset($_SERVER['PHP_WEB_DB_NAME']) ? $_SERVER['PHP_WEB_DB_NAME'] : 'sgc';
    $pass = isset($_SERVER['PHP_WEB_DB_PASSWORD']) ? $_SERVER['PHP_WEB_DB_PASSWORD'] : 'root';
    $user = isset($_SERVER['PHP_WEB_DB_USERNAME']) ? $_SERVER['PHP_WEB_DB_USERNAME'] : 'root';
    $pdo = new PDO('mysql:host=localhost;dbname=' . $dbname . ';', $user, $pass, $options);

    return $pdo;
});

$app['menu'] = $app->share(function ($app) {
    return new \MenuService($app['db.pdo']);
});
$app['articles'] = $app->share(function ($app) {
    return new \ArticleService($app['db.pdo']);
});

$app['contactsrv'] = $app->share(function () {
    return new \ContactService();
});

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => dirname(__DIR__) . '/views',
));

if (strpos($_SERVER['PATH_INFO'], '/admin/') !== FALSE) {
    require __DIR__ . '/admin_routing.php';
} else {
    require __DIR__ . '/site_routing.php';
}
