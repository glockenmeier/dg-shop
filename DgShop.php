<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * DG's Shop Plugin
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
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
        $this->addAction("wp_enqueue_scripts", 'add_dojo_dev_script');
        $this->setPriority("admin_enqueue_scripts", 100, 'add_dojo_dev_script');
        $this->addAction("admin_enqueue_scripts", 'add_dojo_dev_script');
    }

    public function add_dojo_dev_script($ar) {

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

    /**
     * Gets the instance of {@see DgShop}.
     * @param type $bootstrapFile
     * @return DgShop
     */
    public static function getInstance($bootstrapFile) {
        if (self::$instance === null) {
            self::$instance = new self($bootstrapFile);
        }
        return self::$instance;
    }

    /**
     * Plugin bootstrap
     * @param string $plugin_bootstrap the plugin file path, usually __FILE__
     */
    public static function bootstrap($plugin_bootstrap = __FILE__) {

        /*
         * Get an instance of the plugin-manager.
         * DopePluginManager is implemented as a singleton. Means that there is only
         * one instance of the manager. getInstance() give's you access to that instance.
         * 
         */
        $pluginManager = DopePluginManager::getInstance();

        /**
         * Note that DgShop is also implemented as singleton. This is not mandatory
         * but is a good practice to keep and refer to a single instance of the plugin.
         */
        $dg_shop = DgShop::getInstance($plugin_bootstrap);

        /* Registers our plugin with dope's plugin-manager.
         * Right now this does nothing aside from registering. Might be used in future
         * to manage dope based plug-ins, dependencies, etc.
         */
        $pluginManager->register($dg_shop);

        /*
         * Enable dope's exception handler for debugging.
         */
        $dope = DGOOPlugin::getInstance();
        $dope->enableExceptionHandler();

        /**
         * Attach debugging event listener
         */
        //$dg_shop->getEventHandler()->addListener(new DopePluginEventDebugger());
    }

    public function getDescription() {
        return "A <strong>powerfull</strong>, yet <strong>simple</strong> to use products+shopping-cart implementation.";
    }

    public function getName() {
        return "DG's Shop";
    }

    public function onActivation($event) {

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
