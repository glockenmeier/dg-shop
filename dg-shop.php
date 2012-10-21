<?php

/**
 * Plugin Name: DG's Shop Lite
 * Depends: dope
 * Plugin URI:  http://www.baliashram.com/
 * Description: A <strong>powerfull</strong>, yet <strong>simple</strong> to use products+shopping-cart implementation.
 * Version:     0.2
 * Author:      Darius Glockenmeier
 * Author URI:  http://www.baliashram.com/
 * License:     GPLv3
 */
/* Copyright (C) 2012  Darius Glockenmeier

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
//return;
include 'dependency-check.php';

/**
 * Let dope register the autoload feature for this plugin.
 */
DopePluginAutoloader::register(plugin_dir_path(__FILE__));

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
$dg_shop = DgShop::getInstance(__FILE__);

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

function hprint_r($var, $return = false, $title = '') {
    
    $out = "%s<pre>%s</pre>";
    if ($return) {
        return sprintf($out, $title, print_r($var, true));
    } else {
        printf($out, $title, print_r($var, true));
    }
}