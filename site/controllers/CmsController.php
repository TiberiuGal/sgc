<?php

namespace controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class CmsController {

    public function pageAction($url, Request $request, Application $app) {

        $article = $app['articles']->getArticle($url);
        $article->body = $app['articles']->parseBodyPlugins( $article->body );
        $news = $app['models']->getModel('ArticleModel')->getNews();
        return $app['twig']->render('article.twig', array(
                    'article' => $article,
                    'menu' => $app['menu']->getData(),
                    'news' => $news
        ));
    }
    
    

}
