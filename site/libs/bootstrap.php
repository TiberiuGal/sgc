<?php



use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
    'admin' => array(
        'pattern' => '^/admin',
        'http' => true,
        'users' => array(
            // raw password is foo
            'adsmin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
        ),
    ),
)
));

$app['debug'] = true;
$app['products'] = $app->share(function () { return new \ProductService(); });
$app['gallery'] = $app->share(function () { return new \ImageGalleryService(); });
$app['mailer'] = $app->share(function () { return new \PHPMailer(); });


$app['db.pdo'] = $app->share(function(){
    
    
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ); 
    $dbname = isset($_SERVER['PHP_WEB_DB_NAME']) ? $_SERVER['PHP_WEB_DB_NAME'] : 'sgc';
    $pass = isset($_SERVER['PHP_WEB_DB_PASSWORD']) ? $_SERVER['PHP_WEB_DB_PASSWORD'] : 'root';
    $user = isset($_SERVER['PHP_WEB_DB_USERNAME']) ? $_SERVER['PHP_WEB_DB_USERNAME'] : 'root';
    $pdo = new PDO('mysql:host=localhost;dbname=' .$dbname. ';', $user, $pass, $options );
    
    return $pdo;
});
    
$app['security.access_rules'] = array(
    array('^/admin', 'ROLE_ADMIN', 'http'),
    array('^.*$', 'ROLE_USER'),
);
$app['contactsrv'] = $app->share(function () { return new \ContactService(); });

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => dirname(__DIR__) . '/views',
));


$app->get('/', 'controllers\IndexController::indexAction');
$app->get('/info', function(){phpinfo();});
$app->get('/produse', 'controllers\IndexController::productsAction');
$app->get('/produse/{name}', 'controllers\IndexController::productAction');
$app->get('/despre', 'controllers\IndexController::aboutAction');
$app->get('/disponibilitate', 'controllers\IndexController::disponibilitateAction');
$app->get('/contact', 'controllers\ContactController::contactAction');
$app->post('/contact', 'controllers\ContactController::contactSentAction');

$app->get('/admin/articles', 'controllers\AdminController::articlesAction');
$app->get('/admin/', 'controllers\AdminController::indexAction');
$app->get('/admin/edit-article/{articleId}', 'controllers\AdminController::editArticleAction');
$app->post('/admin/edit-article', 'controllers\AdminController::saveArticleAction');
$app->get('/admin/edit-menu/{menuId}', 'controllers\AdminController::editMenuAction');
$app->get('/admin/edit-menu', 'controllers\AdminController::editMenu2Action');
$app->post('/admin/menu_save', 'controllers\AdminController::menuSaveAction');

