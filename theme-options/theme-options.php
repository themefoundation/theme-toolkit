<?php

/**
 * Theme options
 *
 * @package	Theme Toolkit
 * @subpackage	Theme Options
 */




/**
 *  Gets the theme options array from the theme
 *
 * Provides a filter that is used by the theme to pass the theme options
 * array to the Theme Toolkit for processing.
 *
 * @since 1.0
 * @param array $thtk_theme_options Array of theme options settings (empty by default).
 * @return array Array of theme options settings, usually defined in the theme's functions.php file.
 */
function thtk_get_theme_options_array( $thtk_theme_options = array() ) {
	
	// Provides filter for obtaining options array 
	$thtk_theme_options = apply_filters( 'thtk_theme_options_filter', $thtk_theme_options );
	
	// Returns the options array
	return $thtk_theme_options;
	
} // End thtk_get_theme_options_array()



/**
 * Sets up theme options page, menu item, and javascript callback
 *
 * Adds the theme options menu item to the WordPress admin menu. Also attaches
 * the thtk_theme_options_enqueue_scripts() function to the
 * admin_enqueue_scripts action. This allows javascript files to be loaded
 * specifically for the theme options page rather than generically on every
 * WordPress admin page.
 *
 * @since 1.0
 */
function thtk_theme_options_setup() {
	
	global $thtk_theme_options_page;
	
	// Gets the theme options array.
	$thtk_theme_options = thtk_get_theme_options_array();
	
	// Adds theme options page using data from the theme options array.
	$thtk_theme_options_page = add_theme_page(
		$thtk_theme_options[ 'page_title' ],
		$thtk_theme_options[ 'menu_title' ],
		'edit_theme_options',
		$thtk_theme_options[ 'slug' ],
		'thtk_theme_options_template'
	);
	
	// Attaches the function used call page specific javascript files.
	add_action( 'admin_enqueue_scripts', 'thtk_theme_options_enqueue_scripts' );
	
} // End thtk_theme_options_setup()
add_action( 'admin_menu', 'thtk_theme_options_setup' );



/**
 * Displays the theme options page template
 *
 * @since 1.0
 */
function thtk_theme_options_template() {
	
	// Gets the theme options array
	$thtk_theme_options = thtk_get_theme_options_array();
	
	// Displays the theme options page structure.
	?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2>Theme Options</h2>
			<?php settings_errors(); ?>
			<form action="options.php" method="post">
				<?php settings_fields( $thtk_theme_options[ 'option_group' ] ); ?>
				<?php do_settings_sections( $thtk_theme_options[ 'slug' ] ); ?>
				<input name="Submit" type="submit" class="button-primary" value="Save Changes" />
			</form>
		</div>
	<?php
} // End thtk_theme_options_template()



/**
 * Builds the theme options page content
 *
 * Displays the theme options page based on the theme options array, usually
 * defined in the theme's functions.php file.
 *
 * @since 1.0
 */
