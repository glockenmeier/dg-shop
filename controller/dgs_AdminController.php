<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DgShopAdminController
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @category MVC
 * @package dg-shop
 * @subpackage Controller
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
        $this->init_settings();
    }
    
    private function init_settings() {
        $s = new DopeSettings("dg-shop");
        $s->addOptionsPage("DG-Shop", "DG's Shop");
        
        $section = new dgs_AdminSettingsSection($this->plugin);
        $s->addSection($section);
        
        // create 3rd field, this time field first
        $field3 = new SimpleDopeSettingsField('dgs_product_slug', 'Products slug');
        // using an inline view
        $input = new SimpleInlineDopeView();
        $opt = new DopeOptions('dgs_');
        $input->setTemplate(sprintf('<input name="dgs_product_slug" id="dgs_product_slug" type="text" value="%s"/>', $opt->get('product_slug', 'product')));
        
        $field3->setView($input);
        // add to section
        $section->addField($field3);
        
        $s->register();
    }
    
    private function init_settings_test() {
        
        $s = new DopeSettings("dg-shop");
        $s->addOptionsPage("DG-Shop", "DG's Shop");
        
        $section = new dgs_AdminSettingsSection($this->plugin);
        $s->addSection($section);
        // add first field which is implemented in the class using view
        $field = new dgs_AdminSettingsInput($this->plugin);
        $section->addField($field);
        
        // uses a view as a template
        $cb = new SimpleDopeView($this->plugin->getDirectory());
        $cb->setTemplate('settings/admin/checkbox')
                ->assign('name', 'field2')
                ->assign('checked', checked(1, get_option('field2'), false))
                ->assign('text', "Hello field 2");
        // add view to settings field
        $field2 = new SimpleDopeSettingsField('field2', 'field 2 desc.', $cb);
        // add to the section
        $section->addField($field2);
        
        // create 3rd field, this time field first
        $field3 = new SimpleDopeSettingsField('field3', 'field 3 goes here');
        // using an inline view
        $input = new SimpleInlineDopeView();
        $input->setTemplate(sprintf('<input name="field3" id="field3" type="text" value="%s"/>Bla bla..', get_option('field3')));
        $field3->setView($input);
        // add to section
        $section->addField($field3);
        
        $s->register();
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
            add_action(sprintf("manage_%s_posts_custom_column", $this->post_type), array($this, "cpt_custom_column"), 10, 2);
            
            $this->plugin->enqueueStyle("dg-shop-admin");
            //$this->plugin->enqueueScript("edit-products", array(), false, true);
            $this->init_options_meta_box();
            $this->init_attributes_meta_box();
            $this->init_fields_meta_box();
        }
    }

    private function init_options_meta_box() {

        $view = new SimpleDopeView($this->plugin->getDirectory());
        $view->assign("option_name", "the name")
                ->assign("option_values", "values")
                ->assign("post_type", $this->post_type)
                ->setTemplate('products/admin/options-metabox');
        $metabox = new dgs_ProductOptionsMetabox($view, $this->post_type);
        $metabox->add();
    }

    private function init_attributes_meta_box() {

        $view = new SimpleDopeView($this->plugin->getDirectory());
        $view->assign("option_name", "the name")
                ->assign("option_values", "values")
                ->assign("post_type", $this->post_type)
                ->setTemplate('products/admin/attributes-metabox');
        $metabox = new dgs_ProductAttributesMetabox($view, $this->post_type);
        $metabox->add();
    }
    
    private function init_fields_meta_box() {

        $view = new SimpleDopeView($this->plugin->getDirectory());
        $view->assign("option_name", "the name")
                ->assign("option_values", "values")
                ->assign("post_type", $this->post_type)
                ->setTemplate('products/admin/fields-metabox');
        $metabox = new dgs_ProductFieldsMetabox($view, $this->post_type);
        $metabox->add();
    }

    public function cpt_custom_column($column, $post_id) {
        $meta = new dgs_ProductFieldMeta($post_id);
        switch ( $column ) {
            case 'price':
                echo $meta->get('price');
                break;
            case 'weight':
                echo $meta->get('weight');
                break;
            case 'stock':
                echo $meta->get('stock');
                break;
        }
    }
    
    public function change_cpt_columns($cols) {
        // TODO: plugin options to hide specific fields
        $my_cols = array(
            'weight' => __('Weight', 'dg-shop'),
            'price' => __('Price', 'dg-shop'),
            'stock' => __('Stock', 'dg-shop')
        );
        
        return array_merge($cols, $my_cols);
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
