<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_ProductOption
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
class dgs_ProductOptionMeta extends dgs_ProductMeta implements DopeIterableAggregate, IteratorAggregate {

    public function __construct($post_id) {
        parent::__construct($post_id, 'option');
    }

    /**
     * Get all options
     * @return array|null array of dgs_ProductOption
     */
    public function getAllObject() {
        $keys = $this->getKeys();
        $result = array();

        if ($keys === null) {
            return null;
        }

        foreach ($keys as $key) {
            $result[$key] = $this->getObject($key);
        }
        return $result;
    }

    /**
     * Get options by key.
     * @param string $key
     * @return dgs_ProductOption 
     */
    public function getObject($key) {
        $opt = $this->get($key);
        return new dgs_ProductOption($opt['key'], $opt['name'], $opt['options']);
    }

    /**
     * 
     * @return Iterator
     */
    public function getIterator() {
        return CollectionUtil::getIterator($this->getIterable());
    }

    /**
     *
     * @return dgs_ProductOptionsIterator 
     */
    public function getIterable() {
        $options = $this->getAllObject();
        return new dgs_ProductOptionsIterator($options);
    }

}
