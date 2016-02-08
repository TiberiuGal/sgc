<?php
namespace services;



class ModelService {
    protected $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }
    
    function getModel($model, array $params = array()) {
        $model = 'models\\' .$model;
                
        if (class_exists($model)){
            $modelObject = new $model($this->dbh);
        } else {
            throw new InvalidModelException("Model $model not found ");
        }
        
        foreach($params as $key => $val) {
            $modelObject->$key = $val;
        }
        return $modelObject;
    }
}


class InvalidModelException extends \Exception {}
