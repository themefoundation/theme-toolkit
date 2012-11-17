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

// TODO: change add_toolkit_support( feature ) to add_theme_support( toolkit_feature )

// Defines LOCATION constant. This is the folder name/path to the toolkit in your theme.
define( 'LOCATION', 'toolkit' );

// Defines RELATIONSHIP constant. Must be either parent or child.
define( 'RELATIONSHIP', 'parent' );



/**
 * Adds support for individual toolkit features
 *
 * Selectively loads only files required for the toolkit features that are in use.
 *
 * @since toolkit 1.0
 * @param string $feature Name of feature for which to add support.
 */
function add_toolkit_support( $feature ) {
	
	switch ( $feature ) {
		
		// Loads files required for a theme options page.
		case 'theme-options' :
			require_once 'theme-options/theme-options.php';
			require_once 'forms/form-elements.php';
			require_once 'forms/sanitize.php';
			break;
		
		// Loads files required for a theme customizer.
		case 'theme-customizer' :
			require_once 'theme-options/theme-customizer.php';
			require_once 'forms/sanitize.php';
			break;
		
		// Loads files required for custom metaboxes
		case 'metaboxes' :
			require_once 'metaboxes/metaboxes.php';
			require_once 'forms/form-elements.php';
			require_once 'forms/sanitize.php';
			break;
			
	} // End switch $feature
} // End add_toolkit_support()



/**
 * Enqueues theme options scripts
 *
 * Loads javascript files used by the theme options toolkit feature.
 *
 * @since 1.0
 * @param string $hook_suffix Contains a string specifying the WordPress admin page being viewed.
 */
function thtk_theme_options_enqueue_scripts( $hook_suffix ) {
	global $thtk_theme_options_page; 
	if ( $thtk_theme_options_page == $hook_suffix ) {
		wp_enqueue_script( 'thtk-theme-options', thtk_get_toolkit_url() . '/theme-options/theme-options.js', array( 'jquery' ) );
	} // End if
} // End thtk_theme_options_enqueue_scripts



/**
 * Gets the toolkit folder URL
 *
 * Returns the location of the toolkit folder currently in use. 
 *
 * @since 1.0
 * @return string Returns URL of the toolkit folder in use.
 */
function thtk_get_toolkit_url() {
	
	if ( RELATIONSHIP == 'child' ) {
		$theme_path = get_template_directory_uri();
	} else {
		$theme_path = get_stylesheet_directory_uri();
	} // End if/else
	
	$theme_path .= '/' . LOCATION;
	return $theme_path;
} // End thtk_get_toolkit_url()


