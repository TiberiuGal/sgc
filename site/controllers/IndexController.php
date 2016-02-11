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
        $menu = $app['models']->Menu->byId(1);
        
        $carousel = $app['carousel'];
        
        $news = $app['models']->getModel('ArticleModel')->getNews();
        $article = $app['models']->Article->getBySlug('/');
        
        return $app['twig']->render('index.twig', array(
                    'carousel' => $carousel->getData(),
                    'menu' => $menu,
                    'news' => $news,
                    'article' => $article
        ));
    }

}
