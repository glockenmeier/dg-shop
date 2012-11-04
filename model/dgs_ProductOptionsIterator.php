<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_PostOptionsIterator
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
class dgs_ProductOptionsIterator extends DopeArrayIterator {
    
    /**
     * 
     * @param array $optionArray array of dgs_ProductOption
     */
    public function __construct($optionArray) {
        parent::__construct($optionArray);
    }
    
    /**
     * @return dgs_ProductOption
     */
    public function next() {
        return parent::next();
    }
}
