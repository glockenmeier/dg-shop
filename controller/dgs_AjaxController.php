<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_AjaxController
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @category MVC
 * @package dg-shop
 * @subpackage Controller
 */
class dgs_AjaxController extends DopeController {
    
    private $model;
    private $post_type; // products - post type slug
    // private $action_prefix = "dgs_";

    /**
     *
     * @param DopePlugin $plugin
     * @param \dgs_Model $model 
     */

    public function __construct(DopePlugin $plugin) {
        parent::__construct($plugin);
        $this->model = new dgs_Model();
        $this->post_type = $this->model->getProductPostType()->getType();
        add_action("init", array($this, 'init'));
        
        // TODO: need to register action, based on Action functions
        // as names has to be unique, prefix with {class name}_{Action} (as default)
        // prefix should be modifiable by overiding prefix func.
        // this is a good time to start making a DopeAjaxController? :)
        add_action('wp_ajax_dgs_cart_add', array($this, '_ajaxHandler'));
        add_action('wp_ajax_dgs_cart_update', array($this, '_ajaxHandler'));
        add_action('wp_ajax_dgs_cart_clear', array($this, '_ajaxHandler'));
    }

    public function init(){
        $this->model->getProductPostType()->register();
    }
    
    protected function getCurrentAction() {
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
        
        // TODO: find out what this is all about below
//        // remove prefix
//        if (stripos($slug, $this->plugin->getName()) === 0){
//            $slug = str_ireplace($this->plugin->getName(), '', $slug);
//        }
        
        return $action;
    }
    
    public function getControllerUrl() {
        parent::getControllerUrl();
    }
    
    public function defaultAction() {
    }
    
    public function _ajaxHandler() {
        
        die("i'm dead");
    }
}
