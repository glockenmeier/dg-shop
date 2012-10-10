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

    private function init(){
        
    }
    
    public function indexAction() {
        
    }
}
