<?php
namespace services;

use \models;

class ModelService {
    protected $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }
    
    function getModel($model, array $params = array()) {
        if (class_exists($model)){
            $modelObject = new $model($this->dbh);
        } else {
            throw InvalidModelException("Model $model not found ");
        }
        
        foreach($params as $key => $val) {
            $modelObject->$key = $val;
        }
        
    }
}


class InvalidModelException extends \Exception {}
