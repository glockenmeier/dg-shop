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

/*
 * This is a dojo AMD module definition.
 * 
 * Module       : dg-shop/Object
 * Author       : Darius Glockenmeier
 * Description  : Base class
 */

define([
    // dependencies
    "dojo/_base/declare",
    //"dojo/_base/lang",
    //"dojo/ready",
    //"dojo/_base/unload"
    ], function(declare){
        return declare(null, {
        
            // provides default constructor
            constructor: function() {
                /*
                // registers load/unload functions
                var load = lang.hitch(this, this.load);
                var unload = lang.hitch(this, this.unload);
                ready(load);
                baseUnload.addOnUnload(window, unload);
                */
            },
            /**
         * Called after DOM has loaded
         */
            load: function() {
                console.info("load: " + this);
                return true;
            },
            /**
         * Called before the DOM unloads
         */
            unload: function() {
                console.info("unload: " + this);
                return true;
            }
        });
    });