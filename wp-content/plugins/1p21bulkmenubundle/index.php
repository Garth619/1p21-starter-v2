<?php
/*
Plugin Name: Nav Menu ACF +  Bulk Edit + Nav Menu Bulk Edit Support
Author: Sam Zabala
Plugin URI: https://www.ilawyermarketing.com/
Version: 2.0.4
Description: Requires ACF, to work. sets up ACF field type for nav fields. Adds bulk editing functionality for native acf and nav menu field. <b>PLEASE READ <i>fordev.txt</i></b> SHOULD ONE OF THE PLUGINS REQUIRE AN UPDATE
Copyright: Yes
*/

function _ilaw_bundle_create_admin_error($message,$notice_type = 'error'){
	$class = 'notice notice-'.$notice_type;
	$parsed_message = __( $message );
	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), strip_tags( $parsed_message,"<br><pre><code><br/><strong><b><i><em><p><strong>" ) ); 
}

function _ilaw_sm_check_for_acf(){
	// if acf isnt even installed just kill it. kill it with fire. before it kills the site. because it will definitley kill the site.
	if(!class_exists( 'ACF' ) ){
		if(current_user_can( 'activate_plugins' )){
			wp_die('Advanced Custom Fields PRO is not installed. iLawyer needs this plugin to work <a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
		}
        deactivate_plugins( plugin_basename( __FILE__ ) );
	}
}


register_activation_hook(__FILE__,'_ilaw_sm_check_for_acf');


	
// ACF NAV menu Field
if(!class_exists( 'ACF_Nav_Menu_Field_Plugin' ) ){
	require_once plugin_dir_path( __FILE__ ) . '/advanced-custom-fields-nav-menu-field/fz-acf-nav-menu.php';

}else{
	add_action('admin_notices',function(){
		_ilaw_bundle_create_admin_error('iLawyer bundle plugin is activated but advanced-custom-fields-nav-menu-field is already installed','warning is-dismissable');
	});
}

//Bulk edit
if(!function_exists( 'ACFQuickEdit\__autoload' ) ){
	//Bulk edit
	require_once plugin_dir_path( __FILE__ ) . '/acf-quick-edit-fields/index.php';
	
}else{
	add_action('admin_notices',function(){
		_ilaw_bundle_create_admin_error('iLawyer bundle plugin is activated but acf-quick-edit-fields is already installed.  As of 09 2019, if acf-quick-edit-fields version is greater than 2.4.19, it is strongly recommended to uninstall','error is-dismissable');
	});
};


require_once plugin_dir_path( __FILE__ ) . '/ilaw-nav-field-bulk-edit-support/index.php';