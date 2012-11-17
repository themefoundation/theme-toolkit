<?php
/**
 * Custom metaboxes
 *
 * @package Theme Toolkit
 * @subpackage Metaboxes
 */



/**
 *  Gets the metaboxes array from the theme
 *
 * Provides a filter that is used by the theme to pass the metabox details
 * array to the Theme Toolkit for processing.
 *
 * @since 1.0
 * @param array $thtk_metaboxes Array of metaboxes (empty by default).
 * @return array Metaboxes array, usually defined in the theme's functions.php file.
 */
function thtk_get_metaboxes_array( $thtk_metaboxes = array() ) {
	
	// Provides filter for obtaining options array.
	$thtk_metaboxes = apply_filters( 'thtk_metaboxes_filter', $thtk_metaboxes );
	
	// Returns the options array.
	return $thtk_metaboxes;
} // End thtk_get_metaboxes_array()



/**
 * Adds metaboxes to appropriate admin pages
 *
 * Loops through metabox array (usually set in the theme's functions.php file)
 * and creates metaboxes by calling the thtk_metabox_content() function.
 *
 * @since 1.0
 */
function thtk_metabox_setup() {
	$thtk_metaboxes = thtk_get_metaboxes_array();
	foreach ( $thtk_metaboxes as $metabox ) {
		foreach ( $metabox[ 'post_type' ] as $page ) {
			
			if( empty( $metabox[ 'context' ] ) ) {
				$metabox[ 'context' ] = 'normal';
			}
			
			if( empty( $metabox[ 'priority' ] ) ) {
				$metabox[ 'priority' ] = 'high';
			}
			
			add_meta_box(
				$metabox[ 'id' ],
				$metabox[ 'title' ],
				'thtk_display_metabox_content',
				$page,
				$metabox[ 'context' ],
				$metabox[ 'priority' ],
				$metabox[ 'metabox_fields' ]
			);
		} // End foreach $metabox[ 'post_type' ]
	} // End foreach $thtk_metaboxes
} // End thtk_metabox_setup()
add_action( 'add_meta_boxes', 'thtk_metabox_setup' );



/**
 * Displays metabox content
 *
 * Displays metabox content based on the metabox array, usually set in the
 * theme's functions.php file.
 *
 * @since 1.0
 * @param array $post The current post object.
 * @param array $metabox_fields The fields that will populate the metabox.
 */
function thtk_display_metabox_content( $post, $metabox_fields ) {
	echo '<div class="thtk-metabox"><table class="form-table">';
	
	// Sets security nonce
	wp_nonce_field( 'thtk_metabox_nonce', 'metabox_nonce' );
	
	// Gets stored values from the database.
	$values = get_post_custom( $post->ID );
	
	// Loops through each array element and calls the corresponding display function.
	foreach( $metabox_fields[ 'args' ] as $metabox_field ) {
		extract( $metabox_field );

		// Sets previously stored value and checks for new description.
		$metabox_field[ 'value' ] = isset( $values[ $metabox_field[ 'id' ] ] ) ? esc_attr( $values[ $metabox_field[ 'id' ] ][ 0 ] ) : '';
	
		// Uses the THTK_Form_Metabox class to dispay the metabox setting.
		$thtk_input = new THTK_Form_Metabox( $metabox_field );
		echo $thtk_input->get_metabox();

	} // End foreach $metabox_fields[ 'args' ]

	// HTML to match WordPress native formatting.
	echo '</table></div><!-- .thtk-metabox -->';
	
} // End thtk_display_metabox_content()



/**
 * Saves metabox values
 *
 * Saves the content of the custom metaboxes to the database.
 *
 * @since 1.0
 * @param int $post_id The current post id.
 */
function thtk_metabox_save( $post_id ) {
	
	// Exits if the current save operation is an autosave rather than a manual save.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	} // End if
	
	// Exits if the nonce is missing or can't be verified.
	if ( !isset( $_POST[ 'metabox_nonce' ] ) || !wp_verify_nonce( $_POST[ 'metabox_nonce' ], 'thtk_metabox_nonce' ) ) {
		return;
	} // End if
	
	// Exits if the current user can't edit the post.
	if ( !current_user_can( 'edit_post' ) ) {
		return;
	} // End if

	
	// Gets the metaboxes array (usually set in the theme's functions.php file).
	$thtk_metaboxes = thtk_get_metaboxes_array();

	// Loops through the metabox arrays.
	foreach ( $thtk_metaboxes as $metabox ) {
		
		// Loops through the fields of each metabox array, sanitizing and saving input.
		foreach ( $metabox[ 'metabox_fields' ] as $field ) {
		
			// Calls sanitization functions and saves results based on the type of input field.
			switch ( $field[ 'type' ] ) {
				case 'text':
					$valid = isset( $field['valid'] ) ? $field['valid'] : 'text';
					update_post_meta( $post_id, $field[ 'id' ], thtk_sanitize_text( $_POST[ $field[ 'id' ] ], $valid ) );
					break;
					
				case 'textarea':
					$valid = isset( $field[ 'valid' ] ) ? $field[ 'valid' ] : 'text';
					update_post_meta( $post_id, $field[ 'id' ], thtk_sanitize_text( $_POST[ $field[ 'id' ] ], $valid ) );
					break;
					
				case 'select':
					update_post_meta( $post_id, $field[ 'id' ], thtk_sanitize_multiple_choice( $_POST[ $field[ 'id' ] ], $field[ 'choices' ] ) );
					break;
					
				case 'radio':
					update_post_meta( $post_id, $field[ 'id' ], thtk_sanitize_multiple_choice( $_POST[ $field[ 'id' ] ], $field[ 'choices' ] ) );
					break;

				case 'checkbox':
					update_post_meta( $post_id, $field[ 'id' ], thtk_sanitize_checkbox( $_POST[ $field[ 'id' ] ], $field[ 'label' ] ) );
					break;

				case 'multicheck':
					foreach ( $field[ 'choices' ] as $option_name => $option_label ) {
						update_post_meta( $post_id, $option_name, thtk_sanitize_checkbox( $_POST[ $option_name ], $option_label ) );
					} // End foreach $field[ 'choices' ]
					break;

			} // End switch $field[ 'type' ]

		} // End foreach $metabox[ 'metabox_fields' ]
		
	} // End foreach $thtk_metaboxes

} // End thtk_metabox_save()
add_action( 'save_post', 'thtk_metabox_save' );


