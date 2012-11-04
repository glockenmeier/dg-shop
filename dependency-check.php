<?php

if (!function_exists('dg_oo_plugin_dependency_check')):

    function dg_oo_plugin_dependency_check($required_dope_version, $plugin_name) {
    
        $error_message = "<p>%s requires DG's Object-oriented Plugin Extension version %s or later.</p>";
        // check wether dope requirements are met. fails otherwise
        if (!defined('DOPE_PLUGIN')) {
            exit(printf($error_message, $plugin_name, $required_dope_version));
        } else if (DopeUtil::check_version($required_dope_version) == false) {
            exit(printf($error_message, $plugin_name, $required_dope_version));
        }
    }

endif;
dg_oo_plugin_dependency_check("0.3.0", "DG's Shop Lite");