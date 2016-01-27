<?php


$app->get('/', 'controllers\IndexController::indexAction');
$app->get('/info', function(){phpinfo();});
$app->get('/produse', 'controllers\IndexController::productsAction');
$app->get('/produse/{name}', 'controllers\IndexController::productAction');
$app->get('/despre', 'controllers\IndexController::aboutAction');
$app->get('/disponibilitate', 'controllers\IndexController::disponibilitateAction');
$app->get('/contact', 'controllers\ContactController::contactAction');
$app->post('/contact', 'controllers\ContactController::contactSentAction');
$app->get('{url}', 'controllers\CmsController::pageAction');
