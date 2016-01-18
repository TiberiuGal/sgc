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
        $carousel = new \CarouselService();

        return $app['twig']->render('index.twig', array(
                    'carousel' => $carousel->getData(),
                   
        ));
    }
    
    public function aboutAction(Request $request, Application $app) {
     
        return $app['twig']->render('despre.twig', array(
                    
        ));
    }

    
}
