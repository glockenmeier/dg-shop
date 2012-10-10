<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * DG's Shop - a powerfull, yet simple to use products+shopping-cart implementation.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 */
class DgShop extends DopePlugin {

    private static $instance = null;
    private $controller = null;

    public function __construct($bootstrapFile) {
        parent::__construct($bootstrapFile);

        $this->init();
    }

    public function init() {
        if (is_admin() && defined('DOING_AJAX') && DOING_AJAX){
            $this->controller = new dgs_AjaxController($this);
        } else if (is_admin()){
            $this->controller = new dgs_AdminController($this);
        }else {
            $this->controller = new dgs_FrontController($this);
        }
    }
    
    public static function getInstance($bootstrapFile) {
        if (self::$instance === null) {
            self::$instance = new self($bootstrapFile);
        }
        return self::$instance;
    }

    public function getDescription() {
        return "A <strong>powerfull</strong>, yet <strong>simple</strong> to use products+shopping-cart implementation.";
    }

    public function getName() {
        return "DG's Shop";
    }

    public function onActivation() {
        parent::onActivation();
        $this->controller->init_products_cpt(); // everywhere else would be too late :(
        $this->flush_rewrite();
    }

    public function flush_rewrite() {
        error_log("flush_rewrite() start");
        global $wp_rewrite;
        $wp_rewrite->flush_rules(true);
        error_log("flush_rewrite() end");
    }

}
