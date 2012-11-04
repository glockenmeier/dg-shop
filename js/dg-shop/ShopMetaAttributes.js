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
    "dg-shop/AttributeBox"
    ], function(declare, lang, arr, dom, domc, query, on, obj, AttributeBox){
        var Shop = declare(obj, {
            metabox: null,
            templateNode: null,
            newRowNode: null,
            buttonNewAttribute: null,
            attributes: [], // contains all attribute objects
            
            
            constructor: function(metabox_id) {
                this.metabox = dom.byId(metabox_id);
            },
            load: function() {
                this.templateNode = dom.byId("dg_shop_attribute_template");
                this.buttonNewAttribute = dom.byId("dg_shop_new_attribute");
                this.newRowNode = dom.byId("dg_shop_new_attribute_row");
                
                this.registerAttributes();
                
                on(this.buttonNewAttribute, "click", lang.hitch(this, this.buttonNewAttribute_click));
                
                return true;
            },
            unload: function() {
                return true;
            },
            registerAttributes: function(){
                this.options = [];
                query(".attribute", this.metabox).forEach(lang.hitch(this, function(node){
                    var attr = new AttributeBox(node);
                    attr.load();
                    this.attributes.push(attr);
                }));
            },
            clearAttributes: function() {
                arr.forEach(this.attributes, lang.hitch(this, function(attr){
                    attr.unload();
                }));
                this.attributes = [];
            },
            buttonNewAttribute_click: function(e) {
                e.preventDefault();
                console.info("new attr click");
                // create new div element for the option box
                var attributes = {
                    'class' : 'attribute', 
                    'innerHTML' : this.templateNode.innerHTML
                };
                var attributeNode = domc.create("tr", attributes, this.newRowNode, "before");
                var attr = new AttributeBox(attributeNode);
                console.info(attr);
                attr.load();
            }
            
        });
    
        return Shop;
    });