<?php

/*
 * Copyright 10.11.2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_Settings
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package model
 */
class dgs_Settings implements DopePluginEvent {

    private static $option_name = 'dgs-settings';
    private $opt_object = null;
    /**
     *
     * @var dgs_Settings
     */
    private static $instance = null;

    private function __construct() {
        
    }
    
    /**
     * 
     * @return dgs_Settings dgs_Settings instance
     */
    public static function getInstance() {
        if ( self::$instance === null ){
            self::$instance = new dgs_Settings();
        }
        return self::$instance;
    }

    public function init() {
        $this->opt_object = get_option(self::$option_name);
        if ($this->opt_object === false) {
            // initialize with defaults
            $jsonString = include '../default-settings.json';
            $this->opt_object = json_decode($jsonString, false);
            update_option(self::$option_name, $jsonString);
        } else {
            $this->load();
        }
    }

    public function load() {
        $this->opt_object = json_decode(get_option(self::$option_name, '{}'));
    }
    
    public function save() {
        update_option(self::$option_name, json_encode($this->opt_object));
    }
    
    public function getOptionObject() {
        return $this->opt_object;
    }
    
    public function __get($name) {
        return $this->get($name);
    }
    
    public function __set($name, $value) {
        $this->set($name, $value);
    }
    
    public function get($option) {
        return $this->opt_object->$option;
    }

    public function set($option, $value) {
        $this->opt_object->$option = $value;
    }

    public function remove() {
        delete_option(self::$option_name);
    }

    public function onActivation(DopePlugin $plugin, DopeEvent $event) {
        $this->init();
    }

    public function onDeactivation(DopePlugin $plugin, DopeEvent $event) {
        if ( $this->opt_object->keep_settings === true ){
            return;
        }
        $this->remove();
    }

    public function onLoad(DopePlugin $plugin, DopeEvent $event) {
        $this->load();
    }

    public function onUnload(DopePlugin $plugin, DopeEvent $event) {
        
    }

}
