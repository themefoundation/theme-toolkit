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
function add_toolkit_support( $feature, $args = '' ) {

	switch ( $feature ) {

		case 'custom-post-types' :

			// Loads files required for a theme customizer.
			require_once 'custom-post-types/custom-post-types.php';

			// Adds filter for attaching custom post type array.
			$thtk_custom_post_type_array = apply_filters( 'thtk_custom_post_types_filter', array() );

			// Passes meta box array to a new instance of the custom post type class.
			$thtk_custom_post_types = new THTK_Custom_Post_Types( $thtk_custom_post_type_array );
			break;


		case 'menus' :

			// Loads files required for custom menus.
			require_once 'menus/menus.php';

			// Adds filter for attaching menu array.
			$thtk_menus_array = apply_filters( 'thtk_menus_filter', array() );

			// Passes meta box array to a new instance of the menu class.
			$thtk_menus = new THTK_Menus( $thtk_menus_array );
			break;


		case 'meta-boxes' :

			// Includes required files.
			require_once 'meta-boxes/meta-boxes.php';
			require_once 'forms/form-elements.php';
			require_once 'forms/sanitize.php';

			// Adds filter for attaching meta box array.
			$thtk_meta_box_array = apply_filters( 'thtk_meta_boxes_filter', array() );

			// Passes meta box array to a new instance of the meta box class.
			$thtk_meta_boxes = new THTK_Meta_Boxes( $thtk_meta_box_array );
			break;

		case 'post-thumbnails' :

			// Adds theme support for thumbnails
			if( !empty( $args ) ) {
				add_theme_support( 'post-thumbnails', $args );
			} else {
				add_theme_support( 'post-thumbnails' );
			}


			// Includes required files.
			require_once 'post-thumbnails/post-thumbnails.php';

			// Adds filter for attaching meta box array.
			$thtk_post_thumbnails_array = apply_filters( 'thtk_post_thumbnails_filter', array() );

			// Passes meta box array to a new instance of the meta box class.
			$thtk_post_thumbnails = new THTK_Post_Thumbnails( $thtk_post_thumbnails_array );
			break;

		case 'taxonomies' :

			// Includes required files.
			require_once 'taxonomies/taxonomies.php';

			// Adds filter for attaching meta box array.
			$thtk_taxonomy_array = apply_filters( 'thtk_taxonomies_filter', array() );

			// Passes meta box array to a new instance of the meta box class.
			$thtk_taxonomies = new THTK_Taxonomies( $thtk_taxonomy_array );
			break;


		case 'theme-customizer' :

			// Loads files required for a theme customizer.
			require_once 'theme-options/theme-customizer.php';
			require_once 'forms/sanitize.php';

			// Adds filter for attaching customizer array.
			$thtk_customizer_array = apply_filters( 'thtk_customizer_filter', array() );

			// Passes customizer array to a new instance of the theme customizer class.
			$thtk_customizer = new THTK_Theme_Customizer( $thtk_customizer_array );
			break;

	} // End switch $feature
} // End add_toolkit_support()





