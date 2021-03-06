<?php

$app['debug'] = isset($_SERVER['PHP_WEB_DEBUG_ENABLED']) ? $_SERVER['PHP_WEB_DEBUG_ENABLED'] : true;

$app['mailer'] = $app->share(function () {
    return new \PHPMailer();
});

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => dirname(__DIR__) . '/views',
));

$app['db.pdo'] = $app->share(function() {


    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );
    $dbname = isset($_SERVER['PHP_WEB_DB_NAME']) ? $_SERVER['PHP_WEB_DB_NAME'] : 'sgc_web';
    $pass = isset($_SERVER['PHP_WEB_DB_PASSWORD']) ? $_SERVER['PHP_WEB_DB_PASSWORD'] : 'webadmin';
    $user = isset($_SERVER['PHP_WEB_DB_USERNAME']) ? $_SERVER['PHP_WEB_DB_USERNAME'] : 'webadmin';
    $pdo = new PDO('mysql:host=localhost;dbname=' . $dbname . ';', $user, $pass, $options);

    return $pdo;
});
$app['configs'] = $app->share(function($app) {
    return new \services\ConfigService($app['db.pdo']);
});

$app['models'] = $app->share(function($app) {
    return new \services\ModelService($app['db.pdo']);
});

$app['menu'] = $app->share(function ($app) {
    return new \services\MenuService($app['db.pdo']);
});
$app['carousel'] = $app->share(function($app) {
    return new \services\CarouselService();
});

$app['pluginService'] = $app->share(function($app) {
    return new \services\PluginService($app);
});



if (isset( $_SERVER['PATH_INFO']) && strpos($_SERVER['PATH_INFO'], '/admin/') !== FALSE) {
    require __DIR__ . '/admin_routing.php';
} else {
    require __DIR__ . '/site_routing.php';
}
