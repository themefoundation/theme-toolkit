<?php
/**
 * Custom meta boxes
 *
 * @package Theme Toolkit
 * @subpackage Meta Boxes
 */

/**
 * Custom meta box class
 *
 * @since 1.0
 */
class THTK_Meta_Boxes{

	/**
	 * Stores color picker usage
	 *
	 * @since 1.0
	 * @access public
	 * @var string
	 */
	public $color_pickers = '';

	/**
	 * Stores file uploader usage
	 *
	 * @since 1.0
	 * @access public
	 * @var string
	 */
	public $file_uploaders = '';

	/**
	 * Stores image uploader usage
	 *
	 * @since 1.0
	 * @access public
	 * @var string
	 */
	public $image_uploaders = '';



	/**
	 * Receives the meta box array
	 *
	 * Constructor function which runs when the class is instantiated.
	 *
	 * @since 1.0
	 * @param array $meta_boxes Array of meta box settings.
	 */
	public function __construct( $meta_boxes ){
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

				// Checks for image uploader field.
				if ( $meta_box_field[ 'type' ] == 'file' ) {
					$this->file_uploaders[] = $meta_box_field[ 'id' ];
				} // End if

				// Checks for image uploader field.
				if ( $meta_box_field[ 'type' ] == 'image' ) {
					$this->image_uploaders[] = $meta_box_field[ 'id' ];
				} // End if

			} // End foreach $meta_box[ 'meta_box_fields']

		} // End foreach $this->meta_boxes

		if( !empty( $this->color_pickers ) ) {
			add_action( 'admin_head', array( $this, 'color_picker_js' ) );
		} // End if

		if( !empty( $this->file_uploaders ) ) {
			add_action( 'admin_head', array( $this, 'file_upload_js' ) );
		} // End if

		if( !empty( $this->image_uploaders ) ) {
			add_action( 'admin_head', array( $this, 'image_upload_js' ) );
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

		// Writes color picker javascript
		echo '<script>';
		echo 'jQuery(document).ready(function($){';

		foreach( $this->color_pickers as $color_picker ) {
			echo '$("#' . $color_picker . '").wpColorPicker();';
		} // End foreach $this->color_pickers

		echo '});';
		echo '</script>';

	} // End function color_picker_js()



	/**
	 * Generates custom file upload javascript code
	 *
	 * @since 1.0
	 */
	public function file_upload_js() {

		// Enqueues required styles and scripts.
		wp_enqueue_media();

		// Writes file upload javasript.
		echo '<script>';
		echo 'jQuery(document).ready(function($){';

		foreach ( $this->file_uploaders as $file_uploader ) {
			$uploader = array(
				'id' => $file_uploader,
				'type' => 'file',
				'title' => apply_filters( 'thtk_file_upload_title', 'Choose a File'),
				'button' => apply_filters( 'thtk_file_upload_button', 'Use this File'),
			);
			$this->upload_js( $uploader );
		} // End foreach $this->image_uploaders

		echo '});';
		echo '</script>';

	} // End function file_upload_js()



	/**
	 * Generates custom image upload javascript code
	 *
	 * @since 1.0
	 */
	public function image_upload_js() {

		// Enqueues required styles and scripts.
		wp_enqueue_media();

		// Writes image upload javascript.
		echo '<script>';
		echo 'jQuery(document).ready(function($){';

		foreach ( $this->image_uploaders as $image_uploader ) {
			$uploader = array(
				'id' => $image_uploader,
				'type' => 'image',
				'title' => apply_filters( 'thtk_image_upload_title', 'Choose an Image'),
				'button' => apply_filters( 'thtk_image_upload_button', 'Use this Image'),
			);
			$this->upload_js( $uploader );
		} // End foreach $this->image_uploaders

		echo '});';
		echo '</script>';

	} // End function image_upload_js()



	/**
	 * Generates custom upload javascript code
	 *
	 * Based in part on Thomas Griffin's New Media Image Uploader
	 * https://github.com/thomasgriffin/New-Media-Image-Uploader
	 *
	 * @since 1.0
	 * @param array $args Array of uploader settings (id, type, title, button).
	 */
	public function upload_js( $args ) {
			// Sets the image frame variable name
			$image_frame = 'meta_image_frame_' . $args['id'];
			?>
				// Instantiates the variable that holds the media library frame.
				var <?php echo $image_frame; ?>;
				// Runs when the image button is clicked.
				$('#<?php echo $args['id']; ?>-button').click(function(e){

					// Prevents the default action from occuring.
					e.preventDefault();

					// This section is commented out to prevent conflicts when multiple image uploaders are in use.

					// If the frame already exists, re-open it.
					if ( <?php echo $image_frame; ?> ) {
						<?php echo $image_frame; ?>.open();
						return;
					}

					// Sets up the media library frame
					<?php echo $image_frame; ?> = wp.media.frames.meta_image_frame = wp.media({
						title: '<?php echo $args['title']; ?>',
						button: { text:  '<?php echo $args['button']; ?>' },
						<?php
							if( $args['type'] == 'image' ) {
								echo 'library: { type: \'image\' }';
							}
						?>

					});

					// Runs when an image is selected.
					<?php echo $image_frame; ?>.on('select', function(){

						// Grabs the attachment selection and creates a JSON representation of the model.
						var media_attachment = meta_image_frame_<?php echo $args['id']; ?>.state().get('selection').first().toJSON();

						// Sends the attachment URL to our custom image input field.
						$('#<?php echo $args['id']; ?>').val(media_attachment.url);
					});

					// Opens the media library frame.
					<?php echo $image_frame; ?>.open();
				});
			<?php

	} // End function image_upload_js()



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

		$sanitize = new THTK_Sanitization();

		// Loops through the meta box arrays.
		foreach ( $this->meta_boxes as $meta_box ) {

			// Loops through the fields of each meta box array, sanitizing and saving input.
			foreach ( $meta_box[ 'meta_box_fields' ] as $field ) {

				// Calls sanitization functions and saves results based on the type of input field.
				switch ( $field[ 'type' ] ) {
					case 'text':
						$valid = isset( $field['valid'] ) ? $field['valid'] : 'text';
						update_post_meta( $post_id, $field[ 'id' ], $sanitize->sanitize_text( $_POST[ $field[ 'id' ] ], $valid ) );
						break;

					case 'textarea':
						$valid = isset( $field[ 'valid' ] ) ? $field[ 'valid' ] : 'text';
						update_post_meta( $post_id, $field[ 'id' ], $sanitize->sanitize_text( $_POST[ $field[ 'id' ] ], $valid ) );
						break;

					case 'select':
						update_post_meta( $post_id, $field[ 'id' ], $sanitize->sanitize_multiple_choice( $_POST[ $field[ 'id' ] ], $field[ 'choices' ] ) );
						break;

					case 'radio':
						update_post_meta( $post_id, $field[ 'id' ], $sanitize->sanitize_multiple_choice( $_POST[ $field[ 'id' ] ], $field[ 'choices' ] ) );
						break;

					case 'checkbox':
						update_post_meta( $post_id, $field[ 'id' ], $sanitize->sanitize_checkbox( $_POST[ $field[ 'id' ] ], $field[ 'label' ] ) );
						break;

					case 'multicheck':
						foreach ( $field[ 'choices' ] as $option_name => $option_label ) {
							update_post_meta( $post_id, $option_name, $sanitize->sanitize_checkbox( $_POST[ $option_name ], $option_label ) );
						} // End foreach $field[ 'choices' ]
						break;

					case 'color':
						update_post_meta( $post_id, $field[ 'id' ], $sanitize->sanitize_text( $_POST[ $field[ 'id' ] ], $valid ) );
						break;

					case 'file':
						$valid = isset( $field['valid'] ) ? $field['valid'] : 'text';
						update_post_meta( $post_id, $field[ 'id' ], $sanitize->sanitize_text( $_POST[ $field[ 'id' ] ], $valid ) );
						break;

					case 'image':
						$valid = isset( $field['valid'] ) ? $field['valid'] : 'text';
						update_post_meta( $post_id, $field[ 'id' ], $sanitize->sanitize_text( $_POST[ $field[ 'id' ] ], $valid ) );
						break;

				} // End switch $field[ 'type' ]

			} // End foreach $meta_box[ 'meta_box_fields' ]

		} // End foreach $this->meta_boxes

	} // End function meta_box_save()

} // End THTK_Meta_Boxes
