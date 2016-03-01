<?php


$app->get('/', 'controllers\IndexController::indexAction');
$app->get('/contact', 'controllers\ContactController::contactAction');
$app->post('/contact', 'controllers\ContactController::contactSentAction');
$app->get('/cautare', 'controllers\CmsController::searchAction');
$app->get('{url}', 'controllers\CmsController::pageAction')->assert('url', '.+');

