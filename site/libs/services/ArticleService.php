<?php

namespace services;

use models\ArticleModel;

class ArticleService {

    protected $pdo;
    protected $app;

    public function __construct($pdo, $app) {
        $this->pdo = $pdo;
        $this->app = $app;
    }

    public function getArticle($slug) {
        $slug = "/$slug";
        try {
            $article = ArticleModel::getBySlug($this->pdo, $slug);
        } catch (\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $ex) {
            $article = ArticleModel::getBySlug($this->pdo, '/404');
        }
        return $article;
    }
    
    public function parseBodyPlugins($body) {
        
        $pluginService = $this->app['pluginService'];
        
        if(($newBody = preg_replace_callback('/(?:{\$([\w.-_\(\)]+)})/', array($pluginService, 'process'), $body))) {
            return $newBody;
        } 
        return $body;
    
    }

}


