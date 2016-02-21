<?php
namespace services;

class CarouselService {
    
    protected static $data = array(
      
      array(
          'img_src'=> '/img/carousel/carousel-3.jpg',
          'img_alt' => '',
          'title' => ''
          )  ,
      array(
          'img_src'=> '/img/carousel/carousel-4.jpg',
          'img_alt' => '',
          'title' => ''
          )  ,        
        
        );
    
    public function getData($length = 5) {
        return array_slice( self::$data,0, $length);
    }
    
}

