<?php
/**
 * Custom meta boxes
 *
 * @package Theme Toolkit
 * @subpackage Meta Boxes
 */

//TODO: figure out why $valid is "text" not "color" for color fields and why specifying "color" fails and messes with the checkbox sanitization as well.


/**
 * Meta box class
 *
 * @since 1.0
 */
class THTK_Meta_Boxes{

	/**
	 * @access private
	 * @var string
	 */
	public $color_pickers = '';



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

		// Loops through the meta boxes array.
		foreach ( $this->meta_boxes as $meta_box ) {

			// Loops through individual meta box fields
			foreach ( $meta_box[ 'meta_box_fields'] as $meta_box_field ) {

				// Checks for color picker field.
				if ( $meta_box_field[ 'type' ] == 'color' ) {
					$this->color_pickers[] = $meta_box_field[ 'id' ];
				} // End if

			} // End foreach $meta_box[ 'meta_box_fields']

		} // End foreach $this->meta_boxes

		if( !empty( $this->color_pickers ) ) {
			add_action( 'admin_head', array( $this, 'color_picker_js' ) );
		} // End if

	} // End function __construct()



	/**
	 * Adds meta boxes to appropriate admin pages
	 *
	 * Loops through meta box array (usually set in the theme's functions.php file)
	 * and creates meta boxes by calling the $this->meta_box_content() function.
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
					} // End if

					if( empty( $meta_box[ 'priority' ] ) ) {
						$meta_box[ 'priority' ] = 'high';
					} // End if

					add_meta_box(
						$meta_box[ 'id' ],
						$meta_box[ 'title' ],
						array( $this, 'meta_box_content' ),
						$page,
						$meta_box[ 'context' ],
						$meta_box[ 'priority' ],
						$meta_box[ 'meta_box_fields' ]
					);

				} // End foreach $meta_box[ 'post_type' ]

			} // End foreach $this->meta_boxes

		} // End if

	} // End function meta_box_setup()



	/**
	 * Generates custom color picker javascript code
	 *
	 * @since 1.0
	 */
	public function color_picker_js() {

		// Enqueues required styles and scripts
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		echo '<script>';
		echo 'jQuery(document).ready(function($){';

		foreach( $this->color_pickers as $color_picker ) {
			echo '$("#' . $color_picker . '").wpColorPicker();';
		} // End foreach $this->color_pickers

		echo '});';
		echo '</script>';

	} // End function color_picker_js()



	/**
	 * Displays meta box content
	 *
	 * Displays meta box content based on the meta box array, usually set in the
	 * theme's functions.php file.
	 *
	 * @since 1.0
	 * @param array $post The current post object.
	 * @param array $meta_box_fields The fields that will populate the meta box.
	 */
	public function meta_box_content( $post, $meta_box_fields ) {
		echo '<div class="thtk-meta-box"><table class="form-table">';

		// Sets security nonce
		wp_nonce_field( 'thtk_meta_box_nonce', 'meta_box_nonce' );

		// Gets stored values from the database.
		$values = get_post_custom( $post->ID );

		$thtk_input = new THTK_Form_Meta_Box();

		// Loops through each array element and calls the corresponding display function.
		foreach( $meta_box_fields[ 'args' ] as $meta_box_field ) {

			// Sets previously stored value and checks for new description.
			$meta_box_field[ 'value' ] = isset( $values[ $meta_box_field[ 'id' ] ] ) ? esc_attr( $values[ $meta_box_field[ 'id' ] ][ 0 ] ) : '';

			// Uses the THTK_Form_Meta_Box class to dispay the meta box setting.
			echo $thtk_input->get_meta_box( $meta_box_field );

		} // End foreach $meta_box_fields[ 'args' ]

		// HTML to match WordPress native formatting.
		echo '</table></div><!-- .thtk-meta-box -->';

	} // End function meta_box_content()



	/**
	 * Saves meta box values
	 *
	 * Saves the content of the custom meta boxes to the database.
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
		if ( !isset( $_POST[ 'meta_box_nonce' ] ) || !wp_verify_nonce( $_POST[ 'meta_box_nonce' ], 'thtk_meta_box_nonce' ) ) {
			return;
		} // End if

		// Exits if the current user can't edit the post.
		if ( !current_user_can( 'edit_post' ) ) {
			return;
		} // End if

		// Loops through the meta box arrays.
		foreach ( $this->meta_boxes as $meta_box ) {

			// Loops through the fields of each meta box array, sanitizing and saving input.
			foreach ( $meta_box[ 'meta_box_fields' ] as $field ) {

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

					case 'color':
						update_post_meta( $post_id, $field[ 'id' ], thtk_sanitize_text( $_POST[ $field[ 'id' ] ], $valid ) );
						break;

				} // End switch $field[ 'type' ]

			} // End foreach $meta_box[ 'meta_box_fields' ]

		} // End foreach $this->meta_boxes

	} // End function meta_box_save()

} // End THTK_Meta_Boxes
