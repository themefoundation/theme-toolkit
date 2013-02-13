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
 * Adds support for individual toolkit features
 *
 * Selectively loads only files required for the toolkit features that are in use.
 *
 * @since toolkit 1.0
 * @param string $feature Name of feature for which to add support.
 */
function add_toolkit_support( $feature ) {
	
	switch ( $feature ) {
		
		// Loads files required for a theme customizer.
		case 'theme-customizer' :
			require_once 'theme-options/theme-customizer.php';
			require_once 'forms/sanitize.php';
			break;
		
		// Adds support for custom meta boxes.
		case 'meta-boxes' :
		
			// Includes required files.
			require_once 'meta-boxes/meta-boxes.php';
			require_once 'forms/form-elements.php';
			require_once 'forms/sanitize.php';
			
			// Adds filter for attaching meta box array.
			$thtk_meta_box_array = apply_filters( 'thtk_meta_boxes_filter', array() );
			
			// Passes meta box array to a new instance of the meta box class.
			$thtk_meta_boxes = new THTK_Meta_Boxes($thtk_meta_box_array);
			break;
			
	} // End switch $feature
} // End add_toolkit_support()





