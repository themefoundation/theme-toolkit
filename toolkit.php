<?php
/**
 * Theme Toolkit
 *
 * This is the central file of the Theme Toolkit. It holds the settings
 * that the toolkit needs in order to operate as well as the loading
 * scripts for various modules that the toolkit provides.
 *
 * @package Theme Toolkit
 * @version	1.0
 */



/**
 * Initializes the theme toolkit
 *
 * Sets the toolkit location and loads the required files.
 *
 * @param array $args Specifies the toolkit location.
 * @since 1.0
 */
function theme_toolkit_init( $args = '' ) {

	// Sets default toolkit variables
	$defaults = array(
		'child_theme' => false, // Optional. Is toolkit located in child theme?
		'toolkit_folder' => 'toolkit', // Optional. Name of folder containing the toolkit files.
	);

	$thtk_settings = wp_parse_args( $args, $defaults );

	// Sets toolkit location variables
	if( $thtk_settings[ 'child_theme' ] ){
		$thtk_location = get_stylesheet_directory() . '/' . $thtk_settings[ 'child_theme' ] . '/' . $thtk_settings[ 'toolkit_folder' ];
		$thtk_location_uri = get_stylesheet_directory_uri() . '/' . $thtk_settings[ 'child_theme' ] . '/' . $thtk_settings[ 'toolkit_folder' ];
	} else {
		$thtk_location = get_template_directory() . '/' . $thtk_settings[ 'toolkit_folder' ];
		$thtk_location_uri = get_template_directory_uri() . '/' . $thtk_settings[ 'toolkit_folder' ];

	} // End if/else

	// Sets up custom post type support
	if( current_theme_supports( 'toolkit-custom-post-types' ) ) {

		// Loads files required for the theme customizer.
		include_once $thtk_location . '/custom-post-types/custom-post-types.php';

		// Adds filter for attaching custom post type array.
		$thtk_custom_post_type_array = apply_filters( 'thtk_custom_post_types_filter', array() );

		// Passes meta box array to a new instance of the custom post type class.
		$thtk_custom_post_types = new THTK_Custom_Post_Types( $thtk_custom_post_type_array );

	} // End if

	// Sets up custom meta box support
	if( current_theme_supports( 'toolkit-meta-boxes' ) ) {

		// Loads files required for custom meta boxes.
		include_once $thtk_location . '/meta-boxes/meta-boxes.php';
		include_once $thtk_location . '/forms/form-elements.php';
		include_once $thtk_location . '/forms/sanitize.php';

		// Adds filter for attaching meta box array.
		$thtk_meta_box_array = apply_filters( 'thtk_meta_boxes_filter', array() );

		// Passes meta box array to a new instance of the meta box class.
		$thtk_meta_boxes = new THTK_Meta_Boxes( $thtk_meta_box_array );

	} // End if

	// Sets up custom taxonomy support
	if( current_theme_supports( 'toolkit-taxonomies' ) ) {

		// Loads files required for custom taxonomies.
		include_once $thtk_location . '/taxonomies/taxonomies.php';

		// Adds filter for attaching meta box array.
		$thtk_taxonomy_array = apply_filters( 'thtk_taxonomies_filter', array() );

		// Passes meta box array to a new instance of the meta box class.
		$thtk_taxonomies = new THTK_Taxonomies( $thtk_taxonomy_array );

	} // End if

	// Sets up theme customizer support
	if( current_theme_supports( 'toolkit-theme-customizer' ) ) {

		// Loads files required for the theme customizer.
		include_once $thtk_location . '/theme-options/theme-customizer.php';
		include_once $thtk_location . '/forms/sanitize.php';

		// Adds filter for attaching customizer array.
		$thtk_customizer_array = apply_filters( 'thtk_customizer_filter', array() );

		// Passes customizer array to a new instance of the theme customizer class.
		$thtk_customizer = new THTK_Theme_Customizer( $thtk_customizer_array );

	} // End if

} // End function theme_toolkit_init()