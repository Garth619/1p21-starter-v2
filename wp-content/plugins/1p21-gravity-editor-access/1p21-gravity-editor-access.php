<?php
/*
Plugin Name: 1POINT21 Gravity Forms Editor Entries Access
Plugin URI: https://www.1point21interactive.com/
Description: Allow Editors access to Gravity Forms
Version: 0.1
Author: Derrick Tran
Copyright: Derrick Tran
*/

register_activation_hook( __FILE__, 'child_gravity_editor_activate' );

function child_gravity_editor_activate(){

    // Require parent plugin
    if ( ! is_plugin_active( 'gravityforms/gravityforms.php' ) and current_user_can( 'activate_plugins' ) ) {
        // Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires Gravity Forms Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}

function activate_1p21_gravity_editor_access() {
  
  $role = get_role( 'editor' );
  $role->add_cap( 'gravityforms_view_entries' );
  $role->add_cap( 'gravityforms_view_entry_notes' );
  $role->add_cap( 'gravityforms_edit_entries' );
  $role->add_cap( 'gravityforms_edit_entry_notes' );
  $role->add_cap( 'gravityforms_delete_entries' );
  $role->add_cap( 'gravityforms_export_entries' );

}

// Register our activation hook
register_activation_hook( __FILE__, 'activate_1p21_gravity_editor_access' );

/**
 * Remove Gravity Forms capabilities from Editor role.
 * Runs during plugin deactivation.
 * 
 * @access public
 * @return void
 */

function deactivate_1p21_gravity_editor_access() {
 
 $role = get_role( 'editor' );
 $role->remove_cap( 'gravityforms_view_entries' );
 $role->remove_cap( 'gravityforms_view_entry_notes' );
 $role->remove_cap( 'gravityforms_edit_entries' );
 $role->remove_cap( 'gravityforms_edit_entry_notes' );
 $role->remove_cap( 'gravityforms_delete_entries' );
 $role->remove_cap( 'gravityforms_export_entries' );
}

// Register our de-activation hook
register_deactivation_hook( __FILE__, 'deactivate_1p21_gravity_editor_access' );

?>