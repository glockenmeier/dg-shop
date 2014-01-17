<?php

/*
 * Copyright Error: on line 3, column 16 in Templates/Scripting/EmptyPHP.php
Expecting a date here, found: 28.09.2013, Darius Glockenmeier.
 * 
 * Description of dgs_AdminSettingsSection
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 * 
 */
class dgs_AdminSettingsSection extends DopeSettingsSection {
    private $plugin;
    
    public function __construct(DopePlugin $plugin) {
        parent::__construct("Test", "Products");
        $this->plugin = $plugin;
    }
    
    public function render() {
        $view = new SimpleDopeView($this->plugin->getDirectory());
        $view->render('settings/admin/product-section');
    }
}