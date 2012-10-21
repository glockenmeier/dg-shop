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

    public function __construct(DopePlugin $plugin) {
        parent::__construct($plugin);
        $this->model = new dgs_Model();
        $this->post_type = $this->model->getProductPostType()->getType();
        $this->init();
    }

    private function init() {
        // post type
        add_action('init', array($this, 'init_products'));
        add_action('admin_init', array($this, 'init_admin'));
    }

    public function init_products() {
        $this->model->getProductPostType()->register();
    }

    protected function getCurrentAction() {
        parent::getCurrentAction();
    }

    public function init_admin() {
        if (true) {
            add_filter(sprintf("manage_%s_posts_columns", $this->post_type), array($this, "change_cpt_columns"));
            add_filter(sprintf("manage_edit-%s_sortable_columns", $this->post_type), array($this, "change_sortable_columns"));
            $this->plugin->enqueueStyle("dg-shop-admin");
            //$this->plugin->enqueueScript("edit-products", array(), false, true);
            $this->init_options_meta_box();
            $this->init_attributes_meta_box();
        }
    }

    public function init_options_meta_box() {

        $view = new SimpleDopeView($this->plugin);
        $view->assign("option_name", "the name")
                ->assign("option_values", "values")
                ->assign("post_type", $this->post_type)
                ->setTemplate('products/admin/options-metabox');
        $metabox = new dgs_ProductOptionsMetabox($view, $this->post_type);
        $metabox->add();
    }

    public function init_attributes_meta_box() {

        $view = new SimpleDopeView($this->plugin);
        $view->assign("option_name", "the name")
                ->assign("option_values", "values")
                ->assign("post_type", $this->post_type)
                ->setTemplate('products/admin/attributes-metabox');
        $metabox = new dgs_ProductAttributesMetabox($view, $this->post_type);
        $metabox->add();
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

    public function defaultAction() {
        echo "woe is me!";
    }

}
