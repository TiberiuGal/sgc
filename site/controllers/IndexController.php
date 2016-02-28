<?php

namespace controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use controllers\base\FrontController;
/**
 * Description of IndexController
 *
 * @author Tibi
 */
class IndexController extends FrontController{

    public function indexAction(Request $request, Application $app) {
        $carousel = $app['carousel'];
        $menu = $app['models']->Menu->byId(1);
        $news = $app['models']->getModel('ArticleModel')->getNews();
        $article = $app['models']->Article->getBySlug('/');

        $context = $this->defaults['twigContext'];
        $context['carousel'] = $carousel->getData();
        $context['menu'] = $menu;
        $context['news'] = $news;
        $context['article'] = $article;
        $context['partners'] = $app['configs']->getData()['partners'];

        return $app['twig']->render('index.twig', $context);
    }
    
    

}
