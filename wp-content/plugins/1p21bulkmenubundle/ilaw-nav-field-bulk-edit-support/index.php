<?php

define('_ILAW_SM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define('_ILAW_SM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define('_ILAW_SM_PLUGIN_BASENAME',plugin_basename(__FILE__));


$GLOBALS['_ilaw'] = array();

$GLOBALS['_ilaw']['defaults'] = array(
	'title_tag' => 'h3',
	'menu_depth' => 0,
	'default_title' => 'Useful Links'
);


// functions that can be reused
require_once _ILAW_SM_PLUGIN_PATH . 'includes/helpers.php';

//setup quick edit shit
require_once _ILAW_SM_PLUGIN_PATH . 'includes/setup-columns.php';

//set up acf fields for sidebar ad shit
require_once _ILAW_SM_PLUGIN_PATH . 'includes/register-fields.php';

//set up sidebars from all this shit
require_once _ILAW_SM_PLUGIN_PATH . 'includes/register-sidebars.php';