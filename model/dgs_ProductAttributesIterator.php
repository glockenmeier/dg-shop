<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_ProductAttributesIterator
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
class dgs_ProductAttributesIterator extends DopeArrayIterator {


    public function __construct($array) {
        parent::__construct($array);
    }

    /**
     * @return dgs_ProductAttribute 
     */
    public function next() {
        return parent::next();
    }

}
