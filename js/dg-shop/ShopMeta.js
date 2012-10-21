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
 * Module       : dg-shop/ShopMeta
 * Author       : Darius Glockenmeier
 * Description  : Product options Metabox functionality. Registers available
 *                options with OptionBox. Also handles creating new options.
 */

define([
    // dependencies
    "dojo/_base/declare",
    "dojo/_base/lang",
    "dojo/_base/array",
    "dojo/dom",
    "dojo/dom-construct",
    "dojo/query",
    "dojo/on",
    "dg-shop/Object",
    "dg-shop/OptionBox",
    "dg-shop/edit",
    ], function(declare, lang, arr, dom, domc, query, on, obj, OptionBox, edit){
        var Shop = declare(obj, {
            metabox: null,
            templateNode: null,
            buttonNewOption: null,
            options: [], // contains all option objects
            
            
            constructor: function(metabox_id) {
                this.metabox = dom.byId(metabox_id);
            },
            load: function() {
                this.templateNode = dom.byId("dg_shop_option_template");
                this.buttonNewOption = dom.byId("dg_shop_new_option");
                
                this.registerOptions();
                
                on(this.buttonNewOption, "click", lang.hitch(this, this.buttonNewOption_click));
                
                return true;
            },
            unload: function() {
                return true;
            },
            registerOptions: function(){
                this.options = [];
                query(".option", this.metabox).forEach(lang.hitch(this, function(node){
                    console.debug("node: " + node);
                    var option = new OptionBox(node);
                    option.load();
                    this.options.push(option);
                }));
            },
            clearOptions: function() {
                arr.forEach(this.options, lang.hitch(this, function(option){
                    option.unload();
                }));
                this.options = [];
            },
            buttonNewOption_click: function(e) {
                e.preventDefault();
                
                // create new div element for the option box
                var attributes = {
                    'class' : 'option', 
                    'innerHTML' : this.templateNode.innerHTML
                };
                var optionNode = domc.create("div", attributes, this.buttonNewOption.parentNode, "before");
                var option = new OptionBox(optionNode);
                option.load();
            }
            
        });
    
        return Shop;
    });