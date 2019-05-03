<?php
/*
Plugin Name: Nav Menu ACF +  Bulk Edit + Nav Menu Bulk Edit Support
Author: Sam Zabala
Plugin URI: https://www.ilawyermarketing.com/
Version: 1.0.0
Description: Requires ACF, to work. sets up ACF field type for nav fields. Adds bulk editing functionality for native acf and nav menu field. <b>PLEASE READ <i>README.TXT</i></b> SHOULD ONE OF THE PLUGINS REQUIRE AN UPDATE
Copyright: Yes
*/


// ACF NAV menu Field
require_once plugin_dir_path( __FILE__ ) . '/advanced-custom-fields-nav-menu-field/fz-acf-nav-menu.php';

//Bulk edit
require_once plugin_dir_path( __FILE__ ) . '/acf-quick-edit-fields-master/index.php';

// nav acf bulk edit support
require_once plugin_dir_path( __FILE__ ) . '/ilaw-nav-field-bulk-edit-support/index.php';