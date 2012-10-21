<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_Model
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
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
     * @return \dgs_ProductPostType 
     */
    public function getProductPostType() {
        return $this->products;
    }

}

?>
