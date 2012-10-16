<?php

/**
 * Settings elements
 *
 * A collection of callback functions used to display input fieds on
 * WordPress admin area settings pages.
 *
 * @package Theme Toolkit
 * @subpackage Forms
 */



/**
 * Displays a text box setting
 *
 * Outputs a text input along with a description if provided.
 * 
 * @since 1.0
 * @param array $element_details Holds details for creating input box (id, name, value, description).
 */
function thtk_form_settings_text( $element_details ) {
	extract( $element_details );
	$value = isset( $value ) ?  esc_html( $value ) : '';
	
	// Displays the text input
	thtk_form_text( $name, $id, $value );

	// Displays the description if provided
	if( !empty( $description ) ) {
		thtk_form_description( $description );
	} // End if
} // End thtk_form_settings_text()



/**
 * Displays a textarea setting
 *
 * Outputs a textarea input along with a description if provided.
 * 
 * @since 1.0
 * @param array $element_details Holds details for creating input box (id, name, value, description).
 */
function thtk_form_settings_textarea( $element_details ) {
	extract( $element_details );
	$value = isset( $value ) ?  esc_html( $value ) : '';
	
	// Displays the text input
	thtk_form_textarea( $name, $id, $value );

	// Displays the description if provided
	if( !empty( $description ) ) {
		thtk_form_description( $description );
	} // End if
} // End thtk_form_settings_textarea()



/**
 * Displays a select setting
 * 
 * Outputs a select list along with a description if provided.
 *
 * @since 1.0
 * @param array $element_details Holds details for creating input box (id, name, options, value, description).
 */
function thtk_form_settings_select( $element_details ) {
	extract( $element_details );
	$value = isset( $value ) ?  esc_html( $value ) : '';

	// Displays the text input
	thtk_form_select( $name, $options, $id, $value );
	
	// Displays the description if provided
	if( !empty( $description ) ) {
		thtk_form_description( $description );
	} // End if
} // End thtk_form_settings_select()



/**
 * Displays a radio setting
 *
 * Outputs a radio button group along with a description if provided.
 * 
 * @since 1.0
 * @param array $element_details Holds details for creating input box (id, name, options, value, description).
 */
function thtk_form_settings_radio( $element_details ) {
	extract( $element_details );
	$value = isset( $value ) ?  esc_html( $value ) : '';
	
	// Displays the radio inputs
	echo '<fieldset>';
	thtk_form_radio( $name, $options, $value );
	echo '</fieldset>';

	// Displays the description if provided
	if( !empty( $description ) ) {
		thtk_form_description( $description );
	} // End if
} // End thtk_form_settings_radio()



/**
 * Displays checkbox setting
 *
 * Outputs a single checkbox input along with a description if provided.
 * 
 * @since 1.0
 * @param array $element_details Holds details for creating input box (id, name, value, description).
 */
function thtk_form_settings_checkbox( $element_details ) {
	extract( $element_details );
	
	// Displays the checkbox
	thtk_form_checkbox( $name, $label, $value );	
	
	// Displays the description if provided
	if( !empty( $description ) ) {
		thtk_form_description( $description );
	} // End if
} // End thtk_form_settings_checkbox()



/**
 * Displays a multicheck setting
 *
 * Displays a single checkbox input for a multicheck list along with a
 * description if provided. By default, the description is included with
 * only the last element in the multicheck group. 
 * 
 * @since 1.0
 * @param array $element_details Holds details for creating input box (id, name, value, description).
 */
function thtk_form_settings_multicheck( $element_details ) {
	extract( $element_details );
	
	echo '<div class="multicheck">';

	// Displays the checkbox
	thtk_form_checkbox( $name, $label, $value );
	
	echo '</div>';	
	
	// Displays the description if provided
	if( !empty( $description ) ) {
		thtk_form_description( $description );
	} // End if
} // End thtk_form_settings_multicheck()


