<?php

use models\ArticleModel;

class ArticleService {

    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
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

}
