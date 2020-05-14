<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbPermissions' ) ) {
/**
 * Class to handle plugin permissions for Restaurant Reservations
 *
 * @since 2.0.0
 */
class rtbPermissions {

	private $plugin_permissions;
	private $permission_level;

	public function __construct() {
		$this->plugin_permissions = array(
			"styling" => 2,
			"import" => 2,
			"export" => 2,
			"custom_fields" => 2,
			"mailchimp" => 2,
			"templates" => 2,
			"designer" => 2,
			"premium_view_bookings" => 2,
			"premium_table_restrictions" => 2,
			"payments" => 3,
			"reminders" => 3,
		);
	}

	public function set_permissions() {
		global $rtb_controller;

		if ( get_option( "rtb-permission-level" ) >= 2 ) { return; }

		$cffrtb = $rtb_controller->settings->get_setting( 'license-cffrtb' );
		$ebfrtb = $rtb_controller->settings->get_setting( 'license-ebfrtb' );
		$etfrtb = $rtb_controller->settings->get_setting( 'license-etfrtb' );

		$bookings_objects = get_posts( array( 'post_type' => array( RTB_BOOKING_POST_TYPE ) ) );

		$this->permission_level = ( ( ( is_array($cffrtb) and array_key_exists('status', $cffrtb) ) or ( is_array($ebfrtb) and array_key_exists('status', $ebfrtb) ) or ( is_array($etfrtb) and array_key_exists('status', $etfrtb) ) or get_option("mcfrtb_license_key") ) ? 2 : ( ! empty($bookings_objects) ? 1 : 0 ) );

		update_option( "rtb-permission-level", $this->permission_level );
	}

	public function get_permission_level() {
		$this->permission_level = get_option( "rtb-permission-level" );

		if ( ! $this->permission_level ) { $this->set_permissions(); }
	}

	public function check_permission( $permission_type = '' ) {
		if ( ! $this->permission_level ) { $this->get_permission_level(); }

		return ( array_key_exists( $permission_type, $this->plugin_permissions ) ? ( $this->permission_level >= $this->plugin_permissions[$permission_type] ? true : false ) : false );
	}

	public function update_permissions() {
		$this->permission_level = get_option( "rtb-permission-level" );
	}
}

}