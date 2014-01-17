<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_ProductAttributesMetabox
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
abstract class dgs_Metabox extends DopeMetabox {

    /**
     * The view
     * @var DopeView
     */
    protected $view;

    /**
     * The nonce field name (defaults to dgs_ + class name)
     * @var type 
     */
    private $nonce_name = null;
    private $nonce = null;
    /**
     * Posts with status listed here will not trigger {@see dgs_Metabox::onSave() }
     * @var array
     */
    protected $unwanted_status = null;

    /**
     * Creates a new metabox instance.
     * @param DopeView $view
     * @param string $id
     * @param string $title
     * @param string $screen
     * @param string $context
     * @param string $priority 
     */
    public function __construct(DopeView $view, $id, $title, $screen = null, $context = 'advanced', $priority = 'default') {
        parent::__construct($id, $title, $screen, $context, $priority);
        $this->view = $view;
        add_action('save_post', array($this, '_doSave'));
    }

    protected function get_nonce_name() {
        // create nonce name based on class name
        $r = new ReflectionClass($this);
        return $r->getName();
    }

    protected function create_nonce($action = 'onSave') {
        if ($this->nonce_name === null) {
            $this->nonce_name = $this->get_nonce_name();
        }
        return wp_nonce_field(esc_attr($action), $this->nonce_name, true, false);
    }

    protected function verify_nonce($action = 'onSave') {
        $this->nonce_name = $this->get_nonce_name();
        $nonce = filter_input(INPUT_POST, $this->nonce_name, FILTER_DEFAULT);
        if ($nonce === null || $nonce === false || !wp_verify_nonce($nonce, $action)) {
            // invalid nonce
            return false;
        }
        return true;
    }

    /**
     * Callback function for save_post action.
     * @param type $post_id the post id
     * @uses dgs_Metabox::$unwanted_status post with given status gets filtered out
     * @uses add_action() as callback
     * @return void
     */
    public function _doSave($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return; // we're ignoring autosave
        }

        $dpost = DopePost::get($post_id);

        if ($dpost->getType() !== $this->screen) {
            return; // wrong post type
        }

        if ($this->unwanted_status === null) {
            // set defaults
            $this->unwanted_status = array(
                // NOTE: while on auto-draft , meta-cap is not ready so calling current_user_can() will result in PHP notice: calling non-property on object
                'auto-draft',// a newly created post, with no content
                'trash', // post is in trashbin. added with Version 2.9. no reason to save before trashing.
                'inherit' // a revision. see get_children. revision should not be changed.
            );
        }

        if (in_array($dpost->getStatus(), $this->unwanted_status)) {
            return; // nothing to save
        }
        
        if (!current_user_can('edit_post_meta')) {
            return; // insufficient user permission
        }

        if ($this->verify_nonce()) {
            // call onSave only if nonce is valid
            $this->onSave($post_id);
        }
    }

    public function _doRenderMetabox($post) {
        $this->nonce = $this->create_nonce();
        parent::_doRenderMetabox($post);
    }

    protected function getNonce() {
        return $this->nonce;
    }

    protected abstract function onSave($post_id);

    /**
     * Get key/value pair from $_POST by their prefix
     * @param string $name_prefix prefix for name input
     * @param string $value_prefix prefix for value(s) input
     * @return array an associative array containing key, name and value
     */
    protected function getFormValues($name_prefix, $value_prefix) {
        $values = array();
        // build combined key/key-name/value list from hidden form input elements
        foreach ($_POST as $k => $v) {
            // sanitize k/v from $_POST
            if (is_array($v)){
               $v = array_map('sanitize_text_field', $v);
            }else {
                sanitize_text_field($v);
            }

            // if it's an option value 
            if (stripos($k, $value_prefix) === 0) {
                // remove prefix from key
                $key = substr($k, strlen($value_prefix));
                $this->add_or_update($key, array("key" => $key, "options" => $v), $values);
            }
            
            // if it's the option name
            if (stripos($k, $name_prefix) === 0) {
                // remove prefix from key
                $key = substr($k, strlen($name_prefix));
                $this->add_or_update($key, array("key" => $key, "name" => $v), $values);
            }
        }
        return $values;
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
