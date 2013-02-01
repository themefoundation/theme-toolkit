<?php

/**
 * Example functions.php
 *
 * Each section of this file is designed to be pasted into the functions.php
 * file of your theme (after the "toolkit" folder is placed in the theme).
 * Each section includes a detailed description followed by the necessary
 * code. You may need to make changes for your specific situation.
 * Such changes will be addressed in the section description.
 *
 * @package Theme Toolkit
 * @subpackage Examples
 */



/**
 * Loads the toolkit/toolkit.php file for adding toolkit feature support.
 *
 * @since toolkit 1.0
 */
function thtk_setup() {
	
	// Loads the toolkit setup file.
	require_once 'toolkit/toolkit.php';
	
	// Adds support for various toolkit features.
	add_toolkit_support( 'metaboxes' );
	add_toolkit_support( 'theme-customizer' );

} // End function thtk_setup()
add_action( 'init', 'thtk_setup' );



// Checks to make sure child theme hasn't used this function before executing.
if ( !function_exists( 'thtk_example_metaboxes' ) ) {
	/**
	 * Defines metabox arrays
	 */
	function thtk_example_metaboxes() {
	
		// Defines $prefix. Should begin with an underscore unless you want fields to be doubled in the Custom Fields editor.
		$prefix = '_example_';
		
		// Defines metabox array.
		$meta_boxes[] = array(
			'id' => 'example_metabox',
			'title' => 'Example Metabox',
			'post_type' => array( 'page', 'post' ), // Post types to display metabox.
			'context' => 'normal', // Optional.
			'priority' => 'high', // Optional.
			'metabox_fields' => array(
				array(
					'id' => $prefix . 'textbox',
					'title' => 'Text box',
					'type' => 'text',
					'description' => 'This is an example text box.', // Optional.
					'valid' => 'text' // Optional. Defaults to 'text'
				),
				array(
					'id' => $prefix . 'textarea',
					'title' => 'Text area',
					'type' => 'textarea',
					'description' => 'This is an example textarea', // Optional.
					'valid' => 'text' // Optional. Defaults to 'text'
				),
				array(
					'id' => $prefix . 'select',
					'title' => 'Select input',
					'type' => 'select',
					'choices' => array('Option 1', 'Option 2', 'test'),
					'description' => 'This is an example select input', // Optional.
					// 'valid' property is not available for select lists.
					// The options listed in the 'options' property are automatically the only valid results.
				),
				array(
					'id' => $prefix . 'radio',
					'title' => 'Radio input',
					'type' => 'radio',
					'choices' => array('Option 3', 'Option 4', 'test'),
					'description' => 'This is an example radio input', // Optional.
					// 'valid' property is not available for radio buttons.
					// The options listed in the 'options' property are automatically the only valid results.
				),
				array(
					'id' => $prefix . 'checkbox',
					'title' => 'Single checkbox',
					'type' => 'checkbox',
					'label' => 'Check this out!',
					'description' => 'This is an example text box.', // Optional.
					// 'valid' property is not available for checkboxes.
					// The 'label' property will be the checked box value and the only valid result.
				),
				array(
					'id' => $prefix . 'multicheck',
					'title' => 'Multiple checkbox input',
					'type' => 'multicheck',
					'choices' => array( // $id => $label for each checkbox
						$prefix . 'check_one' => 'Option 23',
						$prefix . 'check_two' => 'Option 34',
						$prefix . 'check_three' => 'test'
					),
					'description' => 'This is an example checkbox input', // Optional.
					// 'valid' property is not available for multicheck.
					// See explanation in "checkbox" section above.
				),
			) // End array metabox_fields
		); // End array $meta_boxes
		
			$meta_boxes[] = array(
			'id' => 'another_metabox',
			'title' => 'Another Metabox',
			'post_type' => array( 'post' ), // Post types to display metabox.
			'metabox_fields' => array(
				array(
					'id' => $prefix . 'another',
					'title' => 'Another example',
					'type' => 'text',
				),
			) // End array metabox_fields
		); // End array $meta_boxes	
		
		// Add other metaboxes here as needed.
		
		return $meta_boxes;
	} // End function thtk_example_metaboxes()
} // End if 
add_filter( 'thtk_metaboxes_filter', 'thtk_example_metaboxes' );




// Checks to make sure child theme hasn't used this function before executing.
if ( !function_exists( 'thtk_example_customizer' ) ) {
	/**
	 * Defines theme customizer arrays
	 */
	function thtk_example_customizer() {
		
		// Defines $prefix for setting IDs. Optional. 
		$prefix = 'example_';

		$customizer_section[] = array(
			'section_id' => 'custom_settings', // Settings section ID.
			'section_title' => 'Custom Settings', // Settings section title.
			'section_description' => 'Test description...', // Optional. Adds descriptive title text to section title (only visible on mousover). Default: none.
			'section_priority' => 30, // Optional. Determines placement in customizer panel. Default: 10.
			'section_theme_supports' => 'widgets', // Optional. Only show section if theme supports this feature. Default: none.
			'section_settings' => array(
				array(
					'id' => $prefix . 'text4', // Form element ID.
					'title' => 'Text input', // Form element label.
					'type' => 'text', // Type of form input field.
					'default' => 'Default input value', // Optional. Default form field value. Default: blank.
					'valid' => 'text', // Optional. Determines which sanitization callback functio to use. Default: text.
					'priority' => 20, // Optional. Determines display order of customization options. Default: 10. 
					'transport' => 'refresh' // Optional. Determines how to transport the data to the theme customizer. Default: refresh.
					// 'valid_js' => '' // Optional. Corresponds with the (apparently undocumented) sanitize_js_callback setting callback.
	
				),
				array(
					'id' => $prefix . 'check',
					'title' => 'Checkbox input',
					'type' => 'checkbox',
					'valid' => 'text'
				),
				array(
					'id' => $prefix . 'select',
					'title' => 'Select input',
					'type' => 'select',
					'choices' => array( // Array of id/label pairs.
						'one' => 'Option 1',
						'two' => 'Option 2',
						'three' => 'Option 3',
					),
					'default' => 'two',
				),
			)
		); // End $customizer_section[]
		
		$customizer_section[] = array(
			'section_id' => 'select',
			'section_title' => 'More Settings',
			'section_priority' => 30,
			'section_settings' => array(
				array(
					'id' => $prefix . 'radio',
					'title' => 'Radio input',
					'type' => 'select',
					'choices' => array( // Array of id/label pairs.
						'one' => 'Option 1',
						'two' => 'Option 2',
						'three' => 'Option 3',
					),
				),
				array(
					'id' => $prefix . 'pages',
					'title' => 'Pages',
					'type' => 'dropdown-pages',
					'valid' => 'integer',
				)
				
			)
		); // End $customizer_section[]	
		
		return $customizer_section;
	} // End function thtk_example_customizer()
} // End if 
add_filter( 'thtk_customizer_filter', 'thtk_example_customizer' );


