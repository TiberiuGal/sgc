<?php

namespace models;

trait ModelTrait {

    protected $data;
    protected $pdo;

    function __construct($pdo = null, $data = null) {
        $this->pdo = $pdo;
        if (!empty($data)) {
            $this->load($data);
        }
    }

    protected function load($data) {
        $this->data = $data;
        foreach ($this->data as $key => $val) {
            $this->$key = $val;
        }
    }

    public function getList(\PDOStatement $stmt) {
        $resources = array();
        while (($row = $stmt->fetch(\PDO::FETCH_ASSOC))) {
            $resources[] = new static($this->pdo, $row);
        }
        return $resources;
    }

    protected function getItem(\PDOStatement $stmt) {
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new static($this->pdo, $data);
        }
        return null;
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
