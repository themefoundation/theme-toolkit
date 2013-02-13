<?php
/**
 * Custom metaboxes
 *
 * @package Theme Toolkit
 * @subpackage Metaboxes
 */

/**
 * Meta box class
 *
 * @since 1.0
 */
class THTK_Meta_Boxes{

	/**
	 * Receives the meta box array
	 *
	 * Constructor function which runs when the class is instantiated.
	 *
	 * @since 1.0
	 */	
	public function __construct($meta_boxes){
		$this->meta_boxes = $meta_boxes;
			add_action( 'add_meta_boxes', array( $this, 'meta_box_setup' ) );
			add_action( 'save_post', array( $this, 'meta_box_save' ) );
	}



	/**
	 * Adds metaboxes to appropriate admin pages
	 *
	 * Loops through metabox array (usually set in the theme's functions.php file)
	 * and creates metaboxes by calling the $this->metabox_content() function.
	 *
	 * @since 1.0
	 */	
	public function meta_box_setup() {
		
		// Checks to make sure the meta boxes array is populated.
		if ( !empty( $this->meta_boxes ) ) {
			
			// Loops through the meta boxes array.
			foreach ( $this->meta_boxes as $meta_box ) {
				
				// Loops through the meta boxes based on page type.
				foreach ( $meta_box[ 'post_type' ] as $page ) {
					
					if( empty( $meta_box[ 'context' ] ) ) {
						$meta_box[ 'context' ] = 'normal';
					}
					
					if( empty( $meta_box[ 'priority' ] ) ) {
						$meta_box[ 'priority' ] = 'high';
					}
					
					add_meta_box(
						$meta_box[ 'id' ],
						$meta_box[ 'title' ],
						array( $this, 'meta_box_content' ),
						$page,
						$meta_box[ 'context' ],
						$meta_box[ 'priority' ],
						$meta_box[ 'metabox_fields' ]
					);
					
				} // End foreach $meta_box[ 'post_type' ]
			} // End foreach $this->meta_boxes
		} // End if
	} // End meta_box_setup()
	
	
	
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
	public function meta_box_content( $post, $meta_box_fields ) {
		echo '<div class="thtk-metabox"><table class="form-table">';
		
		// Sets security nonce
		wp_nonce_field( 'thtk_metabox_nonce', 'metabox_nonce' );
		
		// Gets stored values from the database.
		$values = get_post_custom( $post->ID );
		
		$thtk_input = new THTK_Form_Metabox();
		
		// Loops through each array element and calls the corresponding display function.
		foreach( $meta_box_fields[ 'args' ] as $meta_box_field ) {
	
			// Sets previously stored value and checks for new description.
			$meta_box_field[ 'value' ] = isset( $values[ $meta_box_field[ 'id' ] ] ) ? esc_attr( $values[ $meta_box_field[ 'id' ] ][ 0 ] ) : '';
		
			// Uses the THTK_Form_Metabox class to dispay the metabox setting.
			
			echo $thtk_input->get_metabox( $meta_box_field );
	
		} // End foreach $meta_box_fields[ 'args' ]
	
		// HTML to match WordPress native formatting.
		echo '</table></div><!-- .thtk-metabox -->';
		
	} // End meta_box_content()
	
	
	
	/**
	 * Saves metabox values
	 *
	 * Saves the content of the custom metaboxes to the database.
	 *
	 * @since 1.0
	 * @param int $post_id The current post id.
	 */
	public function meta_box_save( $post_id ) {
		
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
	
		// Loops through the metabox arrays.
		foreach ( $this->meta_boxes as $meta_box ) {
			
			// Loops through the fields of each metabox array, sanitizing and saving input.
			foreach ( $meta_box[ 'metabox_fields' ] as $field ) {
			
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
	
			} // End foreach $meta_box[ 'metabox_fields' ]
			
		} // End foreach $this->meta_boxes
	
	} // End meta_box_save()

} // End THTK_Meta_Boxes
