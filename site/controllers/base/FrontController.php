<?php

namespace controllers\base;
/**
 * Description of FrontController
 *
 * @author Tibi
 */
class FrontController extends AbstractController {
    
    function __construct() {
        
        $this->defaults = array('twigContext' => array(
            'jsFiles' => array( '/js/jquery.treemenu.js', '/js/menu.js' ),
            'cssFiles' => array('/css/jquery.treemenu.css' ),
            'activePage' => $_SERVER['REQUEST_URI']
        ));
    }
}
