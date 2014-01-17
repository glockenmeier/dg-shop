<?php
/*
if (!function_exists('dg_oo_plugin_dependency_check')):

    function dg_oo_plugin_dependency_check($required_dope_version, $plugin_name) {
    
        $error_message = 
            sprintf("<p>%s requires DG's Object-oriented Plugin Extension version %s or later.</p>", 
                    $plugin_name, $required_dope_version);
        // check wether dope requirements are met. fails otherwise
        if (!defined('DOPE_PLUGIN')) {
            trigger_error($error_message, E_USER_ERROR);
        } else if (DopeUtil::check_version($required_dope_version) == false) {
            trigger_error($error_message, E_USER_ERROR);
        }
    }

endif;
dg_oo_plugin_dependency_check("0.3.0", "DG's Shop Lite");
 */
// TODO: this need to be checked on activate, not every time!

$dope_depend_msg = "This plugin depends on \"dope\" plugin version 0.3.1 or later";
if (!defined('DOPE_PLUGIN')) {
    trigger_error($dope_depend_msg, E_USER_ERROR);
} else if ((version_compare(DOPE_PLUGIN_VERSION, "0.3.1") >= 0) == false) {
    trigger_error($dope_depend_msg, E_USER_ERROR);
}