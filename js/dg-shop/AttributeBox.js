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
 * Module       : dg-shop/OptionBox
 * Author       : Darius Glockenmeier
 * Description  : Provides functionality for the individual products Option Box
 */

define([
    // dependencies
    "dojo/_base/declare",
    "dojo/_base/lang",
    "dojo/dom-construct",
    "dojo/dom-class",
    "dojo/query",
    "dojo/dom-attr",
    "dojo/on",
    "dg-shop/Object",
    ], function(declare, lang, domConstruct, domClass, query, attr, on, Object){
        return declare(Object, {
            btnAddAttribute: null,
            txtNewAttribute: null,
            txtNewValue: null,
            btnDelete: null,
            attributeName: null,
            handles: null, // list of event handles
            
            constructor: function(node) {
                this.node = node;
                this.handles = [];
            // TODO: input: cancel on enter / prevent submit
            },
            load: function() {
                
                /* get references */
                this.btnAddAttribute = query('.add_new_attribute button.add', this.node)[0];
                this.txtNewAttribute = query('.add_new_attribute input', this.node)[0];
                this.btnDelete = query('.add_new_attribute button.delete', this.node)[0];
                
                // fill optionName if already set
                this.attributeName = this.txtNewAttribute.value.length > 0 ? this.txtNewAttribute.value : null;
                
                this.txtNewValue = query('.add_new_value textarea', this.node)[0];

                /* bind events */
                if (this.btnAddAttribute !== undefined && !domClass.contains(this.btnAddAttribute, "hidden")){
                    this.handles.push(on(this.btnAddAttribute, "click", lang.hitch(this, this.btnAddAttribute_click)));
                }
                this.handles.push(on(this.btnDelete, "click", lang.hitch(this, this.btnDelete_click)));
                this.handles.push(on(this.txtNewAttribute, "keyup", lang.hitch(this, this.txtNewAttribute_keyup)));
                
                return true;
            },
            unload: function() {
                this.handles.forEach(function(handle){
                    handle.remove();
                }, this);
                
                return true;
            },
            alreadySet: function(e){
                // switch button to added state
                domClass.add(this.btnAddAttribute, "hidden");
                attr.remove(this.txtNewValue, "disabled");
            },
            btnDelete_click: function(e) {
                e.preventDefault();
                
                this.attributeName = null;
                // cleanup
                domConstruct.destroy(this.node);
                this.unload();
            },
            btnAddAttribute_click: function(e) {
                e.preventDefault();
                
                if (this.attributeName == null){
                    this.attributeName = this.txtNewAttribute.value;
                    
                    // write the attribute key & name
                    var name_key = '_attrname_' + this.attributeName;
                    attributes = {
                        'id': name_key,
                        'name': name_key
                    };
                    attr.set(this.txtNewAttribute, attributes);
                    
                    // write the actual value
                    var value_key = '_attr_' + this.attributeName;
                    attributes = {
                        'id': value_key,
                        'name': value_key
                    };
                    attr.set(this.txtNewValue, attributes);
                    console.info("Key: " + value_key);
                    console.debug(this.txtNewValue);
                    this.alreadySet(e);
                    
                }
            },
            txtNewAttribute_keyup: function(e) {
                this.toggleDisabled(this.btnAddAttribute, this.txtNewAttribute);
                return true;
            },
            /**
             * Enable / disables button depending on the input text value
             */
            toggleDisabled: function(btnNode, txtNode){
                if (txtNode.value.length < 2 && (attr.has(btnNode, 'disabled') == false || attr.has(btnNode, 'disabled') == null)){
                    this.setDisabled(btnNode, true);
                }else if (txtNode.value.length > 1 && attr.has(btnNode, 'disabled') == true){
                    this.setDisabled(btnNode, false);
                }
            },
            /**
             * Set the disabled state of the given node.
             */
            setDisabled: function(node, disable){
                if (disable){
                    attr.set(node, "disabled", "disabled");
                }else{
                    attr.remove(node, "disabled");
                }
            }
        });
    
    });