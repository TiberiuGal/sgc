<?php

namespace models;

trait ModelTrait {

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
