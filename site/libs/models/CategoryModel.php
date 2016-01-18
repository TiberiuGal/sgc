<?php

namespace models;

class CategoryModel {
    
    static function getCategories($pdo) {
        return $pdo->query("select id, title from categories ");
    }
}