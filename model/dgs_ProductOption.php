<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_Option
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
class dgs_ProductOption {
    private $key;
    private $name;
    private $options;
    private $option_iterator;
    
    /**
     * Products option object
     * @param string $key
     * @param string $name
     * @param array $options 
     */
    public function __construct($key, $name, $options) {
        $this->key = $key;
        $this->name = $name;
        $this->options = $options;
        $this->option_iterator = new DopeArrayIterator($this->options);
    }
    
    /**
     * Returns the meta key.
     * @return string
     */
    public function getKey(){
        return $this->key;
    }
    
    /**
     * Returns the option name.
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    
    /**
     * Returns an array of options
     * @return array
     */
    public function getOptions(){
        return $this->options;
    }
    
    /**
     * Returns an option iterator object
     * @return DopeIterable
     */
    public function getOptionIterator(){
        return $this->option_iterator;
    }
}
