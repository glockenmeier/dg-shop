<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_Attribute
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
class dgs_ProductAttribute {

    private $key;
    private $name;
    private $value;

    public function __construct($key, $name, $value) {
        $this->key = $key;
        $this->name = $name;
        $this->value = $value;
    }

    public function getKey() {
        return $this->key;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getValue() {
        return $this->value;
    }
}
