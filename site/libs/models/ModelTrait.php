<?php

namespace models;

trait ModelTrait {
    
    protected $data;
    protected $pdo;
    
    function __construct($pdo = null, $data = null) {
        $this->pdo = $pdo;
        $this->data = $data;
    }
    
    public function getList(\PDOStatement $stmt){
        $resources = array();
        while(($row = $stmt->fetchObject(__CLASS__))){
            $resources[] = $row;
        }
        return $resources;
    } 

    function __get($name) {

        if (method_exists($this, ( $fn = "get{$name}"))) {
            return $this->$fn();
        }
    }

    function __set($name, $value) {
        if (method_exists($this, ($fn = "get{$name}"))) {
            return $this->$fn($value);
        } elseif (method_exists($this, $name)) {
            return $this->$name($value);
        }
    }

}
