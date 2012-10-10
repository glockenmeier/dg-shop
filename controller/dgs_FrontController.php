<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_FrontController
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 */
final class dgs_FrontController extends DopeController {

    private $model;
    private $post_type; // products - post type slug

    /**
     *
     * @param DopePlugin $plugin
     * @param \dgs_Model $model 
     */

    public function __construct(DopePlugin $plugin) {
        parent::__construct($plugin);
        $this->model = new dgs_Model();
        $this->post_type = $this->model->getProductPostType()->getType();
        add_action('init', array($this, 'init'));
    }

    public function init() {
        $this->model->getProductPostType()->register();

        add_action('template_redirect', array($this, 'template_redirect'), 1);
        add_filter('request', array($this, 'add_cpt_to_feed'));

        $this->init_shop();
        $this->plugin->enqueueStyle('dg-shop');
    }

    public function init_shop() {
        if (session_id() === "") {
            if (!session_start()) {
                throw new DopeControllerException("Could not start a session.");
            }
        }
    }

    public function template_redirect() {
        global $post, $wp_query;

        // TODO: try content only filter, keeping theme intact as an option.

        if (!isset($post) || $post->post_type != $this->post_type) {
            /*
              echo "count: " . printf("<pre>\n%s\n</pre>", print_r($wp_query, true));
              echo "<br />is tag: " . is_tag();
              echo "<br />is tax: " . is_tax();
              echo "<br />is cat: " . is_category();
             */
            return; // not ours to handle
        }

        if (have_posts()) {
            if (is_post_type_archive($this->post_type)) {
                $this->cpt_products_archive_template();
            } else if (is_single()) {
                $this->cpt_products_single_template();
            } else {
                $wp_query->is_404 = true;
            }
        } else {
            $wp_query->is_404 = true;
        }
        exit; // NOTE: feels wrong. but well..
    }

    public function cpt_products_single_template() {
        $view = new SimpleDopeView($this->plugin);
        $content_class = sprintf('class="%s-single"', esc_attr($this->post_type));
        if (get_query_var("preview") == true) {
            $posts_query = sprintf('post_type=%1$s&p=%2$s', $this->post_type, get_query_var("p"));
        } else {
            $posts_query = sprintf('post_type=%1$s&%1$s=%2$s', $this->post_type, get_query_var($this->post_type));
        }
        global $post;
        $meta = get_post_custom($post->ID);

        $view->assign('content_class', $content_class)
                ->assign("slug", $this->post_type)
                ->assign('posts_query', $posts_query)
                ->assign("meta", sprintf('<div class="clear"><pre>%s</pre></div>', print_r($meta, true)))
                ->render('products/single');
    }

    public function cpt_products_archive_template() {
        $view = new SimpleDopeView($this->plugin);
        $content_class = sprintf('class="%s-archive"', esc_attr($this->post_type));
        $paged = get_query_var('paged') ? '&paged=' . get_query_var('paged') : '';
        $posts_query = sprintf('post_type=%s%s', $this->post_type, $paged);
        global $wp_query;

        $view->assign('content_class', $content_class)
                ->assign("slug", $this->post_type)
                ->assign("posts_query", $posts_query)
                ->assign('has_pages', $wp_query->max_num_pages > 1)
                ->render('products/archive');
    }

    public function add_cpt_to_feed($query_var) {
        if (isset($query_var['feed']) && !isset($query_var['post_type'])) {
            $query_var['post_type'] = array('post', $this->post_type);
        }
        return $query_var;
    }

    public function indexAction() {
        
    }

}
