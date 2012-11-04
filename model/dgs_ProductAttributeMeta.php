<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_ProductAttributeMeta
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
class dgs_ProductAttributeMeta extends dgs_ProductMeta implements DopeIterableAggregate, IteratorAggregate {
    
    public function __construct($post_id) {
        parent::__construct($post_id, "attr");
    }
    
    /**
     *
     * @return array array of dgs_ProductAttribute
     */
    public function getAllObject() {
        $keys = $this->getKeys();
        $result = array();
        
        if ($keys === null){
            return null;
        }
        
        foreach($keys as $key){
            $result[$key] = $this->getObject($key);
        }
        return $result;
    }
    
    public function getObject($key) {
        $attr = $this->get($key);
        
        return new dgs_ProductAttribute($attr['key'], $attr['name'], $attr['options']);
    }

    public function getIterable() {
        $attributes = $this->getAllObject();
        return new dgs_ProductAttributesIterator($attributes);
    }

    public function getIterator() {
        return new DopeIteratorAdapter($this->getIterable());
    }
}
