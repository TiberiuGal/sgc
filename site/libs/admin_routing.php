<?php

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/admin',
            'http' => true,
            'users' => array(
                // raw password is foo
                'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
            ),
        ),
    )
));
$app->get('/admin/', 'controllers\AdminController::indexAction');
$app->get('/admin/articles', 'controllers\AdminController::articlesAction');
$app->get('/admin/article/{articleId}', 'controllers\AdminController::articleAction');
$app->post('/admin/article/{articleId}', 'controllers\AdminController::saveArticleAction');
$app->get('/admin/article/{articleId}/{action}', 'controllers\AdminController::updateArticleAction');
$app->get('/admin/menu/{menuId}', 'controllers\AdminController::editMenuAction');
$app->get('/admin/edit-menu', 'controllers\AdminController::editMenu2Action');
$app->post('/admin/menu/{menuId}', 'controllers\AdminController::menuSaveAction');
$app->get('/admin/images', 'controllers\AdminController::imagesAction');
$app->post('/admin/images', 'controllers\AdminController::uploadImageAction');

