<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_ProductMeta
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 */
class dgs_ProductMeta {
    private $post_id;
    private $weight;
    private $dimensions;
    private $options;
    
    public function __construct($post_id = null) {
        if ($post_id === null){
            global $post;
            if (!isset($post)){
                throw new DopeModelException("Could not get global \$post variable. Try specifying the post_id instead.");
            }
            $post_id = $post->ID;
        }
        $this->post_id = $post_id;
    }
    
    public function getMeta(){
        
    }
}
