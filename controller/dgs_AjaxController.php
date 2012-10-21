<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_AjaxController
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 */
class dgs_AjaxController extends DopeController {
    
    private $model;
    private $post_type; // products - post type slug
    private $action_prefix = "dgs_";

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
    }

    public function init(){
        $this->model->getProductPostType()->register();
    }
    
    protected function getCurrentAction() {
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
        
        // remove prefix
        if (stripos($slug, $this->plugin->getName()) === 0){
            $slug = str_ireplace($this->plugin->getName(), '', $slug);
        }
        
        return $action;
    }
    
    public function getControllerUrl() {
        parent::getControllerUrl();
    }
    
    public function defaultAction() {
    }
}
