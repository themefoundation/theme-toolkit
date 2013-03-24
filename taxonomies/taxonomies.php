<?php
/**
 * Custom taxonomies
 *
 * @package Theme Toolkit
 * @subpackage Taxonomies
 */

/**
 * Taxonomies class
 *
 * @since 1.0
 */
class THTK_Taxonomies{

	/**
	 * Sets default taxonomy properties
	 *
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $defaults = array(
		'hierarchical' => false,
		'update_count_callback' => '',
		'rewrite' => true,
		'public' => true,
		'show_ui' => null,
		'show_tagcloud' => null,
		'labels' => array(),
		'capabilities' => array(),
		'show_in_nav_menus' => null,
	);



	/**
	 * Receives the custom taxonomy array
	 *
	 * Constructor function which runs when the class is instantiated.
	 *
	 * @since 1.0
	 * @param array $taxonomies Array of taxonomy settings.
	 */
	public function __construct( $taxonomies ){
		$this->taxonomies = $taxonomies;
		add_action( 'init', array( $this, 'taxonomy_setup' ) );
	} // End function __construct()



	/**
	 * Registers taxonomies
	 *
	 * Loops through taxonomy array (usually set in the theme's functions.php file)
	 * and registers taxonomies.
	 *
	 * @since 1.0
	 */
	public function taxonomy_setup() {

		// Checks to make sure the taxonomy array is populated.
		if ( !empty( $this->taxonomies ) ) {

			// Loops through the taxonomy array.
			foreach ( $this->taxonomies as $taxonomy ) {

				// Sets the taxonomy slug.
				$taxonomy_id = $taxonomy[ 'id' ];
				unset( $taxonomy[ 'id' ] );

				// Sets the taxonomy object type.
				$taxonomy_object_type = $taxonomy[ 'object_type' ];
				unset( $taxonomy[ 'object_type' ] );

				// Sets labels for public taxonomies
				if( !isset( $taxonomy[ 'public' ] ) ) {

					// Sets labels with the plural name.
					if( !empty( $taxonomy[ 'title' ] ) ) {
						$default_label[ 'name' ] = $taxonomy[ 'title' ];
						$default_label[ 'singular_name' ] = $taxonomy[ 'title' ];
						$default_label[ 'search_items' ] = 'Search ' . $taxonomy[ 'title' ];
						$default_label[ 'all_items' ] = 'All ' . $taxonomy[ 'title' ];
						$default_label[ 'search_items' ] = 'Search ' . $taxonomy[ 'title' ];
						$default_label[ 'search_items' ] = 'Search ' . $taxonomy[ 'title' ];
						$default_label[ 'search_items' ] = 'Search ' . $taxonomy[ 'title' ];
						$default_label[ 'search_items' ] = 'Search ' . $taxonomy[ 'title' ];
						if( isset( $taxonomy[ 'hierarchical' ] ) ) {
							$default_label[ 'parent_item' ] = 'Popular ' . $taxonomy[ 'title' ];
						} else {
							$default_label[ 'popular_items' ] = 'Popular ' . $taxonomy[ 'title' ];
							$default_label[ 'choose_from_most_used' ] = 'Choose from the most used ' . strtolower( $taxonomy[ 'title' ] );
							$default_label[ 'add_or_remove_items' ] = 'Add or remove ' . strtolower( $taxonomy[ 'title' ] );
							$default_label[ 'separate_items_with_commas' ] = 'Separate ' . strtolower( $taxonomy[ 'title' ] ) . ' with commas';
						} // End if/else
						unset( $taxonomy[ 'title' ] );
					} // End if

					// Sets labels with the singular name.
					if( !empty( $taxonomy[ 'title_singular' ] ) ) {
						$default_label[ 'singular_name' ] = $taxonomy[ 'title_singular' ];
						$default_label[ 'edit_item' ] = 'Edit ' . $taxonomy[ 'title_singular' ];
						$default_label[ 'view_item' ] = 'View ' . $taxonomy[ 'title_singular' ];
						$default_label[ 'update_item' ] = 'Update ' . $taxonomy[ 'title_singular' ];
						$default_label[ 'add_new_item' ] = 'Add New ' . $taxonomy[ 'title_singular' ];
						$default_label[ 'new_item_name' ] = 'New ' . $taxonomy[ 'title_singular' ] . 'Name';
						if( isset( $taxonomy[ 'hierarchical' ] ) ) {
							$default_label[ 'parent_item' ] = 'Parent ' . $taxonomy[ 'title_singular' ];
							$default_label[ 'parent_item_colon' ] = 'Parent ' . $taxonomy[ 'title_singular' ] . ':';

						} // End if
						unset( $taxonomy[ 'title_singular' ] );
					} // End if

					// Combines the generated labels with the user supplied labels.
					if( empty( $taxonomy[ 'labels' ] ) ) {
						$taxonomy[ 'labels' ] = $default_label;
					} else {
						$taxonomy[ 'labels' ] = wp_parse_args( $taxonomy[ 'labels' ], $default_label);
					} // End if/else

				} // End if

				// Combines the taxonomy array with the array of default values.
				$parsed_taxonomy = wp_parse_args( $taxonomy, $this->defaults );

				// Registers the taxonomy.
				register_taxonomy( $taxonomy_id, $taxonomy_object_type, $parsed_taxonomy );

			} // End foreach $this->taxonomies

		} // End if

	} // End function taxonomy_setup()

} // End class THTK_Taxonomies