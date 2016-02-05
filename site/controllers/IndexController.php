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
        $data = $app['menu']->getData();
        
        return $app['twig']->render('index.twig', array(
                    'carousel' => $carousel->getData(),
                    'menu' => $data
        ));
    }

    

}
