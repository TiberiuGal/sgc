<?php

namespace controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class CmsController {

    public function pageAction($url, Request $request, Application $app) {
        
        $articleModel = $app['models']->getModel('ArticleModel');
        
        $article = $articleModel->getBySlugOrNotFound($url);
        $app['pluginService']->parseBodyPlugins( $article->body );
        
        $news = $app['models']->getModel('ArticleModel')->getNews();
        return $app['twig']->render('article.twig', array(
                    'article' => $article,
                    'menu' => $app['models']->Menu->byId(1),
                    'news' => $news,
                    'partners' => $app['configs']->getData()['partners']
        ));
    }
    
    

}
