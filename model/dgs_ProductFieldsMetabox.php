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
final class dgs_ProductFieldsMetabox extends dgs_Metabox {

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
        parent::__construct($view, 'dg_shop_products_fields', 'Product fields', $screen, 'normal', 'high');
        $this->nonce_name = "dgs-product-fields-meta";
    }

    public function renderMetabox($post) {
        $this->view->assign("post", $post)
                ->assign("nonce", $this->getNonce())
                ->render();
    }

    public function onSave($post_id) {
        $meta = new dgs_ProductFieldMeta($post_id);

        //$arr = get_post_custom($post_id);
        
        //die(DopeUtil::hprint_r($arr));
        
        // save/update metadata
        $stock = intval($_POST['_field_stock']);
        $stock = $stock < 0 ? 0 : $stock;
        $meta->update('stock', $stock);
        
        $weight = sanitize_text_field($_POST['_field_weight']);
        $meta->update('weight', $weight);
        
        $price = sanitize_text_field($_POST['_field_price']);
        $meta->update('price', $price);
    }

}
