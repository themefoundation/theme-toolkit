<?php
/**
 * Custom menus
 *
 * @package Theme Toolkit
 * @subpackage Menus
 */

/**
 * Menu class
 *
 * @since 1.0
 */
class THTK_Menus{

	/**
	 * Sets default element properties
	 *
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $defaults = array(
		'menu' => '',
		'container' => 'div',
		'container_class' => '',
		'container_id' => '',
		'menu_class' => 'menu',
		'menu_id' => '',
		'echo' => true,
		'fallback_cb' => 'wp_page_menu',
		'before' => '',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth' => 0,
		'walker' => ''
	);



	/**
	 * Receives the menu array
	 *
	 * Constructor function which runs when the class is instantiated.
	 *
	 * @since 1.0
	 */	
	public function __construct($menus){
		$this->menus = $menus;
		add_action( 'init', array( $this, 'menu_setup' ), 100 );
	} // End __construct()



	/**
	 * Merges the arguments array with the defaults array.
	 *
	 * @since 1.0
	 * @param array $args The array of arguments to use when creating the form element.
	 */
	public function get_particulars( $args ) {
		$particulars = wp_parse_args( $args, $this->defaults );
		return $particulars;
	} // End get_particulars()



	/**
	 * Registers menus
	 *
	 * Loops through menus array (usually set in the theme's functions.php file)
	 * and registers menus.
	 *
	 * @since 1.0
	 */	
	public function menu_setup() {

		// Checks to make sure the menus array is populated.
		if ( !empty( $this->menus ) ) {
			$menu_registration = array();
			
			// Loops through the menu array.
			foreach ( $this->menus as $menu ) {

				// Checks to make sure input is set.
				if( !empty( $menu[ 'id' ] ) && !empty( $menu[ 'title' ] ) && !empty( $menu[ 'hook' ] ) ) {

					// Adds menu to the registration array.
					$menu_registration[ $menu[ 'id' ] ] = $menu[ 'title' ];

					// Adds menu callback.
					add_action( $menu[ 'hook' ], array($this, 'menu_display' ) );
				}
				
			} // End foreach $this->menus
			
			// Registers all nav menus in the registration array.
			register_nav_menus( $menu_registration );
			
		} // End if
	} // End menu_setup()
	
	
	
	/**
	 * Displays a menu
	 *
	 * This function is called to display a menu on the page. It takes the
	 * first item in the menu array and displays it, It then removes the
	 * current item from the menu array so that the next time it runs, it
	 * doesn't display the same menu again. 
	 *
	 * @since			1.0
	 */
	public function menu_display() {

		// Combines the menu array with the array of default values.
		$menu_particulars = $this->get_particulars( $this->menus[ 0 ] );
		
		// Creates the formatted nav menu array.
		$menu = array(
			'theme_location' => $menu_particulars[ 'id' ],
			'menu' => $menu_particulars[ 'menu' ],
			'container' => $menu_particulars[ 'container' ],
			'container_class' => $menu_particulars[ 'container_class' ],
			'container_id' => $menu_particulars[ 'container_id' ],
			'menu_class' => $menu_particulars[ 'menu_class' ],
			'menu_id' => $menu_particulars[ 'menu_id' ],
			'echo' => $menu_particulars[ 'echo' ],
			'fallback_cb' => $menu_particulars[ 'fallback_cb' ],
			'before' => $menu_particulars[ 'before' ],
			'after' => $menu_particulars[ 'after' ],
			'link_before' => $menu_particulars[ 'link_before' ],
			'link_after' => $menu_particulars[ 'link_after' ],
			'items_wrap' => $menu_particulars[ 'items_wrap' ],
			'depth' => $menu_particulars[ 'depth' ],
			'walker' => $menu_particulars[ 'walker' ],
		);
		
		// Displays the nav menu.
		wp_nav_menu( $menu );

		// Removes the current menu from the menu array.
		array_shift( $this->menus );
	} // End menu_display()

} // End THTK_Menus
