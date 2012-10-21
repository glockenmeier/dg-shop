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
    "dojo/dom",
    "dojo/dom-construct",
    "dojo/query",
    "dojo/dom-attr",
    "dojo/on",
    "dg-shop/Object",
    ], function(declare, lang, dom, domc, query, attr, on, Object){
        return declare(Object, {
            btnNewOption: null,
            txtNewOption: null,
            btnNewValue: null,
            txtNewValue: null,
            optionName: null,
            inputSelect: null,
            handles: null, // list of event handles
            
            constructor: function(node) {
                this.node = node;
                this.handles = [];
            // TODO: input: cancel on enter / prevent submit
            },
            load: function() {
                
                /* get references */
                this.btnNewOption = query('.add_new_option button', this.node)[0];
                this.txtNewOption = query('.add_new_option input', this.node)[0];
                
                // fill optionName if already set
                this.optionName = this.txtNewOption.value.length > 0 ? this.txtNewOption.value : null;
                
                this.btnNewValue = query('.add_new_value button', this.node)[0];
                this.txtNewValue = query('.add_new_value input', this.node)[0];
                
                this.inputSelect = query('select[name="options"]', this.node)[0];
                
                /* bind events */
                this.handles.push(on(this.btnNewOption, "click", lang.hitch(this, this.btnNewOption_click)));
                this.handles.push(on(this.btnNewValue, "click", lang.hitch(this, this.btnNewValue_click)));
                
                this.handles.push(on(this.txtNewOption, "keyup", lang.hitch(this, this.txtNewOption_keyup)));
                this.handles.push(on(this.txtNewValue, "keyup", lang.hitch(this, this.txtNewValue_keyup)));
                
                return true;
            },
            unload: function() {
                this.handles.forEach(function(handle){
                    handle.remove();
                }, this);
                
                return true;
            },
            alreadySet: function(e){
                // switch button to delete state
                this.setDisabled(this.txtNewOption, true);
                this.setDisabled(this.txtNewValue, false);
                attr.set(this.btnNewOption, {
                    "style": "color: red;", 
                    "title": "Delete this option"
                });
                this.btnNewOption.innerHTML = "X";
            },
            btnDelete_click: function(e) {
                e.preventDefault();
                
                this.optionName = null;
                // cleanup
                domc.destroy(this.node);
                this.unload();
            },
            btnNewOption_click: function(e) {
                e.preventDefault();
                
                if (this.optionName == null){
                    this.optionName = this.txtNewOption.value;
                    
                    // write the option key & name
                    var name_key = '_optionname_' + this.optionName;
                    attributes = {
                        'type': 'hidden',
                        'id': name_key,
                        'name': name_key ,
                        'value': this.optionName
                    };
                    
                    var valuesNode = query("div .dg_shop_values")[0];
                    domc.create("input", attributes, valuesNode, "first");
                    
                    this.deleteState(e);
                    
                }
            },
            btnNewValue_click: function(e) {
                e.preventDefault();
                var n = this.txtNewValue;
                if (n.value.length > 0){
                    var attributes = {
                        'value': n.value,
                        'innerHTML': n.value
                    };
                    // create visual option for user
                    domc.create("option", attributes, this.inputSelect, "first");
                    
                    // write the actual value
                    attributes = {
                        'type': 'hidden',
                        'name': '_option_' + this.optionName + '[]',
                        'value': n.value
                    };
                    
                    var valuesNode = query("div .dg_shop_values")[0];
                    domc.create("input", attributes, valuesNode, "first");
                    
                    // reset value input node
                    n.value = "";
                }
            },
            txtNewOption_keyup: function(e) {
                this.toggleDisabled(this.btnNewOption, this.txtNewOption);
                return true;
            },
            txtNewValue_keyup: function(e) {
                this.toggleDisabled(this.btnNewValue, this.txtNewValue);
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