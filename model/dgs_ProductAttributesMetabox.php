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
final class dgs_ProductAttributesMetabox extends dgs_Metabox {

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
    }

    public function renderMetabox($post) {
        $this->view->assign("post", $post);
        $this->view->render();
    }

    public function add() {
        add_meta_box($this->id, $this->title, $this->getCallback(), $this->screen);
    }

}
