<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * DG's Shop Products - Custom Post Type
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
class dgs_ProductPostType extends DopeCustomPostType {

    /**
     * Creates a new instance of DG's Shop Products - Custom Post Type 
     */
    public function __construct($post_type = 'dgs-products', $slug = null) {
        $slug = $slug === null ? $post_type : sanitize_title($slug);
        $label = new SimpleDopePostTypeLabel('Product', 'Products');
        $options = array(
            'labels' => $label->getLabelObject(),
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => $slug, 'pages' => true),
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'taxonomies' => array('post_tag', 'category'),
            'hierarchical' => true, // must be true to support  page-attributes
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'has_archive' => true
        );

        parent::__construct($post_type, $options);
    }

}
