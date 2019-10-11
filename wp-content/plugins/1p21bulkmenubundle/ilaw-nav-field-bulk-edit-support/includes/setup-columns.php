<?php
//ADD SUPPORT TO NAV FIELD
add_filter('acf_quick_edit_fields_types','_ilaw_sm_add_nav_menu_supported_shit');
function _ilaw_sm_add_nav_menu_supported_shit($types){
	// add support for table fields. The array key is just the field type...
	//give field the options where to display
	$types['nav_menu'] = [ //from the plugin that set the nav acf field type
		'column' => true,
		'quickedit' => true,
		'bulkedit' => true
	];
	return $types;
}

add_filter( 'acf_quick_edit_sortable_column_nav_menu', function( $sort ){
	return true;
});

//and now make them options or select field apear where they need to oh god im gonna need an adult

//display in the column the value
add_filter('acf_qef_column_html_nav_menu','_ilaw_sm_render_admin_column_content', 10, 3 );
function _ilaw_sm_render_admin_column_content( $html, $object_id, $acf_field ){
	$ilaw_set_menu = wp_get_nav_menu_object(get_field( $acf_field['key'], $object_id, false ));
	return '<p>' .  $ilaw_set_menu->name  . '</p>';
}


//editable form field or some shit 
add_filter('acf_qef_input_html_nav_menu','_ilaw_sm_render_admin_select_fields', 10, 4 );
function _ilaw_sm_render_admin_select_fields( $html, $input_atts, $is_quickedit, $acf_field ){
	// the $input_atts arg already holds the necessary attributes like 'name', 'id', and such
	$input_atts += array(
		'class'	=> 'nav-menus',
	);

	
	$allow_null = $acf_field['allow_null'];
	
	$navs = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	$nav_menus = array();

	if ( $allow_null ) {
		$nav_menus[''] = ' - Select - ';
	}

	foreach ( $navs as $nav ) {
		$nav_menus[ $nav->term_id ] = $nav->name;
	}
	

	$field_string = "<select ".acf_esc_attr( $input_atts ).">";
	foreach( $nav_menus as $id => $name ) :
		$field_string .= "<option value='{$id}' ";
		if ( wp_get_nav_menu_object(get_field( $acf_field['key'], $object_id, false ))->term_id == $id ) {
			$field_string .= " selected";
		}
		$field_string .= " >";
			$field_string .= esc_html( $name );
		$field_string .= "</option>";
	endforeach;
	$field_string .= "</select>";


// We know ACF 5+ is active. So using acf_esc_attr() shouldn't be a problem
return $field_string;

}

//make that form field actually work
add_action('admin_enqueue_scripts','_ilaw_sm_add_admin_inline_script');
function _ilaw_sm_add_admin_inline_script(){
	$script = "
		(function($,qe){
			qe.field.add_type( {
				type: 'nav_menu',
				initialize: function() {
					
					console.log(this);
					this.\$input = this.$('select').prop('readonly', !0)
					qe.field.View.prototype.initialize.apply(this, arguments);
				},
			} );
		})( jQuery, window.acf_quickedit );";

	wp_add_inline_script( 'acf-quickedit', $script, 'after');
}

//save the changes

add_action( 'acf_qef_update_nav_menu', '_ilaw_sm_update_fields', 10, 3 );
function _ilaw_sm_update_fields( $value, $object_id, $acf_field ){
	update_field( $acf_field['key'], $value, $object_id );
}