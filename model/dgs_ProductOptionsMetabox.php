<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_ProductAttributesMetabox
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 */
final class dgs_ProductOptionsMetabox extends dgs_Metabox {

    private $nonce_name = "dgs-products-option-meta";
    private $option_prefix = "_option_";
    private $option_name_prefix = "_optionname_";

    /**
     * Creates a new metabox instance.
     * @param DopeView $view
     * @param string $id
     * @param string $title
     * @param string $screen
     * @param string $context
     * @param string $priority 
     */
    public function __construct(DopeView $view, $screen) {
        parent::__construct($view, 'dg_shop_products_option', 'Product options', $screen, 'normal', 'high');

        add_action('save_post', array($this, 'onSave'));
    }

    public function renderMetabox($post) {

        $nonce_field = wp_nonce_field('dgs-products-save', $this->nonce_name, true, false);
        $meta = new dgs_ProductMeta($post->ID);
        //$meta->deleteAll();

        $options = $this->get_option_objects($meta);

        $this->view->assign("post", $post)
                ->assign("nonce", $nonce_field)
                ->assign("options", $options)
                ->render();
    }

    private function get_option_objects(dgs_ProductMeta $meta) {
        $keys = $meta->getKeys();
        
        if ($keys == null){
            return array();
        }
        
        $objects = array();
        foreach ($keys as $key) {
            $option = $meta->get($key);
            $obj= new stdClass();
            $obj->key = $option['key'];
            $obj->name = $option['name'];
            $obj->values = $option['options'];
            array_push($objects, $obj);
        }
        return $objects;
    }

    public function onSave($post_id) {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            // don't update on autosave
            return;
        }
        $nonce = filter_input(INPUT_POST, $this->nonce_name, FILTER_DEFAULT);

        if ($nonce === null || $nonce === false || !wp_verify_nonce($nonce, 'dgs-products-save')) {
            // invalid nonce
            return;
        }

        if (!current_user_can('edit_post')) {
            // insufficient user permission
            return;
        }

        $this->save_options($post_id, $_POST);

        //hprint_r($_POST);
        //exit;
    }

    private function save_options($post_id, $vars) {
        $meta = new dgs_ProductMeta($post_id);
        $options = array();

        // build combined key/key-name/value list from hidden form input elements
        foreach ($vars as $k => $v) {
            // if it's an option value 
            if (stripos($k, $this->option_prefix) === 0) {
                // remove prefix from key
                $key = substr($k, strlen($this->option_prefix));
                $this->add_or_update($key, array("key" => $key, "options" => $v), $options);
            }
            // if it's the option name
            if (stripos($k, $this->option_name_prefix) === 0) {
                // remove prefix from key
                $key = substr($k, strlen($this->option_name_prefix));
                $this->add_or_update($key, array("key" => $key, "name" => $v), $options);
            }
        }
        
        // save metadata
        foreach($options as $option){
            $meta->update($option["key"], serialize($option));
        }
        
        hprint_r($options, false, "options:");
        
        // get difference
        $allKeys = $meta->getKeys();
        $optionKeys = array_keys($options);
        $allKeys[] = "test_key";
        $allKeys[] = "another_deleted_key";
        
        // keys not in $optionKeys means those were deleted from the form input
        $diff = array_diff_key($allKeys, $optionKeys);
        
        // the actual delete
        foreach ($diff as $key){
            $meta->delete($key);
        }
        
        return $options;
    }

    /**
     * Creates an assoc. aray key, or updates value of an existing key by merging the values.
     * @param string $key key string
     * @param array $value_array the value to be added for the corresponding key
     * @param array $array the array to modify
     */
    private function add_or_update($key, $value_array, &$array) {
        if (array_key_exists($key, $array)) {
            $old = $array[$key];
            $array[$key] = array_merge($old, $value_array);
        } else {
            $array[$key] = $value_array;
        }
    }
}
