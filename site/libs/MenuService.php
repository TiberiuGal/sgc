<?php

use models\MenuModel;

class MenuService {
    protected $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getData(){
        return MenuModel::getById($this->pdo, 1);
    }
}