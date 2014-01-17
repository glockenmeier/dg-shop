<?php

/*
 * Copyright 2013, Darius Glockenmeier.
 */

/**
 * Description of dgs_AdminSettingsInput
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 */
class dgs_AdminSettingsInput extends DopeSettingsField {
    private $plugin;
    
    public function __construct(DopePlugin $plugin){
        parent::__construct('checkbox_test', "Checkbox test");
        $this->plugin = $plugin;
    }
    public function render(){
        $view = new SimpleDopeView($this->plugin->getDirectory());
        $view->assign('name', $this->option)
            ->assign('checked', checked(1, get_option($this->option), false))
            ->assign('text', $this->description)
            ->render('settings/admin/checkbox');
    }
}
