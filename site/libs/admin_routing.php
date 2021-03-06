<?php

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/admin',
            'http' => true,
            'users' => array(
                // raw password is foo
                (isset($_SERVER['PHP_WEB_ADMIN_USER']) ? $_SERVER['PHP_WEB_ADMIN_USER'] : 'admin')
            => array('ROLE_ADMIN', 
                (isset($_SERVER['PHP_WEB_ADMIN_PASS']) ? $_SERVER['PHP_WEB_ADMIN_PASS'] : '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==')),
            ),
        ),
    )
));


$app->get('/admin/info', function(){phpinfo();});
$app->get('/admin/', 'controllers\AdminController::indexAction');
$app->post('/admin/encode_password', 'controllers\AdminController::encodePasswordAction');
$app->get('/admin/articles', 'controllers\AdminController::articlesAction');
$app->get('/admin/article/{articleId}', 'controllers\AdminController::articleAction');
$app->post('/admin/article/{articleId}', 'controllers\AdminController::saveArticleAction');
$app->delete('/admin/article/{articleId}', 'controllers\AdminController::deleteArticleAction');
$app->get('/admin/article/{articleId}/{action}', 'controllers\AdminController::updateArticleAction');
$app->get('/admin/menu/{menuId}', 'controllers\AdminController::editMenuAction');
$app->post('/admin/menu/{menuId}', 'controllers\AdminController::menuSaveAction');
$app->get('/admin/images', 'controllers\AdminController::imagesAction');
$app->post('/admin/images', 'controllers\AdminController::uploadImageAction');
$app->get('/admin/resources', 'controllers\AdminController::resourcesAction');
$app->get('/admin/resource/{resourceId}', 'controllers\AdminController::resourceAction');
$app->delete('/admin/resource/{resourceId}', 'controllers\AdminController::deleteResourceAction');
$app->post('/admin/resource/{resourceId}', 'controllers\AdminController::saveResourceAction');
$app->get('/admin/configs', 'controllers\AdminController::editConfigsAction');
$app->post('/admin/configs', 'controllers\AdminController::updateConfigsAction');

