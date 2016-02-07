<?php
namespace services;

class CarouselService {
    
    protected static $data = array(
      array(
          'img_src'=> '/img/carousel/carousel-1.jpg',
          'img_alt' => 'lorem ipsum',
          'title' => 'Doamne, ajuta-ne sa gasim calea'
          )  ,
      array(
          'img_src'=> '/img/carousel/carousel-2.jpg',
          'img_alt' => 'lorem ipsum',
          'title' => 'Speranta, Iubire, Putere'
          )  ,
      array(
          'img_src'=> '/img/carousel/carousel-3.jpg',
          'img_alt' => 'lorem ipsum',
          'title' => 'Fericirea copiilor nostri'
          )  ,
      array(
          'img_src'=> '/img/carousel/carousel-4.jpg',
          'img_alt' => 'lorem ipsum',
          'title' => '... prin educatie'
          )  ,        
        
        );
    
    public function getData($length = 5) {
        return array_slice( self::$data,0, $length);
    }
    
}

