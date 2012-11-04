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
final class dgs_ProductAttributesMetabox extends dgs_Metabox {

    private $attr_prefix = "_attr_";
    private $attr_name_prefix = "_attrname_";

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
        parent::__construct($view, 'dg_shop_products_attributes', 'Product attributes', $screen, 'normal', 'high');
        $this->nonce_name = "dgs-product-attributes-meta";
    }

    public function renderMetabox($post) {
        $this->view->assign("post", $post)
                ->assign("nonce", $this->getNonce())
                ->render();
    }

    public function onSave($post_id) {
        $meta = new dgs_ProductAttributeMeta($post_id);
        $attributes = $this->getFormValues($this->attr_name_prefix, $this->attr_prefix);

        // save/update metadata
        foreach ($attributes as $attr) {
            $meta->update($attr["key"], serialize($attr));
        }

        // get available meta keys for comparison
        $metaKeys = $meta->getKeys();
        
        // keys not in $option means those were deleted from the form input
        $diff = dgs_Utils::full_diff($metaKeys, array_keys($attributes));
        // the actual delete
        foreach ($diff as $attr) {
            $meta->delete($attr);
        }
    }

}
