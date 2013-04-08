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
function theme_toolkit_setup() {

	// Adds theme support for toolkit features
	add_theme_support( 'toolkit-custom-post-types' );
	add_theme_support( 'toolkit-meta-boxes' );
	add_theme_support( 'toolkit-taxonomies' );
	add_theme_support( 'toolkit-theme-customizer' );

	// Loads the toolkit setup file.
	require_once 'toolkit/toolkit.php';

	// Specifies toolkit folder location.
	$args = array(
		'child_theme' => false, // Optional. Only used if toolkit is located in a child theme. Default: false.
		'toolkit_folder' => 'toolkit',  // Optional. Only used if "toolkit" folder is moved/renamed. Default: toolkit.
	);

	// Initializes the theme toolkit. $args can be ommitted if defaults are acceptable.
	theme_toolkit_init( $args );

} // End function thtk_setup()
add_action( 'init', 'theme_toolkit_setup', 1 );



// Checks to make sure child theme hasn't used this function before executing.
if ( !function_exists( 'thtk_example_taxonomies' ) ) {
	/**
	 * Defines custom taxonomy arrays
	 */
	function thtk_example_taxonomies() {

		// Defines single taxonomy.
		$custom_taxonomies[] = array(
			'id' => 'example_taxonomy',
			'object_type' => 'example_post_type',
			'title' => 'Groups',
			'title_singular' => 'Group',
			'hierarchical' => true,
		);

		// Defines single post type.
		$custom_taxonomies[] = array(
			'id' => 'another_post_type',
			'object_type' => 'post',
			'title' => 'Classifications',
			'title_singular' => 'Classification',
		);

		// Add other taxonomies here as needed.

		return $custom_taxonomies;
	} // End function thtk_example_taxonomies()
} // End if
add_filter( 'thtk_taxonomies_filter', 'thtk_example_taxonomies' );



// Checks to make sure child theme hasn't used this function before executing.
if ( !function_exists( 'thtk_example_post_types' ) ) {
	/**
	 * Defines custom post type arrays
	 */
	function thtk_example_post_types() {

		// Defines single post type.
		$custom_post_types[] = array(
			'id' => 'example_post_type',
			'title' => 'Examples',
			'title_singular' => 'Example',
			'labels' => array(
				'not_found' => 'No examples were found. Sorry :(',
			),
			'menu_position' => 5,
			'hierarchical' => true,
			'supports' => array( 'title', 'page-attributes' ),
		);

		// Defines single post type.
		$custom_post_types[] = array(
			'id' => 'another_post_type',
			'title' => 'Samples',
			'title_singular' => 'Sample',
		);

		// Add other post types here as needed.

		return $custom_post_types;
	} // End function thtk_example_post_types()
} // End if
add_filter( 'thtk_custom_post_types_filter', 'thtk_example_post_types' );



// Checks to make sure child theme hasn't used this function before executing.
if ( !function_exists( 'thtk_example_meta_boxes' ) ) {
	/**
	 * Defines meta box arrays
	 */
	function thtk_example_meta_boxes() {

		// Defines $prefix. Should begin with an underscore unless you want fields to be doubled in the Custom Fields editor.
		$prefix = '_example_';

		// Defines meta box array.
		$meta_boxes[] = array(
			'id' => 'example_meta_box',
			'title' => 'Example Meta Box',
			'post_type' => array( 'page', 'post' ), // Post types to display meta box.
			'context' => 'normal', // Optional.
			'priority' => 'high', // Optional.
			'meta_box_fields' => array(
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
			) // End array meta_box_fields
		); // End array $meta_boxes

			$meta_boxes[] = array(
			'id' => 'another_meta_box',
			'title' => 'Another Meta Box',
			'post_type' => array( 'post' ), // Post types to display meta box.
			'meta_box_fields' => array(
				array(
					'id' => $prefix . 'another',
					'title' => 'Another example',
					'type' => 'text',
				),
			) // End array meta_box_fields
		); // End array $meta_boxes

		// Add other meta boxes here as needed.

		return $meta_boxes;
	} // End function thtk_example_meta_boxes()
} // End if
add_filter( 'thtk_meta_boxes_filter', 'thtk_example_meta_boxes' );



// Checks to make sure child theme hasn't used this function before executing.
if ( !function_exists( 'thtk_example_customizer' ) ) {
	/**
	 * Defines theme customizer arrays
	 */
	function thtk_example_customizer() {

		// Defines $prefix for setting IDs. Optional.
		$prefix = 'example_';

		// Defines theme cusotmizer sections and settings
		$customizer_section[] = array(
			'section_id' => 'example_settings', // Settings section ID.
			'section_title' => 'Example Settings', // Settings section title.
			'section_description' => 'Section description...', // Optional. Adds descriptive title text to section title (only visible on mousover). Default: none.
			'section_priority' => 200, // Optional. Determines placement in customizer panel. Default: 10.
			'section_settings' => array(
				array(
					'id' => $prefix . 'textbox', // Form element ID.
					'title' => 'Text box', // Form element label.
					'type' => 'text', // Type of form input field.
					'default' => 'Default content', // Optional. Default form field value. Default: blank.
					'valid' => 'text', // Optional. Determines which sanitization callback function to use. Default: text.
					'priority' => 5, // Optional. Determines display order of customization options. Default: 10.
					'transport' => 'refresh', // Optional. Determines how to transport the data to the theme customizer. Default: refresh.
					//'valid_js' => '' // Optional. Corresponds with the (largely undocumented) sanitize_js_callback setting callback.
				),
				array(
					'id' => $prefix . 'checkbox',
					'title' => 'Checkbox',
					'type' => 'checkbox',
				),
				array(
					'id' => $prefix . 'radio_buttons',
					'title' => 'Radio Buttons',
					'type' => 'radio',
					'default' => 'left',
					'choices' => array( // Array of id/label pairs.
						'left' => 'Left',
						'right' => 'Right',
						'center' => 'Center',
					),
				),
				array(
					'id' => $prefix . 'select_list',
					'title' => 'Select list',
					'type' => 'select',
					'default' => 'two',
					'choices' => array( // Array of id/label pairs.
						'one' => 'Option 1',
						'two' => 'Option 2',
						'three' => 'Option 3',
					),
				),
				array(
					'id' => $prefix . 'textarea',
					'title' => 'Textarea',
					'type' => 'textarea',
				),
			)
		); // End $customizer_section[]

		$customizer_section[] = array(
			'section_id' => 'more_settings',
			'section_title' => 'More Settings',
			'section_theme_supports' => 'widgets', // Optional. Only show section if theme supports this feature. Default: none.
			'section_settings' => array(
				array(
					'id' => $prefix . 'pages',
					'title' => 'Pages',
					'type' => 'dropdown-pages',
					'valid' => 'integer',
				),
				array(
					'id' => $prefix . 'color',
					'title' => 'Color picker',
					'type' => 'color',
					'valid' => 'color',
				),
				array(
					'id' => $prefix . 'file',
					'title' => 'File uploader',
					'type' => 'upload',
				),
				array(
					'id' => $prefix . 'image',
					'title' => 'File image',
					'type' => 'image',
				),
			)
		); // End $customizer_section[]

		return $customizer_section;
	} // End function thtk_example_customizer()
} // End if
add_filter( 'thtk_customizer_filter', 'thtk_example_customizer' );
