<?php

// ----------------------------------------------------------------------------------
//	Register Front-End Styles And Scripts
// ----------------------------------------------------------------------------------

function grow_thinkup_child_frontscripts() {

	wp_enqueue_style( 'thinkup-style', get_template_directory_uri() . '/style.css', array( 'thinkup-bootstrap', 'thinkup-shortcodes' ) );
	wp_enqueue_style( 'grow-thinkup-style-boxed', get_stylesheet_directory_uri() . '/style.css', array( 'thinkup-style' ), wp_get_theme()->get('Version') );
}
add_action( 'wp_enqueue_scripts', 'grow_thinkup_child_frontscripts' );


// ----------------------------------------------------------------------------------
//	Hide blog options in customizer - Blog layout used
// ----------------------------------------------------------------------------------

function grow_thinkup_child_adminscripts() {

	if ( is_customize_preview() ) {

		// Add theme stylesheets
		wp_enqueue_style( 'grow-thinkup-child-backend', get_stylesheet_directory_uri() . '/styles/backend/style-backend.css', '', '' );

	}
}
add_action( 'admin_enqueue_scripts', 'grow_thinkup_child_adminscripts' );


// ----------------------------------------------------------------------------------
//	Update Options Array With Child Theme Color Values
// ----------------------------------------------------------------------------------

// Add child theme settings to options array - UPDATED 20180819
function grow_thinkup_updateoption_child_settings() {

	// Set theme name combinations
	$name_theme_upper = 'Grow';
	$name_theme_lower = strtolower( $name_theme_upper );

	// Set possible options names
	$name_options_free  = 'thinkup_redux_variables';
	$name_options_child   = $name_theme_lower . '_thinkup_child_settings_boxed';

	// Get options values (theme options)
	$options_free = get_option( $name_options_free );

	// Get child settinsg values
	$options_child_settings = get_option( $name_options_child );

	// Only set child settings values if not already set 
	if ( $options_child_settings != 1 ) {

		$options_free['thinkup_styles_skinswitch'] = '1';
		$options_free['thinkup_styles_skin']       = 'boxed';
		$options_free['thinkup_blog_style']        = 'option1';
		$options_free['thinkup_blog_style1layout'] = 'option2';

		// Add child settings to theme options array
		update_option( $name_options_free, $options_free );

	}

	// Set the child settings flag
	update_option( $name_options_child, 1 );

}
add_action( 'init', 'grow_thinkup_updateoption_child_settings', 999 );

// Remove child theme settings from options array - UPDATED 20180819
function grow_thinkup_removeoption_child_settings() {

	// Set theme name combinations
	$name_theme_upper = 'Grow';
	$name_theme_lower = strtolower( $name_theme_upper );

	// Set possible options names
	$name_options_free  = 'thinkup_redux_variables';
	$name_options_child   = $name_theme_lower . '_thinkup_child_settings_boxed';

	// Get options values (theme options)
	$options_free = get_option( $name_options_free );

	// Determine if Pro version is installed
	$themes = wp_get_themes();
	foreach ( $themes as $theme ) {
		if( $theme == $name_theme_upper . ' Pro' ) {
			$indicator_pro_installed = '1';
		}
	}

	// If Pro version is not installed then remove child settings on theme switch
	if ( $indicator_pro_installed !== '1' ) {

		$options_free['thinkup_styles_skinswitch'] = '';
		$options_free['thinkup_styles_skin']       = '';
		$options_free['thinkup_blog_style']        = '';
		$options_free['thinkup_blog_style1layout'] = '';

		// Add child settings to theme options array
		update_option( $name_options_free, $options_free );

	}

	// Delete the child settings flag
	delete_option( $name_options_child );

}
add_action('switch_theme', 'grow_thinkup_removeoption_child_settings');

