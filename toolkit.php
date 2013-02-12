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
		
		// Loads files required for custom metaboxes
		case 'metaboxes' :
			require_once 'metaboxes/metaboxes.php';
			require_once 'forms/form-elements.php';
			require_once 'forms/sanitize.php';
			$thtk_metabox_array = array();
			$thtk_metabox_array = apply_filters( 'thtk_metaboxes_filter', $thtk_metabox_array );
			$thtk_metaboxes = new THTK_Meta_Boxes($thtk_metabox_array);
			add_action( 'add_meta_boxes', array($thtk_metaboxes, 'meta_box_setup') );
			add_action( 'save_post', array($thtk_metaboxes, 'meta_box_save' ) );
			break;
			
	} // End switch $feature
} // End add_toolkit_support()





