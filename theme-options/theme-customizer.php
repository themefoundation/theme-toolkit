<?php

/**
 * Theme customizer
 *
 * @package	Theme Toolkit
 * @subpackage	Theme Options
 */



/**
 * Gets the theme customizer array from the theme
 *
 * Provides a filter that is used by the theme to pass the theme customizer
 * array to the Theme Toolkit for processing.
 *
 * @since 1.0
 * @param array $thtk_customizer Array of theme customizer settings (empty by default).
 * @return array Array of theme customizer settings, usually defined in the theme's functions.php file.
 */
function thtk_get_customizer_array( $thtk_customizer = array() ) {

	// Provides filter for obtaining options array
	$thtk_customizer = apply_filters( 'thtk_customizer_filter', $thtk_customizer );

	// Returns the options array
	return $thtk_customizer;

} // End function thtk_get_theme_options_array()



/**
 * Adds the Customize link to the admin menu
 *
 * @since 1.0
 */
function thtk_customizer_menu() {

	// Applies a filter to the default text so that themes can replace with a translatable string.
	$thtk_customizer_title = apply_filters( 'thtk_theme_customizer_title', 'Customize' );

	// Adds the Customize link to the Appearance admin menu section
	add_theme_page( $thtk_customizer_title, $thtk_customizer_title, 'edit_theme_options', 'customize.php' );

} // End function thtk_customizer_menu()
add_action ( 'admin_menu', 'thtk_customizer_menu' );



/**
 * Displays customizer options
 *
 * Creates customizer options based on the customizer array, usually set in the
 * theme's functions.php file.
 *
 * @since 1.0
 * @param object $wp_customize The WordPress theme customizer object.
 */
function thtk_display_customizer_content( $wp_customize ) {

	$customizer_array = thtk_get_customizer_array();

	// Loops through each array element and calls the corresponding display function.
	foreach ( $customizer_array as $section ) {

		// Adds settings sections
		thtk_add_customizer_section($wp_customize, $section);

		foreach ( $section[ 'section_settings' ] as $setting ) {
			thtk_add_customizer_setting( $wp_customize, $section[ 'section_id' ], $setting );

		} // End foreach $customizer_section[ 'section_settings' ]

	} // End foreach $customizer_array

} // End function thtk_display_customizer_content()
add_action( 'customize_register', 'thtk_display_customizer_content' );



/**
 * Adds settings sections to the theme customizer
 *
 * @since 1.0
 * @param object $wp_customize The WordPress theme customizer object.
 * @param array $section Section specific data used to add the section to the customizer.
 */
function thtk_add_customizer_section( $wp_customize, $section ) {
	extract( $section );

	// Defines array to pass to add_control().
	$section_array = array(
		'title' => $section_title,
	);

	// Sets optional description property.
	if ( !empty( $section_description ) ) {
		$section_array[ 'description' ] = $section_description;
	} // End if

	// Sets optional priority property.
	if ( !empty( $section_priority ) ) {
		$section_array[ 'priority' ] = $section_priority;
	} // End if

	// Sets optional theme_supports property.
	if ( !empty( $section_theme_supports ) ) {
		$section_array[ 'theme_supports' ] = $section_theme_supports;
	} // End if

	// Adds settings section to theme customizer.
	$wp_customize->add_section( $section_id, $section_array );

} // End function thtk_add_customizer_section()



/**
 * Adds individual settings and controls to the theme customizer
 *
 * @since 1.0
 * @param object $wp_customize The WordPress theme customizer object.
 * @param string $section Section name. Setting will be attached to this section.
 * @param array $setting Setting specific data used to add the setting to the customizer.
 */
