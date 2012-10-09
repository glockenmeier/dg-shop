<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DgShopAdminController
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 */
class DgShopAdminController extends DopeController {

    private $cpt_products = "fair_trade_products";
    private $products;

    public function __construct(DopePlugin $plugin) {
        parent::__construct($plugin);
        $this->products = new dg_ProductPostType($this->cpt_products);
        $this->init();
    }

    private function init() {
        // post type
        add_action('init', array($this, 'init_products'));
        add_action('admin_init', array($this, 'init_products_option_meta_box'));
        add_action('admin_init', array($this, 'save_metabox_data'));
        //add_action('save_post', array($this->plugin, 'flush_rewrite'));
    }

    public function init_products() {

        $this->products->register();
        $this->init_shop();

        add_action('template_redirect', array($this, 'template_redirect'), 1);
        // CPT Templates
        // NOTE: compatibility test, new method doesn't work @see http://codex.wordpress.org/Plugin_API/Filter_Reference/single_template
        //$single_template_handler = array($this, 'cpt_products_single_template');
        //$vdiff = version_compare($this->plugin->wp_version, "3.4.0");
        /*
          error_log(print_r(array("WP_Version" => $this->plugin->wp_version, "required" => "3.4.0", "diff" => $vdiff), true));
          if ($vdiff >= 0 && false) { // NOTE: false here to force old filter, new one doesn't work
          //use new
          add_filter($this->cpt_products . "_template", $single_template_handler);
          error_log($single_template_handler[1] . "using NEW filter");
          } else {
          // use old api
          add_filter('single_template', $single_template_handler);
          error_log($single_template_handler[1] . "COMPATIBILITY MODE - using OLD filter");
          }
          add_filter('archive_template', array($this, 'cpt_products_archive_template'));
         */

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

        if (!isset($post) || $post->post_type != $this->products->getType()) {
            /*
              echo "count: " . printf("<pre>\n%s\n</pre>", print_r($wp_query, true));
              echo "<br />is tag: " . is_tag();
              echo "<br />is tax: " . is_tax();
              echo "<br />is cat: " . is_category();
             */
            return; // not ours to handle
        }

        if (have_posts()) {
            if (is_post_type_archive($this->products->getType())) {
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
        $content_class = sprintf('class="%s-single"', esc_attr($this->products->getType()));
        if (get_query_var("preview") == true) {
            $posts_query = sprintf('post_type=%1$s&p=%2$s', $this->products->getType(), get_query_var("p"));
        } else {
            $posts_query = sprintf('post_type=%1$s&%1$s=%2$s', $this->products->getType(), get_query_var($this->products->getType()));
        }

        $view->assign('content_class', $content_class)
                ->assign("slug", $this->products->getType())
                ->assign('posts_query', $posts_query)
                ->render('products/single');
    }

    protected function getCurrentAction() {
        parent::getCurrentAction();
    }

    public function cpt_products_archive_template() {
        $view = new SimpleDopeView($this->plugin);
        $content_class = sprintf('class="%s-archive"', esc_attr($this->products->getType()));
        $paged = get_query_var('paged') ? '&paged=' . get_query_var('paged') : '';
        $posts_query = sprintf('post_type=%s%s', $this->products->getType(), $paged);
        global $wp_query;

        $view->assign('content_class', $content_class)
                ->assign("slug", $this->products->getType())
                ->assign("posts_query", $posts_query)
                ->assign('has_pages', $wp_query->max_num_pages > 1)
                ->render('products/archive');
    }

    public function init_products_option_meta_box() {
        //add_meta_box('dg-shop_products_option', "Options", array($this, 'render_products_option'));
    }

    public function save_metabox_data($post_id) {
        
    }

    public function render_products_option() {
        // todo: use ajax to save custom option and their values.
        $view = new SimpleDopeView($this->plugin);
        $view->assign("option_name", "the name")
                ->assign("option_values", "values")
                ->render('products/option_metabox');
    }

    public function change_cpt_columns($cols) {
        $my_cols = array(
            'weight' => __('Weight', 'dg-shop'),
            'desc' => __('Description', 'dg-shop')
        );
        //$my_cols = array_merge($cols, $my_cols);
        return $my_cols;
    }

    public function indexAction() {
        echo "hi";
    }

}
