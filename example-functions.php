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
	add_toolkit_support( 'theme-options' );
	add_toolkit_support( 'theme-customizer' );

}
add_action( 'init', 'thtk_setup' );





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
				'options' => array('Option 1', 'Option 2', 'test'),
				'description' => 'This is an example select input', // Optional.
				// 'valid' property is not available for select lists.
				// The options listed in the 'options' property are automatically the only valid results.
			),
			array(
				'id' => $prefix . 'radio',
				'title' => 'Radio input',
				'type' => 'radio',
				'options' => array('Option 3', 'Option 4', 'test'),
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
				'options' => array( // $id => $label for each checkbox
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
}
add_filter( 'thtk_metaboxes_filter', 'thtk_example_metaboxes' );



/**
 * Defines theme options array
 */
function thtk_example_options(){

	$theme_options = array(
		'page_title' => 'Example Theme Options', // Displayed at top of the theme options page 
		'menu_title' => 'Theme Options', // Displayed in the WordPress administration menu
		'slug' => 'example-options', // Appears in the URL or the settings page (must be unique)
		'option_group' => 'example_theme_options', // Options are saved to the database using this name
		'settings_sections' => array( // Defines the seections and fields displayed on the theme options page
		
			// Sets up "Header" settings section
			array(
				'section_id' => 'section_one',
				'section_title' => 'First Section',
				'section_callback' => '__return_false', // Optional. Used only if a custom callback is being needed.
				
				// Defines settings fields under the "First Section" settings section.
				'section_fields' => array(
					array(
						'id' => 'text-box',
						'title' => 'Text box',
						'type' => 'text',
						'description' => 'This is a text input', // Optional.
						'valid' => 'text' // Optional, but recommended. Defaults to 'text'
					),
					array(
						'id' => 'textarea',
						'title' => 'Textarea',
						'type' => 'textarea',
						'description' => 'This is a textarea', // Optional.
						'valid' => 'html' // Optional, but recommended. Defaults to 'text'
					),
					array(
						'id' => 'selected',
						'title' => 'Select example',
						'type' => 'select',
						'options' => array( 'one', 'two', 'three' ),
						'description' => 'This is a select input example', // Optional.
						// 'valid' property is not available for select lists.
						// The options listed in the 'options' property are automatically the only valid results.
					),
				), // End section_fields array.
			), // End section array.
			
			// Sets up "Footer" settings section
			array(
				'section_id' => 'section_two',
				'section_title' => 'Second Section',
				
				// Sets up fields in the "Footer" settings section
				'section_fields' => array(
					array(
						'id' => 'radio',
						'title' => 'Radio example',
						'type' => 'radio',
						'options' => array( 'four', 'five', 'six' ),
						'description' => 'This is a radio input example', // Optional.
						// 'valid' property is not available for radio buttons.
						// The options listed in the 'options' property are automatically the only valid results.
					),
					array(
						'id' => 'checkbox',
						'title' => 'Single checkbox example',
						'type' => 'checkbox',
						'label' => 'Checkbox label',
						'description' => 'This is a checkbox input example', // Optional.
						// 'valid' property is not available for checkboxes.
						// The 'label' property will become the checked box value and the only valid result.
					),
					array(
						'id' => 'testcheck',
						'title' => 'Multiple checkbox input',
						'type' => 'multicheck',
						'options' => array( // $id => $label for each checkbox
							'check_one' => 'Option 23',
							'check_two' => 'Option 34',
							'check_three' => 'test'
						),
						'description' => 'This is a new and strange example checkbox input', // Optional.
						// 'valid' property is not available for multicheck.
						// See explanation in "checkbox" section above.
					),
				), // End section_fields array.
			), // End section array.
			
		), // End settings_sections array.
	); // End $theme_options array.
	
	return $theme_options;
}
add_filter( 'thtk_theme_options_filter', 'thtk_example_options' );



/**
 * Defines theme customizer arrays
 */
function thtk_example_customizer() {
	$customizer_section[] = array(
		'section_id' => 'custom_settings', // Settings section ID.
		'section_title' => 'Custom Settings', // Settings section title.
		'section_description' => 'Test description...', // Optional. Adds descriptive title text to section title (only visible on mousover). Default: none.
		'section_priority' => 30, // Optional. Determines placement in customizer panel. Default: 10.
		'section_theme_supports' => 'widgets', // Optional. Only show section if theme supports this feature. Default: none.
		'section_settings' => array(
			array(
				'id' => 'text4', // Form element ID.
				'title' => 'Text input', // Form element label.
				'type' => 'text', // Type of form input field.
				'default' => 'Default input value', // Optional. Default form field value. Default: blank.
				'valid' => 'text', // Optional. Determines which sanitization callback functio to use. Default: text.
				'priority' => 20, // Optional. Determines display order of customization options. Default: 10. 
				'transport' => 'refresh' // Optional. Determines how to transport the data to the theme customizer. Default: refresh.
				// 'valid_js' => '' // Optional. Corresponds with the (apparently undocumented) sanitize_js_callback setting callback.

			),
			array(
				'id' => 'check',
				'title' => 'Checkbox input',
				'type' => 'checkbox',
				'valid' => 'text'
			),
			array(
				'id' => 'select',
				'title' => 'Select input',
				'type' => 'select',
				'choices' => array( // Array of id/label pairs.
					'one ' => 'Option 1',
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
				'id' => 'radio',
				'title' => 'Radio input',
				'type' => 'select',
				'choices' => array( // Array of id/label pairs.
					'one ' => 'Option 1',
					'two' => 'Option 2',
					'three' => 'Option 3',
				),
			),
			array(
				'id' => 'pages',
				'title' => 'Pages',
				'type' => 'dropdown-pages',
				'valid' => 'integer',
			)
			
		)
	); // End $customizer_section[]	
	
	return $customizer_section;
}
add_filter( 'thtk_customizer_filter', 'thtk_example_customizer' );


