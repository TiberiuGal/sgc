<?php

namespace controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of IndexController
 *
 * @author Tibi
 */
class IndexController {

    public function indexAction(Request $request, Application $app) {
        $data = $app['menu']->getData();
        $carousel = $app['carousel'];
        $news = $app['models']->getModel('ArticleModel')->getNews();
        $article = $app['models']->getModel('ArticleModel')->getBySlug($app['db.pdo'], '/');
        return $app['twig']->render('index.twig', array(
                    'carousel' => $carousel->getData(),
                    'menu' => $data,
                    'news' => $news,
                    'article' => $article
        ));
    }

}
