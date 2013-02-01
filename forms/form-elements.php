<?php

/**
 * Form elements
 *
 * A collection of classes to display common form elements.
 *
 * @package Theme Toolkit
 * @subpackage Forms
 */

/**
 * Form input class
 *
 * @since 1.0
 */
class THTK_Form_Input {

	/**
	 * Sets default element properties
	 *
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $defaults = array(
		'id' => '', // Unique element ID.
		'name' => '', // Optional. Used if name and ID of form element should not be the
		'class' => '', // Optional. CSS class names.
		'title' => '', // Text to display as the input title/label.
		'value' => '', // Optional. The value of the input field.
		'desc' => '', // Optional. Description of form element.
		'size' => 'default', // The size of the input (small, default, large; default: default).
		'align' => 'left', // The alignment of the input (left, right; default: left).
		'before' => '', // Custom content to place before the input.
		'after' => '' // Custom content to place after the input.
	);
	
	
	
	/**
	 * Merges the arguments array with the defaults array.
	 *
	 * @since 1.0
	 * @param array $args The array of arguments to use when creating the form element.
	 */
	public function get_particulars( $args ) {
		$particulars = wp_parse_args( $args, $this->defaults );
		if( empty( $particulars[ 'name' ] ) ){
			$particulars[ 'name' ] = $particulars[ 'id' ];
		}
		return $particulars;
	} // End get_particulars()

	
	
	/**
	 * Displays the label for a form element
	 *
	 * @since 1.0
	 * @param string $label The text to display in the label.
	 * @param string $id ID of the form element to which this label belongs.
	 * @return string The HTML label element.
	 */
	public function get_label( $label, $id = '' ) {
		if ( $label ) {
			return '<label for="' . $id . '">' . $label . '</label>';
		}
	} // End get_label()


	
	/**
	 * Generates a form element description
	 *
	 * @since 1.0
	 * @param string $desc Text to display in the description.
	 * @return string The description string formatted as a paragraph.
	 */
	public function get_description( $desc ) {
		if ( $desc ) {
			return ' <p class="description">' . $desc . '</p>';
		}
	} // End get_description()



	/**
	 * Generates a text input
	 *
	 * @since 1.0
	 * @return string The HTML text input element.
	 */
	public function get_text_input( $args ) {

		// Extracts the element details array into individual variables.
		extract( $args );
		
		// Returns the output string.
		return '<input type="text" id="' . $id . '" name="' . $name . '" value="' . esc_attr( $value ) . '" class="' . esc_attr( 'option-field-' . esc_attr( $size ) . ' ' . $class ) . '" />';
	
	} // End get_text_input()
	
	
	
	/**
	 * Generates a checkbox input
	 *
	 * @since 1.0
	 * @return string The HTML checkbox input element.
	 */
	public function get_checkbox_input( $particulars ) {
	
		// Extracts the element details array into individual variables.
		extract( $particulars );
		
		// Creates a variable to hold the output string.
		$output = '';
		
		// Generates the output string.
		$output .= '<label for="' . $id . '">';
		$output .= '<input type="checkbox" id="' . $id . '" name="' . $name . '" value="true"';
		$output .= checked( $value, 'true', false );
		$output .= ' /> ';
		if( isset( $label ) ) {
			$output .= $label;
		}
		$output .= '</label><br />';
		
		// Returns the output string.
		return $output;
		
	} // End get_checkbox_input()



	/**
	 * Generates a set of radio buttons
	 *
	 * @since 1.0
	 * @return string The HTML radio button input element.
	 */
	public function get_radio_buttons( $particulars ) {
		
		// Extracts the element details array into individual variables.
		extract( $particulars );
		
		// Sets the $line_break variable if not already set.
		if( !isset( $line_break ) ) {
			$line_break = true;
		}
		
		// Creates a variable to hold the output string.
		$output = '';
		
		// Generates the output string.
		foreach ( $choices as $choice => $label ) {
			$output .= '<label for="' . $choice . '">';
			$output .= '<input type="radio" id="' . $choice . '" name="' . $name . '" value="' . $choice . '"';
			$output .= checked( $value, $choice, false );
			$output .= ' /> ' . $label . '</label>';
			if ( $line_break ) {
				$output .= '<br />';
			}
		}
		
		// Returns the output string.
		return $output;
		
	} // End get_radio_buttons()



