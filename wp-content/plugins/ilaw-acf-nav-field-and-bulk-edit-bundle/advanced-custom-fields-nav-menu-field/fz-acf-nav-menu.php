<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACF_Nav_Menu_Field_Plugin {

	/**
	 * Adds register hooks for the Nav Menu Field.
	 */
	public function __construct() {
		// version 4
		add_action( 'acf/register_fields', array( $this, 'register_field_v4' ) );	

		// version 5
		add_action( 'acf/include_field_types', array( $this, 'register_field_v5' ) );
	}

	/**
	 * Loads up the Nav Menu Field for ACF v4
	 */
	public function register_field_v4() {
		include_once 'nav-menu-v4.php';
	}

	/**
	 * Loads up the Nav Menu Field for ACF v5
	 */
	public function register_field_v5() {
		include_once 'nav-menu-v5.php';
	}
	
}

new ACF_Nav_Menu_Field_Plugin();
