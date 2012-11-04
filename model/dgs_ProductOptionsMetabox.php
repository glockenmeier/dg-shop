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
final class dgs_ProductOptionsMetabox extends dgs_Metabox {

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
        $this->nonce_name = "dgs-product-options-meta";
        //add_action('save_post', array($this, '_doSave'));
    }

    public function renderMetabox($post) {
        //$meta->deleteAll();
        
        $this->view->assign("post", $post)
                ->assign("nonce", $this->getNonce())
                ->render();
    }

    public function onSave($post_id) {
        $meta = new dgs_ProductOptionMeta($post_id);
        $options = $this->getFormValues($this->option_name_prefix, $this->option_prefix);

        // save/update metadata
        foreach ($options as $option) {
            $meta->update($option["key"], serialize($option));
        }

        // get available meta keys for comparison
        $metaKeys = $meta->getKeys();

        // keys not in $option means those were deleted from the form input
        $diff = dgs_Utils::full_diff($metaKeys, array_keys($options));
        
        // the actual delete
        foreach ($diff as $option) {
            $meta->delete($option);
        }
    }

}
