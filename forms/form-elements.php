<?php

/**
 * Form elements
 *
 * A collection of functions that display common form elements.
 *
 * @package Theme Toolkit
 * @subpackage Forms
 */



/**
 * Displays a form label
 *
 * Outputs an HTML form label.
 * 
 * @since 1.0
 * @param string $label Text to display in the label.
 * @param string $for Name of the form element to which this label belongs.
 */
function thtk_form_label( $label, $for = '' ) {
	$html = '<label';
	
	if ( !empty ( $for ) ) {
		$html .= ' for="' . $for . '"';
	}
	
	$html .= '>' . $label . ' </label>';
	echo $html;
}  // End thtk_form_label()



/**
 * Displays a text input
 *
 * Outputs an HTML form text box input.
 * 
 * @since 1.0
 * @param string $name Name property for the text box.
 * @param string $id ID property for the text box.
 * @param string $value Text string to place in the text box.
 */
function thtk_form_text( $name, $id = '', $value = '' ) {
	$html = '<input type="text"';
	
	if ( !empty ( $id ) ) {
		$html .= ' id="' . $id . '"';
	}
	
	$html .= ' name="' . $name . '"';
	
	if ( !empty ( $value ) ) {
		$html .= ' value="' . $value . '"';
	}
	
	$html .= '>';
	echo $html;
} // End thtk_form_text()



/**
 * Displays a textarea
 *
 * Outputs an HTML form textarea input.
 * 
 * @since 1.0
 * @param string $name Name property for the textarea.
 * @param string $id ID property for the textarea.
 * @param string $value Text string to place in the textarea.
 */
function thtk_form_textarea( $name, $id = '', $value = '' ) {
	$html = '<textarea';
	if ( !empty ( $id ) ) {
		$html .= ' id="' . $id . '"';
	} // end if
	$html .=' name="' . $name . '">';
	if ( !empty ( $value ) ) {
		$html .= $value;
	} // end if
	$html .= '</textarea>';	
	echo $html;
} // End thtk_form_textarea()



/**
 * Displays a select list
 *
 * Outputs an HTML form select list.
 * 
 * @since 1.0
 * @param string $name Name property for the select list.
 * @param array $options Array of options to populate the select list.
 * @param string $id ID property for the select list.
 * @param string $value List item to mark as selected by default.
 */
function thtk_form_select( $name, $options, $id = '', $value = '' ) {
	$html = '<select';
	if ( !empty ( $id ) ) {
		$html .= ' id="' . $id . '"';
	} // End if
	$html .= 'name="' . $name . '">';
	
	foreach( $options as $option ) {
		$selected = ( $option == $value ) ? ' selected' : '';
		$html .= '<option value="' . $option . '"' . $selected . '>' . $option . ' &nbsp;</option>';
	} // End foreach $options
	
	$html .= '</select>';
	echo $html;
} // End thtk_form_select()



/**
 * Displays radio buttons
 *
 * Outputs an HTML form radio button group.
 * 
 * @since 1.0
 * @param string $name Name property for the radio buttons.
 * @param array $options Array of options used to build the radio buttons.
 * @param string $value Text to use for radio button labels.
 */
function thtk_form_radio( $name, $options, $value = '' ) {
	$html = '';
	foreach( $options as $option ) {
		$html .= '<label for="' .$option . '"><input type="radio" id="' . $option . '" name="' . $name . '" value="' . $option . '"';
		if ( $option == $value  ) {
			$html .= ' checked';
		}
		$html .= '> <span>' . $option . '</span></label><br />';
	}
	echo $html;
} // End thtk_form_radio()



/**
 * Displays a checkbox
 *
 * Outputs an HTML form checkbox.
 * 
 * @since 1.0
 * @param string $name Name property for the checkbox.
 * @param string $label Text string for the checkbox label.
 * @param string $value Value used to determine the checkbox default state.
 */
function thtk_form_checkbox( $name, $label, $value = '' ) {
	$html = '';
	$html .= '<label for="' . $name . '"><input type="checkbox" id="' . $name . '" name="' . $name . '" value="' . $label . '"';
	if ( !empty( $value )  ) {
		$html .= ' checked';
	}
	$html .= ' /> ' . $label . '</label><br />';
	echo $html;
} // End thtk_form_checkbox()



/**
 * Displays a form element description
 *
 * Outputs an HTML form element description. Used if more explanation of a
 * form element is needed. 
 * 
 * @since 1.0
 * @param string $description Text to display in the description.
 */
function thtk_form_description( $description ) {
		echo ' <p class="description">' . $description . '</p>';
} // End thtk_form_description()


