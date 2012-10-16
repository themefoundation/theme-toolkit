<?php

/**
 * Sanitization functions
 *
 * This file contains a number of different functions for sanitizing
 * different types of data.
 *
 * @package Theme Toolkit
 * @subpackage Forms
 */



/**
 * Sanitizes text inputs
 *
 * Sanitizes text input based on the "valid" property set in the original options
 * array. Defaults to "text" if $valid isn't set. Please note that this will strip
 * html tags from input before saving if $valid is left unset.
 *
 * @since 1.0
 * @param string $input Input data to be sanitized
 * @param string $valid Type of text to validate against (default: text)
 * @return string Sanitized text
 */
function thtk_sanitize_text( $input, $valid = 'text' ) {
	switch ( $valid ) {
		case 'text':
			return sanitize_text_field( $input );
			break;
		case 'html':
			return wp_kses_post( force_balance_tags( $input ) );
			break;
		case 'url':
			return esc_url_raw( $input );
			break;
		case 'email':
			return sanitize_email( $input );
			break;
		case 'integer':
			return $input ? intval( $input ) : '';
			break;
		case 'currency':
			return $input ? number_format( $input, 2 ) : '';
			break;
			
		// Default should be unnecessary, but provided as a fallback anyway.
		default:
			return sanitize_text_field( $input );
	} // End switch $valid
} // End thtk_sanitize_text



/**
 * Sanitizes multiple choice inputs
 *
 * Sanitizes select and radio inputs based on the "valid" property set in the original options array
 *
 * @since 1.0
 * @param string $input Input data to be sanitized
 * @param array $valid Array of allowed values
 * @return string Valid option from $valid array matching $input, otherwise null
 */
function thtk_sanitize_multiple_choice( $input, $valid ) {
	if( in_array( $input, $valid ) ) {
		return $input;
	} // End if
}  // End thtk_sanitize_multiple_choice



/**
 * Sanitizes checkbox inputs
 *
 * Sanitizes checkbox input based on the "valid" property set in the original options array
 *
 * @since 1.0
 * @param string $input Input data to be sanitized
 * @param string $valid String to compare against $input
 * @return string Returns the $valid variable if equal to $input, otherwise null
 */
function thtk_sanitize_checkbox( $input, $valid ) {
	if( $input == $valid ) {
		return $valid;
	}  // End if
} // End thtk_sanitize_checkbox()

