<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_Model
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
final class dgs_Model {
    private $products; // products - custom post type
    private $meta;
    
    public function __construct() {
        $this->products = new dgs_ProductPostType('fair_trade_products');     
        //$this->meta = new dgs_ProductMeta();
    }
    
    /**
     * Retr
     * @return dgs_ProductPostType 
     */
    public function getProductPostType() {
        return $this->products;
    }
    
    /**
     * Gets a product options iterable object
     * @param object $post the post object
     * @return dgs_ProductOptionsIterator
     */
    public function getProductOptions($post){
        $optionMeta = new dgs_ProductOptionMeta($post->ID);
        return $optionMeta->getIterable();
    }
    
    /**
     * Gets the product attributes for a post as an iterable.
     * @param object $post the post object
     * @return dgs_ProductAttributesIterator
     */
    public function getProductAttributes($post) {
        $attrMeta = new dgs_ProductAttributeMeta($post->ID);
        return $attrMeta->getIterable();
    }

}

?>
