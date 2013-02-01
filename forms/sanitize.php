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
 * @param string $input Input data to be sanitized.
 * @param string $valid Type of text to validate against (default: text).
 * @return string Sanitized text.
 */
function thtk_sanitize_text( $input, $valid = 'text' ) {
	switch ( $valid ) {
		case 'text':
			return sanitize_text_field( $input );
			break;
		case 'html':
			return thtk_sanitize_html( $input );
			break;
		case 'url':
			return esc_url_raw( $input );
			break;
		case 'email':
			return sanitize_email( $input );
			break;
		case 'integer':
			return thtk_sanitize_integer( $input );
			break;
		case 'currency':
			return thtk_sanitize_currency( $input );
			break;
		case 'color':
			return sanitize_hex_color( $input );
			break;
			
		// Default should be unnecessary, but provided as a fallback anyway.
		default:
			return sanitize_text_field( $input );
	} // End switch $valid
} // End thtk_sanitize_text



/**
 * Sanitizes multiple choice inputs
 *
 * Sanitizes select and radio inputs based on the "choices" array set in the original options array
 *
 * @since 1.0
 * @param string $input Input data to be sanitized.
 * @param array $valid Array of allowed values.
 * @return string Valid option from $valid array matching $input, otherwise null.
 */
function thtk_sanitize_multiple_choice( $input, $valid ) {
	if( array_key_exists( $input, $valid ) ) {
		return $input;
	} // End if
}  // End thtk_sanitize_multiple_choice



/**
 * Sanitizes submitted checkbox values
 *
 * Used to sanitize a checkbox input, although it could just as easily sanitize
 * an string required to match another string. In order for a value to be
 * returned, $input must match $valid.
 *
 * @since 1.0
 * @param string $input Input data to be sanitized.
 * @return string Returns the $valid string if equal to $input, otherwise null.
 */
function thtk_sanitize_checkbox( $input ) {
	if( $input ) {
		return 'true';
	}  // End if
} // End thtk_sanitize_checkbox()



/**
 * Sanitizes HTML input
 *
 * Removes disallowed HTML tags and closes any tags that were left open. 
 *
 * @since 1.0
 * @param string $input Input data to be sanitized.
 * @return string Returns the $valid string after sanitization.
 */
function thtk_sanitize_html( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}



/**
 * Sanitizes integer input
 *
 * Returns the integer value of the $input.
 *
 * @since 1.0
 * @param string $input Input data to be sanitized.
 * @return string Returns the $valid string after sanitization.
 */
function thtk_sanitize_integer( $input ) {
	if( is_numeric( $input ) ) {
		return intval( $input );
	}
}



/**
 * Sanitizes currency input
 *
 * Returns the currency value of the $input.
 *
 * @since 1.0
 * @param string $input Input data to be sanitized.
 * @return string Returns the $valid string after sanitization.
 */
function thtk_sanitize_currency( $input ) {
	if ( is_numeric( $input ) ) {
		return $input ? number_format( $input, 2 ) : '';
	} else {
		return '';
	}
}

