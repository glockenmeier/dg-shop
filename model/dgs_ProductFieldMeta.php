<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_ProductFieldMeta
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
class dgs_ProductFieldMeta extends dgs_ProductMeta {
    
    public function __construct($post_id) {
        parent::__construct($post_id, "field");
    }
    
    /**
     * 
     * @param type $key
     * @return \dgs_ProductField
     */
    public function getObject($key) {
        $field = $this->get($key);
        
        return new dgs_ProductField($key, $field);
    }
}
