<?php

$required_dope_version = "0.0.3"; // your required dope version here
$plugin_name = "DG's Shop Lite"; // TODO: get plugin name from metadata

$error_message = "<p>%s requires DG's Object-oriented Plugin Extension version %s or later.</p>";
// check wether dope requirements are met. fails otherwise
if (!defined('DOPE_PLUGIN')) {
    exit(printf($error_message, $plugin_name, $required_dope_version));
} else if (DopeUtil::check_version($required_dope_version) == false) {
    exit(printf($error_message, $plugin_name, $required_dope_version));
}
