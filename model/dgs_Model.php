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
    private $settings = null;
    
    public function __construct() {
        $opt = new DopeOptions('dgs_');
        $slug = $opt->get('product_slug', 'products');
        $this->products = new dgs_ProductPostType('dgs_products', $slug);
        
        $this->settings = dgs_Settings::getInstance();
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
    
    /**
     * 
     * @return dgs_Settings
     */
    public function getSettings() {
        return $this->settings;
    }
}

?>
