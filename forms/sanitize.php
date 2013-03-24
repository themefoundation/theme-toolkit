<?php
/**
 * Sanitization
 *
 * This file handles the sanitation of input data.
 *
 * @package Theme Toolkit
 * @subpackage Forms
 */


/**
 * Sanitization class
 *
 * @since 1.0
 */
class THTK_Sanitization{

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
	public function sanitize_text( $input, $valid = 'text' ) {

		switch ( $valid ) {
			case 'text':
				return sanitize_text_field( $input );
				break;
			case 'html':
				return $this->sanitize_html( $input );
				break;
			case 'url':
				return esc_url_raw( $input );
				break;
			case 'email':
				return sanitize_email( $input );
				break;
			case 'integer':
				return $this->sanitize_integer( $input );
				break;
			case 'currency':
				return $this->sanitize_currency( $input );
				break;
			case 'color':
				return $this->sanitize_hex_color( $input );
				break;

			// Default should be unnecessary, but provided as a fallback anyway.
			default:
				return sanitize_text_field( $input );
		} // End switch $valid

	} // End function sanitize_text()



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
	public function sanitize_multiple_choice( $input, $valid ) {

		if( array_key_exists( $input, $valid ) ) {
			return $input;
		} // End if

	}  // End function sanitize_multiple_choice()



	/**
	 * Sanitizes checkbox inputs
	 *
	 * Used to sanitize a checkbox input, although it could just as easily sanitize
	 * an string required to match another string. In order for a value to be
	 * returned, $input must match $valid.
	 *
	 * @since 1.0
	 * @param string $input Input data to be sanitized.
	 * @return string Returns the $valid string if equal to $input, otherwise null.
	 */
	public function sanitize_checkbox( $input ) {

		if( $input ) {
			return 'true';
		}  // End if

	} // End function sanitize_checkbox()



	/**
	 * Sanitizes HTML input
	 *
	 * Removes disallowed HTML tags and closes any tags that were left open.
	 *
	 * @since 1.0
	 * @param string $input Input data to be sanitized.
	 * @return string Returns the $valid string after sanitization.
	 */
	public function sanitize_html( $input ) {
		return wp_kses_post( force_balance_tags( $input ) );
	} // End function sanitize_html()



	/**
	 * Sanitizes integer input
	 *
	 * Returns the integer value of the $input.
	 *
	 * @since 1.0
	 * @param string $input Input data to be sanitized.
	 * @return string Returns the $valid string after sanitization.
	 */
	function sanitize_integer( $input ) {
		if( is_numeric( $input ) ) {
			return intval( $input );
		} // End if
	} // End function sanitize_integer()



	/**
	 * Sanitizes currency input
	 *
	 * Returns the currency value of the $input.
	 *
	 * @since 1.0
	 * @param string $input Input data to be sanitized.
	 * @return string Returns the $valid string after sanitization.
	 */
	public function sanitize_currency( $input ) {

		if ( is_numeric( $input ) ) {
			return $input ? number_format( $input, 2 ) : '';
		} else {
			return '';
		} // End if/else

	} // End function sanitize_currency()



	/**
	 * Validates a hex color.
	 *
	 * Returns either '', a 3 or 6 digit hex color (with #), or null.
	 * This function is borrowed directly from the class_wp_customize_manager.php
	 * file in WordPress core.
	 *
	 * @since 3.4.0
	 *
	 * @param string $color
	 * @return string|null
	 */
	public function sanitize_hex_color( $color ) {

		// Returns empty string if input was an empty string.
		if ( '' === $color ) {
			return '';
		} // End if

		// Returns 3 or 6 hex digits, or the empty string.
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		} // End if

		return null;
	} // End function sanitize_hex_color()

} // End class THTK_Sanitization
