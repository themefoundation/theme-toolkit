<?php
/**
 * Custom post types
 *
 * @package Theme Toolkit
 * @subpackage Custom Post Types
 * @since 1.0
 */

/**
 * Custom post types class
 *
 * @since 1.0
 */
class THTK_Custom_Post_Types{

	/**
	 * Sets default post type properties
	 *
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $defaults = array(
		'labels' => array(),
		'description' => '',
		'publicly_queryable' => null,
		'exclude_from_search' => null,
		'capability_type' => 'post',
		'capabilities' => array(),
		'map_meta_cap' => null,
		'hierarchical' => false,
		'public' => true,
		'rewrite' => true,
		'has_archive' => false,
		'query_var' => true,
		'supports' => array(),
		'register_meta_box_cb' => null,
		'taxonomies' => array(),
		'show_ui' => null,
		'menu_position' => null,
		'menu_icon' => null,
		'can_export' => true,
		'show_in_nav_menus' => null,
		'show_in_menu' => null,
		'show_in_admin_bar' => null,
		'delete_with_user' => null,
	);



	/**
	 * Receives the custom post type array
	 *
	 * Constructor function which runs when the class is instantiated.
	 *
	 * @since 1.0
	 * @param array $post_types Array of post type settings.
	 */
	public function __construct( $post_types ){
		$this->post_types = $post_types;
		add_action( 'init', array( $this, 'post_type_setup' ) );
	} // End function __construct()



	/**
	 * Registers post types
	 *
	 * Loops through post type array (usually set in the theme's functions.php file)
	 * and registers custom post types.
	 *
	 * @since 1.0
	 */
	public function post_type_setup() {

		// Checks to make sure the post type array is populated.
		if ( !empty( $this->post_types ) ) {

			// Loops through the post type array.
			foreach ( $this->post_types as $post_type ) {

				// Sets the custom post type slug
				$post_type_id = $post_type[ 'id' ];
				unset( $post_type[ 'id' ] );

				// Sets labels for public post types
				if( !isset( $post_type[ 'public' ] ) ) {

					// Sets labels with the plural name.
					if( !empty( $post_type[ 'title' ] ) ) {
						$default_label[ 'name' ] = $post_type[ 'title' ];
						$default_label[ 'all_items' ] = 'All ' . $post_type[ 'title' ];
						$default_label[ 'search_items' ] = 'Search ' . $post_type[ 'title' ];
						$default_label[ 'not_found' ] = 'No ' . strtolower( $post_type[ 'title' ] ) . ' found';
						$default_label[ 'not_found_in_trash' ] = 'No ' . strtolower( $post_type[ 'title' ] ) . ' found in Trash';
						unset( $post_type[ 'title' ] );
					} // End if

					// Sets labels with the singular name.
					if( !empty( $post_type[ 'title_singular' ] ) ) {
						$default_label[ 'singular_name' ] = $post_type[ 'title_singular' ];
						$default_label[ 'add_new_item' ] = 'Add New ' . $post_type[ 'title_singular' ];
						$default_label[ 'edit_item' ] = 'Edit ' . $post_type[ 'title_singular' ];
						$default_label[ 'new_item' ] = 'New ' . $post_type[ 'title_singular' ];
						$default_label[ 'view_item' ] = 'View ' . $post_type[ 'title_singular' ];
						$default_label[ 'items_archive' ] = $post_type[ 'title_singular' ] . ' Archive';
						if( !empty( $post_type[ 'hierarchical' ] ) ) {
							$post_type[ 'labels' ][ 'parent_item_colon' ] = 'Parent ' . $post_type[ 'title_singular' ];
						} // End if
						unset( $post_type[ 'title_singular' ] );
					} // End if

					// Combines the generated labels with the user supplied labels.
					if( empty( $post_type[ 'labels' ] ) ) {
						$post_type[ 'labels' ] = $default_label;
					} else {
						$post_type[ 'labels' ] = wp_parse_args( $post_type[ 'labels' ], $default_label);
					} // End if/else

				} // End if

				// Combines the post type array with the array of default values.
				$parsed_post_type = wp_parse_args( $post_type, $this->defaults );

				// Registers the post type.
				register_post_type( $post_type_id, $parsed_post_type );

			} // End foreach $this->post_types

		} // End if

	} // End function post_type_setup()

} // End class THTK_Custom_Post_Types