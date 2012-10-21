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
        if (is_admin() && defined('DOING_AJAX') && DOING_AJAX) {
            $this->controller = new dgs_AjaxController($this);
        } else if (is_admin()) {
            $this->controller = new dgs_AdminController($this);
        } else {
            $this->controller = new dgs_FrontController($this);
        }
        // add dojo script (for development only)
        // NOTE: before release, we need to compile dojo with a custom profile to the js/ folder
        $this->setPriority("wp_enqueue_scripts", 100, 'add_dojo_dev_script');
        $this->addAction("wp_enqueue_scripts", 'add_dojo_dev_script'); // add script to the end of </body> tag
        $this->setPriority("admin_enqueue_scripts", 100, 'add_dojo_dev_script');
        $this->addAction("admin_enqueue_scripts", 'add_dojo_dev_script'); // add script to the end of </body> tag
    }

    public function add_dojo_dev_script($ar) {
        //TODO: look at wp execution path, see if we can find an action just before the closing HTML body tag.
        //var_dump($ar);
        //return;
        //exit;
        $use_local = false;
        $google_cdn = "//ajax.googleapis.com/ajax/libs/dojo/1.8.0/dojo/dojo.js";
        $local = "//js.local/dojo-src/dojo/dojo.js";
        
        
        $view = new SimpleDopeView($this);
        $loc = is_admin() ? "/.." : "";
        
        $view->assign("src", $use_local ? $local : $google_cdn)
                ->assign("async", "true")
                ->assign("package", "dg-shop")
                ->assign("location", $loc . "/wp-content/plugins/dg-shop/js/dg-shop")
                ->render('dev/dojo-script');
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

        $model = new dgs_Model();
        $model->getProductPostType()->register();
        $this->flush_rewrite();
    }

    public function flush_rewrite() {
        error_log("flush_rewrite() start");
        global $wp_rewrite;
        $wp_rewrite->flush_rules(true);
        error_log("flush_rewrite() end");
    }

}
