<?php
/**
 * Register Section - Upgrade (Top Level).
 *
 * @package ThinkUpThemes
 */

if( class_exists( 'WP_Customize_Control' ) ) {
	final class thinkup_customizer_customswitch_button_link_final {

		// Returns the instance.
		public static function get_instance() {

			static $instance = null;

			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup_actions();
			}

			return $instance;
		}

		// Constructor method.
		private function __construct() {}

		// Sets up initial actions.
		private function setup_actions() {

			// Register panels, sections, settings, controls, and partials.
			add_action( 'customize_register', array( $this, 'sections' ) );

			// Register scripts and styles for the controls.
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
		}

		// Sets up the customizer sections.
		public function sections( $manager ) {

			// Register custom section types.
			$manager->register_section_type( 'thinkup_customizer_customswitch_button_link' );

		}

		// Loads theme customizer CSS.
		public function enqueue_control_scripts() {

			wp_enqueue_script( 'thinkup-section-button-link', trailingslashit( get_template_directory_uri() ) . 'admin/main/inc/sections/button_link/section_button_link.js', array( 'customize-controls' ), time() );

			wp_enqueue_style( 'thinkup-section-button-link', trailingslashit( get_template_directory_uri() ) . 'admin/main/inc/sections/button_link/section_button_link.css', '', time() );

		}
	}

	// Output for use
	thinkup_customizer_customswitch_button_link_final::get_instance();
}