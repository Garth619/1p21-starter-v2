<?php
/********************************************************************************************
* setup acf fields
*********************************************************************************************/

//make a page
function _ilaw_sm_make_opt_page(){
	if( function_exists('acf_add_options_page') ) {
	
		acf_add_options_page(array(
		'page_title' 	=> __('iLawyer Sidebars Settings'),
		'menu_title'	=> __('iLawyer Sidebars Settings'),
		'menu_slug' 	=> 'ilaw-sidebar-options',
		'capability'	=> 'edit_posts',
		'redirect'	=> false,
		'icon_url'	=> 'dashicons-menu-alt'
		));
}
}

add_action( 'plugins_loaded', '_ilaw_sm_make_opt_page' );
function _ilaw_sm_load_acf(){
	if(function_exists('acf_add_local_field_group')){
		//register them
		include_once _ILAW_SM_PLUGIN_PATH . '/fields/fields.php';

		acf_add_local_field_group($_ilaw_sm_page_fields);
		acf_add_local_field_group($_ilaw_sm_opts_fields);


		//get mod dates

		$fields_mod = filemtime(_ILAW_SM_PLUGIN_PATH . '/fields/fields.php');
		$json_mod = filemtime(_ILAW_SM_PLUGIN_PATH . '/fields/acf-sm-fields.json');

		
		//update json on changes for ability to edit
		if(
			($fields_mod > $json_mod)
			and function_exists('acf_get_local_fields')
			and is_admin()
		){

			$groups = acf_get_local_field_groups(
				array(
					$_ilaw_sm_page_fields['key'],
					$_ilaw_sm_opts_fields['key']
				)
			); //taken from files mentioned above

			$json = [];

			foreach ($groups as $group) {
				// Fetch the fields for the given group key
				$fields = acf_get_local_fields($group['key']);

				// Remove unecessary key value pair with key "ID"
				unset($group['ID']);

				// Add the fields as an array to the group
				$group['fields'] = $fields;

				// Add this group to the main array
				$json[] = $group;
			}

			$json = json_encode($json, JSON_PRETTY_PRINT);

			// Write output to file for easy import into ACF.
			// The file must be writable by the server process. In this case, the file is located in
			// the current theme directory.
			$file =  _ILAW_SM_PLUGIN_PATH . 'fields/acf-sm-fields.json';
			file_put_contents($file, $json );
		}
	}
}
add_action('acf/init', '_ilaw_sm_load_acf');


//sidebar name validation
function _ilaw_sm_validate_unique_repeater( $valid, $value, $field, $input ) {
	// bail early if value is already invalid
	if( !$valid ) {
		return $valid;
	}

	//https://support.advancedcustomfields.com/forums/topic/avoid-duplicate-content-on-repeater-field/
	// get list of array indexes from $input
	// [ <= this fixes my IDE, it has problems with unmatched brackets
	preg_match_all('/\[([^\]]+)\]/', $input, $matches);
	if (!count($matches[1])) {
		// this should actually never happen
		return $valid;
	}
	$matches = $matches[1];

	// walk the acf input to find the repeater and current row      
	$array = $_POST['acf'];

	$repeater_key = false;
	$repeater_value = false;
	$row_key = false;
	$row_value = false;
	$field_key = false;
	$field_value = false;
  
	for ($i=0; $i<count($matches); $i++) {
		if (isset($array[$matches[$i]])) {
			$repeater_key = $row_key;
			$repeater_value = $row_value;
			$row_key = $field_key;
			$row_value = $field_value;
			$field_key = $matches[$i];
			$field_value = $array[$matches[$i]];
			if ($field_key == $field['key']) {
			break;
			}
			$array = $array[$matches[$i]];
		}
	}

	if (!$repeater_key) {
		// this should not happen, but better safe than sorry
		return $valid;
	}
	//check if it's like blog or default sidebar
	// look for duplicate values in the repeater
	foreach ($repeater_value as $index => $row) {
		if ($index != $row_key && $row[$field_key] == $value) {
			// this is a different row with the same value
			$valid = 'this value is not unique';
			break;
		}
	}
	
	// return
	return $valid;
}
add_filter('acf/validate_value/key=field_5cc0984cf5836', '_ilaw_sm_validate_unique_repeater', 20, 4);
