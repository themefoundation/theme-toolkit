<?php
/**
 * Post thumbnails
 *
 * @package Theme Toolkit
 * @subpackage Post Thumbnails
 */

//TODO: Investigate cropping functionality.



/**
 * Post thumbnails class
 *
 * @since 1.0
 */
class THTK_Post_Thumbnails{

	/**
	 * Sets default post thumbnail properties
	 *
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $defaults = array(
		'width' => 0,
		'height' => 0,
		'crop' => false,
		'hook' => '',
		'before' => '',
		'after' => '',
		'class' => '',
	);



	/**
	 * Receives the post thumbnails array
	 *
	 * Constructor function which runs when the class is instantiated.
	 *
	 * @since 1.0
	 */
	public function __construct( $post_thumbnails ){
		$this->post_thumbnails = $post_thumbnails;
		add_action( 'init', array( $this, 'post_thumbnails_setup' ) );
	} // End function __construct()



	/**
	 * Registers post thumbnails
	 *
	 * Loops through post thumbnail array (usually set in the theme's
	 * functions.php file) and builds thumbnails into the theme.
	 *
	 * @since 1.0
	 */
	public function post_thumbnails_setup() {

		// Checks to make sure the post thumbnail array is populated.
		if ( !empty( $this->post_thumbnails ) ) {

			// Loops through the post thumbnail array.
			foreach ( $this->post_thumbnails as $post_thumbnail ) {

				$thumbnail = wp_parse_args( $post_thumbnail, $this->defaults );

				add_image_size(
					$thumbnail[ 'id' ],
					$thumbnail[ 'width' ],
					$thumbnail[ 'height' ],
					$thumbnail[ 'crop' ]
				);

				if( !empty( $thumbnail[ 'hook' ] ) ) {
					add_action(
						$thumbnail[ 'hook' ],
						array( $this, 'post_thumbnails_display' )
					);
				} // End if
			} // End foreach $this->post_thumbnails
		} // End if
	} // End function post_thumbnails_setup()

	/**
	 * Registers post thumbnails
	 *
	 * Loops through post thumbnail array (usually set in the theme's
	 * functions.php file) and builds thumbnails into the theme.
	 *
	 * @since 1.0
	 */
	public function post_thumbnails_display() {

		// Checks to make sure the post thumbnail array is populated.
		if ( !empty( $this->post_thumbnails ) ) {

			$count = 0;

			// Loops through the post thumbnail array.
			foreach ( $this->post_thumbnails as $post_thumbnail ) {

				// Checks to make sure a hook is specified.
				if( !empty( $post_thumbnail[ 'hook' ] ) ) {

					// If the hook has been called, echo the thumbnail.
					if( did_action( $post_thumbnail['hook'] ) > 0 ) {

						$thumbnail = wp_parse_args( $post_thumbnail, $this->defaults );

						if ( has_post_thumbnail() ) {
							the_post_thumbnail( $thumbnail[ 'id' ] );
						} // End if

						// Remove this element from the post thumbnail array.
						unset( $this->post_thumbnails[ $count ] );

					} // End if
				} // End if

				$count++;

			} // End foreach $this->post_thumbnails
		} // End if
	} // End function post_thumbnails_display()
} // End class THTK_Post_Thumbnails