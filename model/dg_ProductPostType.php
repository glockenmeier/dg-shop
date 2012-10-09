<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * DG's Shop Products - Custom Post Type
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 */
class dg_ProductPostType extends DopeCustomPostType {

    /**
     * Creates a new instance of DG's Shop Products - Custom Post Type 
     */
    public function __construct($post_type = 'dgs-products') {
        $label = new DopeSimplePostTypeLabel('Product', 'Products');
        $options = array(
            'labels' => $label->getLabelObject(),
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'fair-trade-products', 'pages' => true),
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'taxonomies' => array('post_tag', 'category'),
            'hierarchical' => true, // must be true to support  page-attributes
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes', 'excerpt'),
            'has_archive' => true
        );

        parent::__construct($post_type, $options);
    }
}

?>