function thtk_add_customizer_setting( $wp_customize, $section, $setting) {
	extract( $setting );

	if ( !empty( $default ) ) {
		// Defines array to pass to add_setting().
		$setting_array[ 'default' ] = $default;
	} // End if

	// Sets optional theme support property.
	if ( !empty( $theme_supports ) ) {
		$setting_array[ 'theme-supports' ] = $theme_supports;
	} // End if

	// Sets optional priority property.
	if ( !empty( $transport ) ) {
		$setting_array[ 'transport' ] = $transport;
	} // End if

	// Sets default input sanitization if empty.
	if ( empty( $valid ) ) {
		switch ( $type ) {
			case 'color':
				$valid = 'color';
				break;
			default:
				$valid = 'text';
		} // End switch ( $type )

	} // End if

	// Adds sanitization callbacks.
	switch ( $valid ) {
		case 'text':
			$setting_array[ 'sanitize_callback' ] = 'sanitize_text_field';
			break;
		case 'html':
			$setting_array[ 'sanitize_callback' ] = 'thtk_sanitize_html';
			break;
		case 'url':
			$setting_array[ 'sanitize_callback' ] = 'esc_url_raw';
			break;
		case 'email':
			$setting_array[ 'sanitize_callback' ] = 'sanitize_email';
			break;
		case 'integer':
			$setting_array[ 'sanitize_callback' ] = 'thtk_sanitize_integer';
			break;
		case 'currency':
			$setting_array[ 'sanitize_callback' ] = 'thtk_sanitize_currency';
			break;
		case 'color':
			$setting_array[ 'sanitize_callback' ] = 'sanitize_hex_color';
			break;
		default:
			// If $valid isn't recognized by the toolkit, it sets the value of the variable
			// as the callback function name. This allows a custom callback function to be
			// called from the customizer setup array, typically in the functions.php file.
			$setting_array[ 'sanitize_callback' ] = $valid;
	} // End switch ( $valid )

	// Sets optional js sanitization.
	if ( !empty( $valid_js ) ) {
		$setting_array[ 'sanitize_js_callback' ] = $valid_js;
	} // End if

	// Sets optional transport method.
	if ( !empty( $transport ) ) {
		$setting_array[ 'transport' ] = $transport;
	} // End if

	// Adds setting to theme customizer.
	$wp_customize->add_setting( $id, $setting_array );

	// Defines array to pass to add_control().
	$control_array = array(
		'label' => $title,
		'section' => $section,
		'type' => $type,
	);

	// Sets optional priority property.
	if ( !empty( $priority ) ) {
		$control_array[ 'priority' ] = $priority;
	} // End if

	// Sets choices if element is multiple choice.
	if ( $type == 'select' || $type == 'radio' ) {
		$control_array[ 'choices' ] = $choices;
	} // End if

	// Adds setting control to theme customizer.
	if ( in_array( $type, array( 'text', 'checkbox', 'radio', 'select', 'dropdown-pages' ) ) ) {
		$wp_customize->add_control( $id, $control_array );
	} else {
		switch ( $type ) {
			case 'color':
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, $control_array ) );
				break;
			case 'upload':
				$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, $id, $control_array ) );
				break;
			case 'image':
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, $control_array ) );
				break;
			case 'textarea':
				$wp_customize->add_control( new THTK_Customize_Textarea_Control( $wp_customize, $id, $control_array ) );
				break;
		} // End switch ( $type )

	}  // End if/else
} // End function thtk_add_customizer_setting



// Checks to make sure WP_Customize_Control class exists before extending it.
if( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Adds textarea support to the theme customizer
	 *
	 * Much of the code for this class was taken from Otto's tutorial on
	 * custom controls:
	 * http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer
	 *
	 * @since 1.0
	 */
	class THTK_Customize_Textarea_Control extends WP_Customize_Control {

		/**
		 * @access public
		 * @var string The type of form element being generated.
		 */
		public $type = 'textarea';

		/**
		 * Overrides the render_content() function in the parent class
		 *
		 * @since 1.0
		 */
		public function render_content() {
			?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
				</label>
			<?php
		}
	} // End class THTK_Customize_Textarea_Control
} // End if

