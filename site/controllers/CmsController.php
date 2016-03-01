<?php

namespace controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use controllers\base\FrontController;

class CmsController extends FrontController {

    public function pageAction($url, Request $request, Application $app) {

        $articleModel = $app['models']->getModel('ArticleModel');
        $menu = $app['models']->Menu->byId(1);
        $news = $app['models']->getModel('ArticleModel')->getNews();

        $article = $articleModel->getBySlugOrNotFound($url);
        $app['pluginService']->parseBodyPlugins($article->body);
        $context = $this->defaults['twigContext'];

        $context['menu'] = $menu;
        $context['news'] = $news;
        $context['article'] = $article;

        
        return $app['twig']->render('article.twig', $context);
    }

    public function searchAction(Request $request, Application $app) {
        $articles = $app['models']->Article->search($request->get('q'));        
        
        $menu = $app['models']->Menu->byId(1);
        $news = $app['models']->getModel('ArticleModel')->getNews();
        
        $context = $this->defaults['twigContext'];

        $context['menu'] = $menu;
        $context['news'] = $news;
        $context['articles'] = $articles;

        return $app['twig']->render('cautare.twig', $context);
    }

}
