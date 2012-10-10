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
final class dgs_AdminController extends DopeController {

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
        $this->post_type = $this->model->getProductsPostType()->getType();
        $this->init();
        
    }

    private function init() {
        // post type
        add_action('init', array($this, 'init_products'));
        add_action('admin_init', array($this, 'init_admin'));
    }

    public function init_products() {
        $this->model->getProductsPostType()->register();
    }

    protected function getCurrentAction() {
        parent::getCurrentAction();
    }

    public function init_admin(){
        add_filter(sprintf("manage_%s_posts_columns", $this->post_type), array($this, "change_cpt_columns"));
        add_filter(sprintf("manage_edit-%s_sortable_columns", $this->post_type), array($this, "change_sortable_columns"));
        $this->init_products_option_meta_box();
    }
    
    public function init_products_option_meta_box() {
        add_meta_box('dg_shop_products_option', "Options", array($this, 'render_products_option'), $this->post_type);
    }

    public function render_products_option() {
        // todo: use ajax to save custom option and their values.
        echo "Hello world!";
        return;
        
        $view = new SimpleDopeView($this->plugin);
        $view->assign("option_name", "the name")
                ->assign("option_values", "values")
                ->render('products/option_metabox');
    }

    public function change_cpt_columns($cols) {
        // TODO: plugin options to hide specific fields
        $my_cols = array(
            'weight' => __('Weight', 'dg-shop'),
            'desc' => __('Description', 'dg-shop'),
            'price' => __('Price', 'dg-shop'),
            'stock' => __('Stock', 'dg-shop')
        );
        $my_cols = array_merge($cols, $my_cols);
        return $my_cols;
    }
    
    public function change_sortable_columns() {
        return array(
            'title' => 'title',
            'weight' => 'weight',
            'price' => 'price',
            'stock' => 'stock',
            'date' => 'date',
            'categories' => 'categories',
            'tags' => 'tags'
        );
    }
    
    public function indexAction() {
        echo "hi";
    }

}