function thtk_theme_options_content() {

	// Gets the theme options array.
	$thtk_theme_options = thtk_get_theme_options_array();

	// Gets the option values stored in the database
	$thtk_stored_options = get_option( $thtk_theme_options[ 'option_group' ] );

	// Registers the theme options settings and sanitization callback.
	register_setting(
		$thtk_theme_options[ 'option_group' ],
		$thtk_theme_options[ 'option_group' ],
		'thtk_sanitize_theme_options'
	);

	// Loops through and creates settings sections.
	foreach ($thtk_theme_options[ 'settings_sections' ] as $section) {
		
		// Sets the default section callback if none is specified.
		$section[ 'section_callback' ] = isset( $section[ 'section_callback' ] ) ? $section[ 'section_callback' ] : '__return_false';
		
		// Creates the settings sections.
		add_settings_section(
			$section[ 'section_id' ],
			$section[ 'section_title' ],
			$section[ 'section_callback' ],
			$thtk_theme_options[ 'slug' ]
		);
		
		// Populates the settings sections.
		foreach ( $section[ 'section_fields' ] as $field) {
			
			// Defines the field details.
			$settings_field = 	array(	
				'id' => $field[ 'id' ],
				'name' => $thtk_theme_options[ 'option_group' ] . '[' . $field[ 'id' ] . ']',
			);

			// Adds the options array to the field details if this is a multiple choice field .
			if ( $field[ 'type' ] == 'select' || $field[ 'type' ] == 'radio' ) {
				$settings_field[ 'options' ] = $field[ 'options' ];
			}
			
			if ( $field[ 'type' ] == 'checkbox' ) {
				$settings_field[ 'label' ] = $field[ 'label' ];
			} // End if
			
			// Adds settings field if not multicheck input. Otherwise, loops through multicheck settings fields.
			if ( $field[ 'type' ] != 'multicheck' ) {
				
				// Adds the description to the field details if available.
				if ( isset( $field[ 'description' ] ) ) {
					$settings_field[ 'description' ] = $field[ 'description' ];
				}

				// Adds the previously stored value to the field details if available.
				if ( isset( $thtk_stored_options[ $field[ 'id' ] ] ) ) {
					$settings_field[ 'value' ] = $thtk_stored_options[ $field[ 'id' ] ];
				} else {
					$settings_field[ 'value' ] = '';
				}
				
				// Adds the settings field to the settings section.
				add_settings_field(
					$field[ 'id' ],
					$field[ 'title' ],
					'thtk_form_settings_' . $field[ 'type' ],
					$thtk_theme_options[ 'slug' ],
					$section[ 'section_id' ],
					$settings_field
				);
			
			} else {

				$title = $field[ 'title' ];
				$count = 1;
				$total = count( $field[ 'options' ] );
				
				foreach ( $field[ 'options' ] as $name => $label ) {

					if ( $count != 1 ) {
						$title = '';
					} 
					
					if ( $count == $total ) {
						
						// Adds the description to the field details if available.
						if ( isset( $field[ 'description' ] ) ) {
							$settings_field[ 'description' ] = $field[ 'description' ];
						}
					}	
					
					$settings_field[ 'id' ] = $name;
					$settings_field[ 'name' ] = $thtk_theme_options[ 'option_group' ] . '[' . $name . ']';
					$settings_field[ 'label' ] = $label;
					
					
					// Adds the previously stored value to the field details if available.
					if ( isset( $thtk_stored_options[ $name ] ) ) {
						$settings_field[ 'value' ] = $thtk_stored_options[ $name ];
					} else {
						$settings_field[ 'value' ] = '';
					}
					
					// Adds the settings field to the settings section.
					add_settings_field(
						$name,
						$title,
						'thtk_form_settings_multicheck',
						$thtk_theme_options[ 'slug' ],
						$section[ 'section_id' ],
						$settings_field
					);
					
					$count++;
				} // End foreach $field[ 'options' ]

			} // End if/else
		} // End foreach $section[ 'section_fields' ]
	} // End foreach $thtk_theme_options[ 'settings_sections' ]
} // End thtk_theme_options_content()
add_action( 'admin_init', 'thtk_theme_options_content' );



/**
 * Validates/sanitizes the submitted theme options values 
 *
 * Loops through the theme options array and checks the values that have been
 * submitted. By looping through the options array rather than the submitted
 * values, any fields not defined in the original options array will be
 * ignored. Submitted data is checked against expected data before saving.
 *
 * @since 1.0
 * @param array $input Should contain the newly submitted theme option data.
 * @return array Returns the sanitized data.
 */
function thtk_sanitize_theme_options( $input ) {
	
	// Gets the theme options array
	$thtk_theme_options = thtk_get_theme_options_array();
	
	// Loops through the settings sections
	foreach ( $thtk_theme_options[ 'settings_sections' ] as $section ) {
		foreach ( $section[ 'section_fields' ] as $field ) {

			// Calls sanitization functions and stores results based on the type of input field.
			switch ( $field[ 'type' ] ) {
				case 'text':
					$valid = isset( $field[ 'valid' ] ) ? $field[ 'valid' ] : 'text';
					$valid_settings[ $field[ 'id' ] ] = thtk_sanitize_text( $input[ $field[ 'id' ] ], $valid );
					break;
					
				case 'textarea':
					$valid = isset( $field[ 'valid' ] ) ? $field[ 'valid '] : 'text';
					$valid_settings[ $field[ 'id' ] ] = thtk_sanitize_text( $input[ $field[ 'id' ] ], $valid );
					break;
					
				case 'select':
					$valid_settings[ $field[ 'id' ] ] = thtk_sanitize_multiple_choice( $input[ $field[ 'id' ] ], $field[ 'options' ] );
					break;
					
				case 'radio':
					$valid_settings[ $field[ 'id' ] ] = thtk_sanitize_multiple_choice( $input[ $field[ 'id' ] ], $field[ 'options' ] );
					break;

				case 'checkbox':
					$valid_settings[ $field[ 'id' ] ] = thtk_sanitize_checkbox( $input[ $field[ 'id' ] ], $field[ 'label' ] );
					break;
					
				case 'multicheck':
					foreach ( $field['options'] as $name => $label ) {
						$valid_settings[ $name ] = thtk_sanitize_checkbox( $input[ $name ], $label );
					} // End foreach $field['options']
					break;
			} // End switch $field[ 'type' ]
		} // End foreach $section[ 'section_fields' ]
	} // End foreach $thtk_theme_options[ 'settings_sections' ]
	
	return $valid_settings;
} // End thtk_sanitize_theme_options()


