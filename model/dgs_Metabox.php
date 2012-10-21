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
class dgs_Metabox extends DopeMetabox {

    /**
     * The view
     * @var DopeView
     */
    protected $view;

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
    }

    public function renderMetabox($post) {
        $this->view->assign("post", $post);
        $this->view->render();
    }

}
