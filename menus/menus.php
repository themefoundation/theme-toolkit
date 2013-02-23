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
				
				// Adds menu to the registration array/
				$menu_registration[ $menu[ 'id' ] ] = $menu[ 'title' ];
				
				// Adds menu callback if hook is defined.  
				if( !empty( $menu[ 'hook' ] ) ) {
					add_action( $menu[ 'hook' ], array($this, 'menu_display' ) );
				}
				
			} // End foreach $this->menus
			
			// Registers all nav menus in the array at one time
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
		
		// Creates the formatted nav menu array.
		$menu = array(
			'theme_location' => $this->menus[ 0 ][ 'id' ],
			//'container' => 'div',
			//'container_id' => 'primary-menu',
			//'container_class' => 'menu',
		);
		
		// Displays the nav menu.
		wp_nav_menu( $menu );

		// Removes the current menu from the menu array.
		array_shift( $this->menus );

	}
	
	

} // End THTK_Menus
