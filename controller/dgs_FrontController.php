<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_FrontController
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @category MVC
 * @package dg-shop
 * @subpackage Controller
 * @uses view/products/single.inc.php Single post template
 * @uses view/products/archive.inc.php Archive post template
 */
final class dgs_FrontController extends DopeController {

    private $model;
    private $post_type; // products - post type slug

    /**
     *
     * @param DopePlugin $plugin
     * @param dgs_Model $model 
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
        add_filter('pre_get_posts', array($this, 'pre_get_posts'));
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

    public function pre_get_posts($q) {
        if ($q->is_tag() || $q->is_category() && $q->is_main_query()) {
            $post_type = $q->get('post_type');
            // merge post types
            if (!empty($post_type)) {
                $post_type = array($post_type);
            } else {
                $post_type = array('post');
            }
            $all = array_merge($post_type, array($this->post_type));
            
            $q->set('post_type', $all);
        }
    }

    public function template_redirect() {
        $dpost = $this->getPost();
        $q = $this->getQuery();

        // TODO: try content only filter, keeping theme intact as an option.

        if ($dpost === null || $dpost->getType() != $this->post_type) {
            // TODO: fixme: tags and categories doesnt work with custom post type.
            /*
              echo "<br />is tag: " . is_tag();
              echo "<br />is tax: " . is_tax();
              echo "<br />is cat: " . is_category();
              exit; */

            return; // not ours to handle
        }

        if ($q->have_posts()) {
            if ($q->is_post_type_archive($this->post_type)) {
                $this->cpt_products_archive_template();
            } else if ($q->is_singular($this->post_type)) {
                $this->cpt_products_single_template();
            } else {
                //$q->set_404();
            }
        } else {
            //$q->set_404();
        }
        exit; // prevent default template being rendered.
    }

    private function cpt_products_single_template() {

        $content_class = sprintf('class="%s-single"', esc_attr($this->post_type));
        $q = $this->getQuery();

        if ($q->is_preview()) {
            $preview_key = (int) $q->get("p") !== 0 ? 'p' : 'p';
            $posts_query = sprintf('post_type=%1$s&%2$s=%3$s', $this->post_type, $preview_key, (int) $q->get("p"));
        } else {
            $posts_query = sprintf('post_type=%1$s&%1$s=%2$s', $this->post_type, $q->get($this->post_type));
        }

        $dpost = $this->getPost();

        $view = new SimpleDopeView($this->plugin);
        $view->assign('content_class', $content_class)
                ->assign("slug", $this->post_type)
                ->assign('posts_query', $posts_query)
                ->assign("post", $dpost->toPostObject())
                ->assign("meta", sprintf('<div class="clear"><pre>%s</pre></div>', print_r($dpost, true)))
                ->render('products/single');
    }

    private function cpt_products_archive_template() {
        $view = new SimpleDopeView($this->plugin);
        $content_class = sprintf('class="%s-archive"', esc_attr($this->post_type));
        $paged = get_query_var('paged') ? '&paged=' . get_query_var('paged') : '';
        $posts_query = sprintf('post_type=%s%s', $this->post_type, $paged);

        $view->assign('content_class', $content_class)
                ->assign("slug", $this->post_type)
                ->assign("posts_query", $posts_query)
                ->assign('has_pages', $this->getQuery()->max_num_pages > 1)
                ->render('products/archive');
    }

    public function add_cpt_to_feed($query_var) {
        if (isset($query_var['feed']) && !isset($query_var['post_type'])) {
            $query_var['post_type'] = array('post', $this->post_type);
        }
        return $query_var;
    }

    public function defaultAction() {
        
    }

}
