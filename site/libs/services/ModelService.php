<?php

namespace services;

class ModelService {

    protected $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    function getModel($model, array $params = array()) {
        $model = 'models\\' . $model;

        if (class_exists($model)) {
            $modelObject = new $model($this->dbh);
        } else {
            throw new InvalidModelException("Model $model not found ");
        }

        foreach ($params as $key => $val) {
            $modelObject->$key = $val;
        }
        return $modelObject;
    }

    public function __get($name) {
        $className = 'models\\' . $name . "Model";
        if (class_exists($className)) {
            return $this->getModel($name . "Model");
        } else {
              throw new InvalidModelException("Model $name not found ");
        }
    }

}

class InvalidModelException extends \Exception {
    
}