	/**
	 * Generates a select list
	 *
	 * @since 1.0
	 * @return string The HTML select list input element.
	 */
	public function get_select_list( $particulars ) {
		
		// Extracts the element details array into individual variables.
		extract( $particulars );
		
		// Creates a variable to hold the output string.
		$output = '';
		
		// Generates the output string.
		$output = '<select id="' . $id . '" name="' . $name . '">';

		foreach ( $choices as $choice => $label ) {
			$selected = selected( $value, $choice, false );
			$output .= '<option value="' . $choice . '"' . $selected . '>' . $label . ' &nbsp;</option>';
		} // End foreach $choices

		$output .= '</select>';
		
		// Returns the output string.
		return $output;
		
	} // End get_select_list()



	/**
	 * Generates a textarea
	 *
	 * @since 1.0
	 * @return string The HTML textarea input element.
	 */
	public function get_textarea( $particulars ) {
		
		// Extracts the element details array into individual variables.
		extract( $particulars );
		
		// Creates a variable to hold the output string.
		$output = '';
		
		// Generates the output string.
		$output = '<textarea';
		$output .= ' id="' . $id . '"';
		$output .=' name="' . $name . '">';
		if ( $value ) {
			$output .= $value;
		} // End if
		$output .= '</textarea>';	
		
		// Returns the output string.
		return $output;
		
	} // End get_textarea()
	
} // End class THTK_Form_Input





/**
 * Metabox form input class
 *
 * Extends the standard form input class with formatting specific to metaboxes.
 *
 * @since 1.0
 */
class THTK_Form_Metabox extends THTK_Form_Input{
	
	/**
	 * Displays a form element with metabox formatting
	 * 
	 * @since 1.0
	 * @return string The fully formatted metabox option.
	 */
	function get_metabox( $args ) {
		
		// Sets default variables for details not defined for this element.
		$particulars = $this->get_particulars( $args );
		
		// Extracts the element details array into individual variables.
		extract( $particulars );
		
		// Creates a variable to hold the output string.
		$output = '';
		
		// Generates the output string
		$output .= '<tr class="' . esc_attr( $id ) . '"><th>';
		if ( $type == 'checkbox' || $type == 'radio' ) {
			$output .= $title;
		} else {
			$output .= $this->get_label( $title, $id );
		}
		$output .= '</th><td>';
		$output .= '<span class="' .esc_attr( $align ) . '">';
		$output .= $before;
		
		// Calls form element display functions based on the type of input field.
		switch ( $type ) {
			case 'text':
				$output .= $this->get_text_input( $particulars );
				break;
			case 'checkbox':
				$output .= $this->get_checkbox_input( $particulars );
				break;
			case 'radio':
				$output .= $this->get_radio_buttons( $particulars );
				break;
			case 'select':
				$output .= $this->get_select_list( $particulars );
				break;
			case 'textarea':
				$output .= $this->get_textarea( $particulars );
				break;
		}
		
		$output .= $after;
		$output .= '</span>';
		$output .= $this->get_description( $desc );
		$output .= '</td></tr>'."\n";
		
		// Returns the output string.
		return $output;
		
	} // End get_metabox()
	
} // End class THTK_Form_Metabox





/**
 * Formatted form input class
 *
 * Extends the standard form input class with additional formatting.
 *
 * @since 1.0
 */
class THTK_Form_Formatted extends THTK_Form_Input{
	
	/**
	 * Displays a form input with label and description fully formatted
	 *
	 * @since 1.0
	 * @return string The HTML text input element with full formatting.
	 */	
	public function get_formatted() {

		// Extracts the element details array into individual variables.
		extract( $this->particulars );
		
		// Creates a variable to hold the output string.
		$output = '';

		// Generates the output string.
		$output .= '<p class="' . esc_attr( $id ) . '">';
		$output .= $this->get_label( $title, $id );
		$output .= '<span class="' .esc_attr( $align ) . '">';
		$output .= $before;

		// Calls form element display functions based on the type of input field.
		switch ( $type ) {
			case 'text':
				$output .= $this->get_text_input();
				break;
			case 'checkbox':
				$output .= $this->get_checkbox_input();
				break;
			case 'radio':
				$output .= $this->get_radio_buttons();
				break;
			case 'select':
				$output .= $this->get_select_list();
				break;
			case 'textarea':
				$output .= $this->get_textarea();
				break;
		}

		$output .= $after;
		$output .= '</span>';
		$output .= $this->get_description( $desc );
		$output .= '</p>'."\n";

		// Returns the output string.
		return $output;
		
	} // End get_formatted()

} // End class THTK_Form_Formatted


