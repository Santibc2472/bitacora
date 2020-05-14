<?php
/**
 * Class used to add in MailChimp compatibility
 */
if ( ! defined( 'ABSPATH' ) )
	exit;

if ( !class_exists( 'mcfrtbInit' ) ) {
class mcfrtbInit {

	public $api_key = null;

	public $status = null;

	public $api_call_cache = array();

	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'init' ) );

	}

	/**
	 * Initialize the plugin and register hooks
	 */
	public function init() {
		global $rtb_controller;

		// Initialize the plugin
		add_action( 'init', array( $this, 'load_config' ), 9 ); // Load before the settings panel is defined in Restaurant Reservations
		add_action( 'mcfrtb_list_merge_fields', array( $this, 'maybe_add_location_merge_field' ) );
		add_action( 'mcfrtb_list_merge_fields', array( $this, 'maybe_add_merge_options' ) );

		// Load assets
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

		// Receive ajax calls for mailchimp lists
		add_action( 'wp_ajax_nopriv_mcfrtb-get-lists' , array( $this , 'ajax_nopriv_get_lists' ) );
		add_action( 'wp_ajax_mcfrtb-get-lists', array( $this, 'ajax_get_lists' ) );

		// Receive ajax calls for merge fields
		add_action( 'wp_ajax_nopriv_mcfrtb-load-merge-fields' , array( $this , 'ajax_nopriv_load_merge_fields' ) );
		add_action( 'wp_ajax_mcfrtb-load-merge-fields', array( $this, 'ajax_load_merge_fields' ) );


		// Process subscription calls
		add_action( 'wp_ajax_nopriv_mcfrtb-subscribe' , array( $this , 'subscribe' ) );
		add_action( 'wp_ajax_mcfrtb-subscribe', array( $this, 'subscribe' ) );
		add_filter( 'mcfrtb_merge_fields_data', array( $this, 'maybe_send_location_merge_field' ), 10, 3 );
		add_filter( 'mcfrtb_merge_fields_data', array( $this, 'maybe_send_merge_fields' ), 10, 3 );

		// Only add the opt-in details with the frontend form
		if ( !is_admin() and $rtb_controller->permissions->check_permission( 'mailchimp' ) ) {

			// Add optin checkbox to booking form
			add_filter( 'rtb_booking_form_fields', array( $this, 'add_optin_field' ), 10, 2 );

			// Validate the optin request data
			add_filter( 'rtb_validate_booking_submission', array( $this, 'validate_optin_request' ) );

			// Enqueue assets to send subscription request
			add_filter( 'rtb_insert_booking', array( $this, 'enqueue_subscription_call' ) );
		}
	}


	/**
	 * Load the configuration parameters
	 */
	public function load_config() {

		global $rtb_controller;
		$api_key = $rtb_controller->settings->get_setting( 'mc-apikey' );

		$this->api_key = $api_key['api_key'];
		$this->status = $api_key['status'];

		$this->merge_fields = apply_filters(
			'mcfrtb_list_merge_fields',
			array(
				'datetime'	=> __( 'Date/Time of Booking', 'restaurant-reservations' ),
				'name'		=> __( 'Name', 'restaurant-reservations' ),
				'party'		=> __( 'Party Size', 'restaurant-reservations' ),
				'phone'		=> __( 'Phone Number', 'restaurant-reservations' ),
				'message'	=> __( 'Message', 'restaurant-reservations' ),
			)
		);

	}

	/**
	 * Add merge field for location if multi-location support is active
	 *
	 * @param array $fields Key/value list of booking data available for merge
	 * @since 1.2
	 */
	public function maybe_add_location_merge_field( $fields ) {

		global $rtb_controller;

		if ( !empty( $rtb_controller->locations ) && !empty( $rtb_controller->locations->post_type ) ) {
			$fields['location'] = __( 'Location', 'restaurant-reservations' );
		}

		return $fields;
	}

	/**
	 * Add merge field options for custom fields
	 *
	 * @param array $fields Key/value list of booking data available for merge
	 * @since 1.3
	*/
	public function maybe_add_merge_options( $fields ) {
	
		$custom_fields = rtb_get_custom_fields();
	
		$custom_merge_fields = array();
		foreach( $custom_fields as $custom_field ) {
			$custom_merge_fields['cf-' . $custom_field->slug] = $custom_field->title;
		}
	
		return array_merge( $fields, $custom_merge_fields );
	}

	/**
	 * Enqueue the admin-only CSS and Javascript
	 * @since 0.0.1
	 */
	public function enqueue_admin_assets() {

		global $rtb_controller;

		// Use the page reference in $admin_page_hooks because
		// it changes in SOME hooks when it is translated.
		// https://core.trac.wordpress.org/ticket/18857
		global $admin_page_hooks;

		$screen = get_current_screen();
		if ( empty( $screen ) || empty( $admin_page_hooks['rtb-bookings'] ) ) {
			return;
		}

		if ( $screen->base == 'toplevel_page_rtb-bookings' || $screen->base == $admin_page_hooks['rtb-bookings'] . '_page_rtb-settings' ) {

			wp_enqueue_script( 'rtb-admin-mc', RTB_PLUGIN_URL . '/assets/js/mailchimp-admin.js', array( 'jquery' ), '', true );
			wp_localize_script(
				'rtb-admin-mc',
				'rtb_admin_mc',
				array(
					'ajax_nonce'	=> wp_create_nonce( 'rtb-admin-mc' ),
					'merge_fields'	=> $this->merge_fields,
					'lists'			=> $rtb_controller->settings->get_setting( 'mc-lists' ),
					'strings'		=> array(
						'merge_booking_data'      => __( 'Booking Form Data', 'restaurant-reservations' ),
						'merge_list_field'        => __( 'MailChimp List Field', 'restaurant-reservations' ),
						'merge_description'       => __( 'Connect information from the booking request to <a href="http://kb.mailchimp.com/article/getting-started-with-merge-tags" target="_blank">merge fields</a> in your MailChimp list.', 'restaurant-reservations' ),
						'api_unknown_error'       => __( 'There was an unexpected error when trying to retrieve the list\'s merge fields.', 'restaurant-reservations' ),
						'merge_email_label'       => __( 'Email', 'restaurant-reservations' ),
						'merge_email_description' => __( 'The email field is automatically merged.', 'restaurant-reservations' ),
					)
				)
			);
		}
	}


	/**
	 * Handle ajax request for lists from logged out user
	 */
	public function ajax_nopriv_get_lists() {

		wp_send_json_error(
			array(
				'error' => 'loggedout',
				'msg' => __( 'You have been logged out. Please login again to retrieve the mailing lists.', 'restaurant-reservations' ),
			)
		);
	}

	/**
	 * Handle ajax request for lists
	 */
	public function ajax_get_lists() {

		if ( !check_ajax_referer( 'rtb-admin-mc', 'nonce' ) ||  !current_user_can( 'manage_options' )) {
			wp_send_json_error(
				array(
					'error' => 'nopriv',
					'msg' => __( 'You do not have permission to retrieve the mailing lists. Please login to an administrator account if you have one.', 'restaurant-reservations' ),
				)
			);
		}

		$this->load_api( $this->api_key );

		$this->api_call( '/lists' )->send_json_response();
	}

	/**
	 * Handle ajax request for list merge fields from logged out user
	 */
	public function ajax_nopriv_load_merge_fields() {

		wp_send_json_error(
			array(
				'error' => 'loggedout',
				'msg' => __( 'You have been logged out. Please login again to retrieve the merge fields for this list.', 'restaurant-reservations' ),
			)
		);
	}

	/**
	 * Handle ajax request for list merge fields
	 */
	public function ajax_load_merge_fields() {

		if ( !check_ajax_referer( 'rtb-admin-mc', 'nonce' ) ||  !current_user_can( 'manage_options' ) || empty( $_POST['list'] ) ) {
			wp_send_json_error(
				array(
					'error' => 'nopriv',
					'msg' => __( 'You do not have permission to modify the merge field settings. Please login to an administrator account if you have one.', 'restaurant-reservations' ),
				)
			);
		}

		$this->load_api( $this->api_key );

		$this->api_call( '/lists/' . sanitize_key( $_POST['list'] ) . '/merge-fields' )->send_json_response();
	}

	/**
	 * Load the api request class
	 *
	 * @param string $api_key MailChimp API key
	 */
	public function load_api( $api_key = '' ) {

		// Don't load it twice
		if ( !empty( $this->mc ) ) {
			return;
		}

		require_once( RTB_PLUGIN_DIR . '/includes/MailChimpRequest.class.php' );

		// Update the api key
		if ( $api_key ) {
			$this->api_key = $api_key;
		}

		// Load the API wrapper library
		$this->mc = new mcrftbMailChimpRequest( $this->api_key );
	}

	/**
	 * Make a call to the API or pull results from cache
	 *
	 * @param string $method HTTP method. Only GET and POST supported for now
	 * @param string $endpoint API endpoint to query, eg: /lists
	 * @param array $params Parameters to pass with the API request
	 */
	public function api_call( $endpoint = '',  $method = 'GET', $params = array() ) {
		return $this->mc->call( $endpoint, $method, $params );
	}

	/**
	 * Check if the API key is valid
	 */
	public function is_valid_api_key() {

		if ( empty( $this->api_key ) || empty( $this->mc ) ) {
			return false;
		}

		// Bad API key if no data center available
		if ( strpos( $this->api_key, '-' ) === false ) {
			return false;
		}

		// Make a test call to the API
		$result = $this->api_call( '/lists' )->get_response();
		if ( empty( $result ) || ( is_object( $result ) && get_class( $result ) == 'WP_Error' ) ) {
			return false;
		} else {
			return true;
		}

		return false;
	}

	/**
	 * Add the optin checkbox field to the booking form
	 */
	public function add_optin_field( $fields, $request ) {

		global $rtb_controller;
		$optout = $rtb_controller->settings->get_setting( 'mc-optout' );
		$lists = $rtb_controller->settings->get_setting( 'mc-lists' );

		if ( $optout !== 'no' && !empty( $lists['list'] ) ) {
			$optprompt = $rtb_controller->settings->get_setting( 'mc-optprompt' );

			$fields['optin'] = array(
				'fields'	=> array(
					'mc-optin'	=> array(
						'title'		=> $optprompt,
						'request_input'	=> empty( $request->mc_optin ) ? '' : $request->mc_optin,
						'callback'		=> array( $this, 'print_optin_field' ),
					)
				),
				'order'		=> 1000,
			);
		}

		return $fields;
	}

	/**
	 * Print the optin checkbox field on the booking form
	 */
	public function print_optin_field( $slug, $title, $value ) {

		global $rtb_controller;
		$optout = $rtb_controller->settings->get_setting( 'mc-optout' );
		$lists = $rtb_controller->settings->get_setting( 'mc-lists' );

		// Check the box if it's been selected or if the setting is
		// auto-checked and the form hasn't been submitted with it
		// un-checked
		$checked = $value ? true : false;
		if ( !$checked && $optout == 'checked' && ( empty( $_POST['action'] ) || $_POST['action'] !== 'booking_request' ) ) {
			$checked = true;
		}

		if ( $optout !== 'no' && !empty( $lists['list'] ) ) {
			$label = $rtb_controller->settings->get_setting( 'mc-optprompt' );
			?>

			<div class="mc-optin">
				<label>
					<input type="checkbox" name="<?php echo esc_attr( $slug ); ?>" value="1"<?php checked( $checked ); ?>>
					<?php echo $label; ?>
				</label>
			</div>

			<?php
		}
	}

	/**
	 * Validate the optin request data
	 */
	public function validate_optin_request( $request ) {

		global $rtb_controller;
		if ( $rtb_controller->settings->get_setting( 'mc-optout' ) !== 'no' && !empty( $_POST['mc-optin'] ) && $_POST['mc-optin'] == '1' ) {
			$request->mc_optin = true;
		}
	}

	/**
	 * Enqueue some JavaScript to subscribe the user after they've
	 * booked.
	 */
	public function enqueue_subscription_call( $booking ) {

		global $rtb_controller;

		// Did they opt out?
		$optout = $rtb_controller->settings->get_setting( 'mc-optout' );
		if ( !$optout && empty( $booking->mc_optin ) ) {
			return;
		}

		// Do we have a list and email address to make the subscription
		$lists = $rtb_controller->settings->get_setting( 'mc-lists' );
		if ( empty( $lists['list'] ) || empty( $booking->email ) ) {
			return;
		}

		wp_enqueue_script( 'rtb-mc-subscribe', RTB_PLUGIN_URL . '/assets/js/mailchimp-subscribe.js', array( 'jquery' ), '', true );
		wp_localize_script(
			'rtb-mc-subscribe',
			'rtb_subscribe_mc',
			array(
				'ajax_nonce'	=> wp_create_nonce( 'rtb-mc-subscribe' ),
				'ajax_url'		=> admin_url( 'admin-ajax.php' ),
				'booking'		=> $booking,
			)
		);

	}

	/**
	 * Process a subscription request
	 */
	public function subscribe() {

		if ( !check_ajax_referer( 'rtb-mc-subscribe', 'nonce' ) || empty( $_POST['booking'] ) ) {
			wp_send_json_error(
				array(
					'error' => 'badnonce',
					'msg' => __( 'The subscription request has been rejected because it does not appear to have come from this site.', 'restaurant-reservations' ),
				)
			);

			return;
		}

		$booking = $_POST['booking'];

		global $rtb_controller;

		// Did they opt out?
		$optout = $rtb_controller->settings->get_setting( 'mc-optout' );
		if ( $optout != 'no' && empty( $booking['mc_optin'] ) ) {
			return;
		}

		// Do we have a list and email address to make the subscription
		$lists = $rtb_controller->settings->get_setting( 'mc-lists' );
		if ( empty( $lists['list'] ) || empty( $booking['email'] ) ) {
			return;
		}

		// Prepare post parameters to send
		$params = array(
			'email_address' => $booking['email'],
			'status' => 'pending',
			'merge_fields' => (object) $this->get_merge_fields_data( $lists['fields'], $booking ),
		);

		// Pass in the user's IP for geolocation if available
		if ( !empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$params['ip_signup'] = $_SERVER['REMOTE_ADDR'];
			$params['ip_opt'] = $_SERVER['REMOTE_ADDR'];
		}

		$params = apply_filters( 'mcfrtb_mailchimp_subscribe_args', $params, $booking );

		$this->load_api( $this->api_key );

		$this->api_call( '/lists/' . $lists['list'] . '/members', 'POST', $params )->send_json_response();
	}

	/**
	 * Get merge fields array to send to the MailChimp API
	 *
	 * @merge_fields array Merge fields data pulled locally from settings
	 */
	public function get_merge_fields_data( $merge_fields, $booking ) {

		$output = array();

		foreach( $this->merge_fields as $field => $title ) {
			if ( !empty( $merge_fields[$field] ) ) {

				if ( $field == 'datetime' ) {
					$output[$merge_fields[$field]] = $booking['date'];
				}

				if ( $field == 'name' ) {
					$output[$merge_fields[$field]] = $booking['name'];
				}

				if ( $field == 'party' ) {
					$output[$merge_fields[$field]] = $booking['party'];
				}

				if ( $field == 'phone' ) {
					$output[$merge_fields[$field]] = $booking['phone'];
				}

				if ( $field == 'message' ) {
					$output[$merge_fields[$field]] = $booking['message'];
				}
			}
		}

		return apply_filters( 'mcfrtb_merge_fields_data', $output, $merge_fields, $booking );
	}

	/**
	 * Add location to the data merge field when appropriate
	 *
	 * @param array $send Key/value array of merge data to be sent
	 * @param array $merge_fields Key/value array of configured merge fields
	 * @param rtbBooking $booking Booking object
	 * @since 1.2
	 */
	public function maybe_send_location_merge_field( $send, $merge_fields, $booking ) {

		global $rtb_controller;

		if ( empty( $rtb_controller->locations ) || empty( $rtb_controller->locations->post_type ) ) {
			return $send;
		}

		if ( !empty( $booking['location'] ) && !empty( $merge_fields['location'] ) ) {
			$term = get_term( $booking['location'] );
			if ( !empty( $term ) && is_a( $term, 'WP_Term' ) ) {
				$send[$merge_fields['location']] = $term->name;
			}
		}

		return $send;
	}

	/**
	 * Send merge field data for custom fields
	 *
	 * @param array $send Key/value array of merge data to be sent
	 * @param array $merge_fields Key/value array of configured merge fields
	 * @param rtbBooking $booking Booking object
	 * @since 1.3
	 */
	public function maybe_send_merge_fields( $send, $merge_fields, $booking ) {
		global $rtb_controller;
	
		$custom_fields = rtb_get_custom_fields();
	
		foreach( $custom_fields as $custom_field ) {
			if ( !empty( $merge_fields['cf-' . $custom_field->slug] ) && isset( $booking['custom_fields'] ) && isset( $booking['custom_fields'][$custom_field->slug] ) ) {
				if ( $custom_field->type == 'confirm' ) {
					$send[$merge_fields['cf-' . $custom_field->slug]] = 'Checked';
				} else {
					$send[$merge_fields['cf-' . $custom_field->slug]] = $rtb_controller->fields->get_display_value( $booking['custom_fields'][$custom_field->slug], $custom_field, '', false );
				}
			}
		}
	
		return $send;
	}
}
} // endif;
