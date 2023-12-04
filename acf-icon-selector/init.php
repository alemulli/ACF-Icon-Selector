<?php
/**
 * Registration logic for the new ACF field type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'leadpoint_digital_include_acf_field_icon_selector' );
/**
 * Registers the ACF field type.
 */
function leadpoint_digital_include_acf_field_icon_selector() {
	if ( ! function_exists( 'acf_register_field_type' ) ) {
		return;
	}

	require_once __DIR__ . '/class-leadpoint-digital-acf-field-icon-selector.php';

	acf_register_field_type( 'leadpoint_digital_acf_field_icon_selector' );
}
