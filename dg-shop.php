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
include 'dependency-check.php';

/**
 * Let dope register the autoload feature for this plugin.
 */
DopePluginAutoloader::register(plugin_dir_path(__FILE__));

/*
 * Starts the plugin
 */
DgShop::bootstrap(__FILE__);
