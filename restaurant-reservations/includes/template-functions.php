<?php
/**
 * Template functions for rendering booking forms, etc.
 */

/**
 * Create a shortcode to render the booking form
 * @since 0.0.1
 */
if ( !function_exists( 'rtb_booking_form_shortcode' ) ) {
function rtb_booking_form_shortcode( $args = array() ) {

	$args = shortcode_atts(
		array(
			'location' => 0,
		),
		$args,
		'booking-form'
	);

	return rtb_print_booking_form( $args );
}
add_shortcode( 'booking-form', 'rtb_booking_form_shortcode' );
} // endif;

/**
 * Print the booking form's HTML code, including error handling and confirmation
 * notices.
 * @since 0.0.1
 */
if ( !function_exists( 'rtb_print_booking_form' ) ) {
function rtb_print_booking_form( $args = array() ) {

	global $rtb_controller;

	// Only allow the form to be displayed once on a page
	if ( $rtb_controller->form_rendered === true ) {
		return;
	} else {
		$rtb_controller->form_rendered = true;
	}

	// Run cancellation request if parameters are included
	if ( isset($_GET['action']) and $_GET['action'] == 'cancel' ) {
		$rtb_controller->ajax->cancel_reservation( false );
	}

	// Sanitize incoming arguments
	if ( isset( $args['location'] ) ) {
		$args['location'] = $rtb_controller->locations->get_location_term_id( $args['location'] );
	} else {
		$args['location'] = 0;
	}

	// Enqueue assets for the form
	rtb_enqueue_assets();

	// Custom styling
	$styling = rtb_add_custom_styling();

	// Allow themes and plugins to override the booking form's HTML output.
	$output = apply_filters( 'rtb_booking_form_html_pre', '' );
	if ( !empty( $output ) ) {
		return $output;
	}

	// Process a booking request
	if ( !empty( $_POST['action'] ) and $_POST['action'] == 'booking_request' ) {

		if ( get_class( $rtb_controller->request ) === 'stdClass' ) {
			require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );
			$rtb_controller->request = new rtbBooking();
		}

		$rtb_controller->request->insert_booking();
	}

	// Define the form's action parameter
	$booking_page = $rtb_controller->settings->get_setting( 'booking-page' );
	if ( !empty( $booking_page ) ) {
		$booking_page = get_permalink( $booking_page );
	}

	// Retrieve the form fields
	$fields = $rtb_controller->settings->get_booking_form_fields( $rtb_controller->request, $args );

	ob_start();

	?>

	<script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>

    <?php echo $styling; ?>

    <?php echo apply_filters( 'rtb_booking_form_before_html', '' ); ?>

<div class="rtb-booking-form">
	<?php if ( ( $rtb_controller->request->request_inserted === true and ! $rtb_controller->settings->get_setting( 'require-deposit' ) ) or ( isset($_GET['payment']) and $_GET['payment'] == 'paid' ) ) : ?>

		<?php
		if($rtb_controller->request->post_status == 'confirmed'){
			if( $rtb_controller->settings->get_setting('confirmed-redirect-page') != '' ){
				header( 'location:' . $rtb_controller->settings->get_setting('confirmed-redirect-page') );
			}
			else{
				?>
				<div class="rtb-message">
					<p><?php echo $rtb_controller->settings->get_setting('confirmed-message'); ?></p>
				</div>
				<?php
			}
		}
		else{
			if( $rtb_controller->settings->get_setting('pending-redirect-page') != '' ){
				header( 'location:' . $rtb_controller->settings->get_setting('pending-redirect-page') );
			}
			else{
				?>
				<div class="rtb-message">
					<p><?php echo $rtb_controller->settings->get_setting('success-message'); ?></p>
				</div>
				<?php
			}
		}
		?>

	<?php elseif ( $rtb_controller->request->request_inserted === true ) : ?>
		<?php rtb_print_payment_form(); ?>
	<?php elseif ( isset($_POST['stripeToken']) ) : ?>
		<?php rtb_process_stripe_payment(); ?>
	<?php elseif ( isset($_GET['payment']) ) : ?>
		<div class="rtb-message">
			<p><?php _e( 'Your reservation deposit payment has failed. Please contact the site administrator for assistance.', 'restaurant-reservations' ) ?></p>
		</div>
	<?php elseif ( isset($_GET['bookingCancelled']) and $_GET['bookingCancelled'] == 'success') : ?>
	<div class="rtb-message">
		<p><?php _e( 'Your reservation has been successfully cancelled.', 'restaurant-reservations' ) ?></p>
	</div>
	<?php else : ?>

	<?php if ( $rtb_controller->settings->get_setting( 'allow-cancellations' ) ) : ?>
		<div class="rtb-cancellation-toggle"><?php _e( 'Want to cancel your reservation?', 'restaurant-reservations' ); ?></div>
		<div class="rtb-clear"></div>
		<form class="rtb-cancellation-form rtb-hidden">
			<div><?php _e( 'Use the form below to cancel your reservation', 'restaurant-reservations' ); ?></div>
			<label for="rtb-cancellation-email"><?php _e( 'Email:',  'restaurant-reservations' ); ?></label>
			<input type="email" name="rtb_cancellation_email" />
			<div class="rtb-clear"></div>
			<div class="rtb-cancel-button"><?php _e( 'Find Reservations', 'restaurant-reservations' ); ?></div>
			<div class="rtb-clear"></div>
			<div class="rtb-bookings-results"></div>
		</form>
	<?php endif; ?>

	<form method="POST" action="<?php echo esc_attr( $booking_page ); ?>" class="rtb-booking-form-form">
		<input type="hidden" name="action" value="booking_request">

		<?php if ( !empty( $args['location'] ) ) : ?>
			<input type="hidden" name="rtb-location" value="<?php echo absint( $args['location'] ); ?>">
		<?php endif; ?>

		<?php do_action( 'rtb_booking_form_before_fields' ); ?>

		<?php foreach( $fields as $fieldset => $contents ) :
			$fieldset_classes = isset( $contents['callback_args']['classes'] ) ? $contents['callback_args']['classes'] : array();
			$legend_classes = isset( $contents['callback_args']['legend_classes'] ) ? $contents['callback_args']['legend_classes'] : array();
		?>
		<fieldset <?php echo rtb_print_element_class( $fieldset, $fieldset_classes ); ?>>

			<?php if ( !empty( $contents['legend'] ) ) : ?>
			<legend <?php echo rtb_print_element_class( '', $legend_classes ); ?>>
				<?php echo $contents['legend']; ?>
			</legend>
			<?php endif; ?>

			<?php
				foreach( $contents['fields'] as $slug => $field ) {

					$callback_args = empty( $field['callback_args'] ) ? array() : $field['callback_args'];

					if ( !empty( $field['required'] ) ) {
						$callback_args = array_merge( $callback_args, array( 'required' => $field['required'] ) );
					}

					call_user_func( $field['callback'], $slug, $field['title'], $field['request_input'], $callback_args );
				}
			?>
		</fieldset>
		<?php endforeach; ?>

		<?php do_action( 'rtb_booking_form_after_fields' ); ?>

		<div id='rtb_recaptcha'></div>
		<?php echo rtb_print_form_error( 'recaptcha' ); ?>

		<?php
			$button_text = $rtb_controller->settings->get_setting( 'require-deposit' ) ? __( 'Proceed to Deposit', 'restaurant-reservations' ) : __( 'Request Booking', 'restaurant-reservations' );
			
			$button = sprintf(
				'<button type="submit">%s</button>',
				apply_filters( 'rtb_booking_form_submit_label', $button_text )
			);

			echo apply_filters( 'rtb_booking_form_submit_button', $button );
		?>


	</form>
	<?php endif; ?>
</div>

	<?php

	$output = ob_get_clean();

	$output = apply_filters( 'rtb_booking_form_html_post', $output );

	return $output;
}
} // endif;

/**
 * Print the payment form's HTML code, after a new booking has been inserted
 * notices.
 * @since 2.1.0
 */
if ( !function_exists( 'rtb_print_payment_form' ) ) {
function rtb_print_payment_form( $args = array() ) { 
	global $rtb_controller;

	// Define the form's action parameter
	$booking_page = $rtb_controller->settings->get_setting( 'booking-page' );
	if ( !empty( $booking_page ) ) {
		$booking_page = get_permalink( $booking_page );
	}

	if ( $rtb_controller->settings->get_setting( 'rtb-payment-gateway' ) == "paypal" ) { ?>
		<form action='https://www.paypal.com/cgi-bin/webscr' method='post' class='standard-form'>
		<input type='hidden' name='item_name_1' value='<?php echo substr(get_bloginfo('name'), 0, 100); ?> Reservation Deposit' />
		<input type='hidden' name='custom' value='booking_id=<?php echo $rtb_controller->request->ID; ?>' />
		<input type='hidden' name='quantity_1' value='1' />
		<input type='hidden' name='amount_1' value='<?php echo $rtb_controller->request->calculate_deposit(); ?>' />
		<input type='hidden' name='cmd' value='_cart' />
		<input type='hidden' name='upload' value='1' />
		<input type='hidden' name='business' value='<?php echo $rtb_controller->settings->get_setting( 'rtb-paypal-email' ); ?>' />
		<input type='hidden' name='currency_code' value='<?php echo $rtb_controller->settings->get_setting( 'rtb-currency' ); ?>' />
		<input type='hidden' name='return' value='<?php $booking_page; ?>' />
		<input type='hidden' name='notify_url' value='<?php echo get_site_url(); ?>' />			
		<input type='submit' class='submit-button' value='Pay via PayPal' />
		</form>
	<?php } else { 
		wp_enqueue_script( 'rtb-stripe', RTB_PLUGIN_URL . '/assets/js/stripe.js', array( 'jquery' ), RTB_VERSION, true );
		wp_enqueue_script( 'rtb-stripe-payment', RTB_PLUGIN_URL . '/assets/js/stripe-payment.js', array( 'jquery', 'rtb-stripe' ), RTB_VERSION, true );

		wp_localize_script(
			'rtb-stripe-payment',
			'rtb_stripe_payment',
			array(
				'stripe_mode' => $rtb_controller->settings->get_setting( 'rtb-stripe-mode' ),
				'live_publishable_key' => $rtb_controller->settings->get_setting( 'rtb-stripe-live-publishable' ),
				'test_publishable_key' => $rtb_controller->settings->get_setting( 'rtb-stripe-test-publishable' ),
			)
		);
		
		$payment_amount = $rtb_controller->settings->get_setting( 'rtb-currency-symbol-location' ) == 'before' ? $rtb_controller->settings->get_setting( 'rtb-stripe-currency-symbol' ) . $rtb_controller->request->calculate_deposit() : $rtb_controller->request->calculate_deposit() . $rtb_controller->settings->get_setting( 'rtb-stripe-currency-symbol' ); 
		?>
		
		<h2><?php echo __('Deposit Required: ', 'restaurant-reservations' ) .  $payment_amount; ?></h2>

		<form action='#' method='POST' id='stripe-payment-form'>
			<div class='form-row'>
				<label><?php _e('Card Number', 'restaurant-reservations'); ?></label>
				<input type='text' size='20' autocomplete='off' data-stripe='card_number'/>
			</div>
			<div class='form-row'>
				<label><?php _e('CVC', 'restaurant-reservations'); ?></label>
				<input type='text' size='4' autocomplete='off' data-stripe='card_cvc'/>
			</div>
			<div class='form-row'>
				<label><?php _e('Expiration (MM/YYYY)', 'restaurant-reservations'); ?></label>
				<input type='text' size='2' data-stripe='exp_month'/>
				<span> / </span>
				<input type='text' size='4' data-stripe='exp_year'/>
			</div>
			<input type='hidden' name='action' value='rtb_stripe_booking_payment'/>
			<input type='hidden' name='currency' value='<?php echo $rtb_controller->settings->get_setting( 'rtb-currency' ); ?>' data-stripe='currency' />
			<input type='hidden' name='payment_amount' value='<?php echo $rtb_controller->request->calculate_deposit(); ?>' />
			<input type='hidden' name='booking_id' value='<?php echo $rtb_controller->request->ID; ?>' />
			<button type='submit' id='stripe-submit'><?php _e( 'Make Deposit', 'restaurant-reservations'); ?></button>
		</form>
	<?php }
}
} // endif;

/**
 * Process Stripe payments for reservation deposits
 * @since 2.1.0
 */
if ( !function_exists( 'rtb_display_bookings_form_shortcode' ) ) {
function rtb_process_stripe_payment() {
	global $rtb_controller;

	$booking_id = isset($_POST['booking_id']) ? absint( $_POST['booking_id'] ) : 0;

	if ( ! $booking_id ) { return; }

	// Define the form's action parameter
	$booking_page = $rtb_controller->settings->get_setting( 'booking-page' );
	if ( !empty( $booking_page ) ) {
		$booking_page = get_permalink( $booking_page );
	}
	else { $booking_page = get_permalink(); }
		
 
	// load the stripe libraries
	require_once(RTB_PLUGIN_DIR . '/lib/stripe/init.php');
		
	// retrieve the token generated by stripe.js
	$token = $_POST['stripeToken'];

	$payment_amount = ( $rtb_controller->settings->get_setting( 'rtb-currency' ) != "JPY" ? $_POST['payment_amount'] * 100 : $_POST['payment_amount'] );

	$stripe_secret = $rtb_controller->settings->get_setting( 'rtb-stripe-mode' ) == 'test' ? $rtb_controller->settings->get_setting( 'rtb-stripe-test-secret' ) : $rtb_controller->settings->get_setting( 'rtb-stripe-live-secret' );
 
	try {
		\Stripe\Stripe::setApiKey( $stripe_secret );
		$charge = \Stripe\Charge::create(array(
				'amount' => $payment_amount, 
				'currency' => strtolower( $rtb_controller->settings->get_setting( 'rtb-currency' ) ),
				'card' => $token
			)
		);

		require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );
		$booking = new rtbBooking();
		$booking->load_post( $booking_id );

		$booking->deposit = ( $rtb_controller->settings->get_setting( 'rtb-currency' ) != "JPY" ? $payment_amount / 100 : $payment_amount );
		$booking->receipt_id = $charge->id;

		$booking->determine_status( true );

		$booking->insert_post_data();

		// redirect on successful payment
		$redirect = add_query_arg('payment', 'paid', $booking_page);
	 
	} catch (Exception $e) { update_option( "rtb-payment-error", print_r($e, true) );
		// redirect on failed payment
		$redirect = add_query_arg('payment', 'failed', $booking_page);
	}
 
	// redirect back to our previous page with the added query variable
	wp_redirect($redirect); exit;
}
} // endif;


// If there's an IPN request, add our setup function to potentially handle it
if ( isset($_POST['ipn_track_id']) ) { add_action( 'init', 'rtb_setup_paypal_ipn', 1); }

/**
 * Sets up the PayPal IPN process
 * @since 2.1.0
 */
if ( !function_exists( 'rtb_handle_paypal_ipn' ) ) {
function rtb_setup_paypal_ipn() {
	global $rtb_controller;

	if ( ! $rtb_controller->settings->get_setting( 'require-deposit' ) ) { return; }
	
	rtb_handle_paypal_ipn();
	add_action('init', 'rtb_add_ob_start');
	add_action('shutdown', 'rtb_flush_ob_end');
}
} // endif;

/**
 * Handle PayPal IPN requests
 * @since 2.1.0
 */
if ( !function_exists( 'rtb_handle_paypal_ipn' ) ) {
function rtb_handle_paypal_ipn() {
	
	// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
	// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
	// Set this to 0 once you go live or don't require logging.
	define("DEBUG", 0);
	// Set to 0 once you're ready to go live
	define("USE_SANDBOX", 0);
	define("LOG_FILE", "./ipn.log");
	// Read POST data
	// reading posted data directly from $_POST causes serialization
	// issues with array data in POST. Reading raw POST data from input stream instead.
	$raw_post_data = file_get_contents('php://input');
	$raw_post_array = explode('&', $raw_post_data);
	$myPost = array();
	foreach ($raw_post_array as $keyval) {
		$keyval = explode ('=', $keyval);
		if (count($keyval) == 2)
			$myPost[$keyval[0]] = urldecode($keyval[1]);
	}
	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	if(function_exists('get_magic_quotes_gpc')) {
		$get_magic_quotes_exists = true;
	}
	foreach ($myPost as $key => $value) {
		if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
			$value = urlencode(stripslashes($value));
		} else {
			$value = urlencode($value);
		}
		$req .= "&$key=$value";
	}
	// Post IPN data back to PayPal to validate the IPN data is genuine
	// Without this step anyone can fake IPN data
	if(USE_SANDBOX == true) {
		$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	} else {
		$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
	}

	$response = wp_remote_post($paypal_url, array(
		'method' => 'POST',
		'body' => $req,
		'timeout' => 30
	));

	// Inspect IPN validation result and act accordingly
	// Split response headers and payload, a better way for strcmp
	$tokens = explode("\r\n\r\n", trim($response['body']));
	$res = trim(end($tokens));
	if (strcmp ($res, "VERIFIED") == 0) {
		
		$paypal_receipt_number = $_POST['txn_id'];
		$payment_amount = $_POST['mc_gross'];
		
		parse_str($_POST['custom'], $custom_vars);
		$booking_id = $custom_vars['booking_id'];

		require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );

		$booking = new rtbBooking();
		$booking->load_post( $booking_id );

		$booking->deposit = $payment_amount;
		$booking->receipt_id = $paypal_receipt_number;

		$booking->determine_status( true );

		$booking->insert_post_data();
		
		if ( DEBUG == true ) {
			error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
		}
	}
}
} // endif;

/**
 * Opens a buffer when handling PayPal IPN requests
 * @since 2.1.0
 */
if ( !function_exists( 'rtb_add_ob_start' ) ) {
function rtb_add_ob_start() { update_option( "EWD_Debugging2", "Second init function called" );
    ob_start();
}
} // endif;

/**
 * Closes a buffer when handling PayPal IPN requests
 * @since 2.1.0
 */
if ( !function_exists( 'rtb_flush_ob_end' ) ) {
function rtb_flush_ob_end() {
    ob_end_clean();
}
} // endif;

/**
 * Create a shortcode to view and (optionally) sign in bookings
 * @since 2.0.0
 */
if ( !function_exists( 'rtb_display_bookings_form_shortcode' ) ) {
function rtb_display_bookings_form_shortcode( $args = array() ) {

	$args = shortcode_atts(
		array(
			'location' => 0,
		),
		$args,
		'view-booking-form'
	);

	return rtb_print_view_bookings_form( $args );
}
add_shortcode( 'view-bookings-form', 'rtb_display_bookings_form_shortcode' );
} // endif;

/**
 * Print the display bookings form's HTML code, including error handling and confirmation
 * notices.
 * @since 2.0.0
 */
if ( !function_exists( 'rtb_print_view_bookings_form' ) ) {
function rtb_print_view_bookings_form( $args = array() ) {

	global $rtb_controller;

	// Only allow the form to be displayed once on a page
	if ( $rtb_controller->display_bookings_form_rendered === true ) {
		return;
	} else {
		$rtb_controller->display_bookings_form_rendered = true;
	}

	// Sanitize incoming arguments
	if ( isset( $args['location'] ) ) {
		$args['location'] = $rtb_controller->locations->get_location_term_id( $args['location'] );
	} else {
		$args['location'] = 0;
	}
	if ( ! isset( $args['date'] ) ) {
		$args['date'] = date('Y-m-d');
	}

	// Enqueue assets for the form
	rtb_enqueue_assets();

	// Allow themes and plugins to override the booking form's HTML output.
	$output = apply_filters( 'rtb_display_bookings_form_html_pre', '' );
	if ( !empty( $output ) ) {
		return $output;
	}

	require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );

	$params = array(
		'post_type' => 'rtb-booking',
		'posts_per_page' => -1,
		'date_query' => array(
			'year' => substr($args['date'], 0, 4),
			'month' => substr($args['date'], 5, 2),
			'day' => substr($args['date'], 8, 2)
		),
		'post_status' => array_keys( $rtb_controller->cpts->booking_statuses ),
		'orderby' => 'date',
		'order' => 'ASC'
	);

	$query = new WP_Query( $params );

	ob_start();

	?>

<script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<?php echo apply_filters( 'rtb_display_bookings_form_before_html', '' ); ?>

<div class="rtb-view-bookings-form">

	<div class='rtb-view-bookings-form-date-selector-div'>
		<select class='rtb-view-bookings-form-date-selector'>
			<?php for ( $i=0; $i<7; $i++ ) { ?>
				<?php $timestamp = time() + $i * 3600*24; ?>
				<option value='<?php echo date('Y-m-d', $timestamp); ?>' <?php echo ( date('Y-m-d', $timestamp) == $args['date'] ? 'selected="selected"' : '' ); ?> ><?php echo date('l, F jS', $timestamp); ?></option>
			<?php } ?>
		</select>
	</div>

	<div class='rtb-view-bookings-form-confirmation-div rtb-hidden'>
		<div class='rtb-view-bookings-form-confirmation-div-inside'>
			<div id="rtb-view-bookings-form-close">x</div>
			<div class='rtb-view-bookings-form-confirmation-div-title'>
				<?php _e("Set reservation status to 'Arrived'?", 'restaurant-reservations'); ?>
			</div>
			<div class='rtb-view-bookings-form-confirmation-accept'><?php _e("Yes", 'restaurant-reservations'); ?></div>
			<div class='rtb-view-bookings-form-confirmation-decline'><?php _e("No", 'restaurant-reservations'); ?></div>
		</div>
	</div>
	<div class='rtb-view-bookings-form-confirmation-background-div rtb-hidden'></div>

	<table class='rtb-view-bookings-table'>
		<thead>
			<tr>
				<?php if ( $rtb_controller->settings->get_setting( 'view-bookings-arrivals' ) ) {?> <th><?php _e('Arrived', 'restaurant-reservations'); ?></th><?php } ?>
				<th><?php _e('Time', 'restaurant-reservations'); ?></th>
				<th><?php _e('Party', 'restaurant-reservations'); ?></th>
				<th><?php _e('Name', 'restaurant-reservations'); ?></th>
				<th><?php _e('Email', 'restaurant-reservations'); ?></th>
				<th><?php _e('Phone', 'restaurant-reservations'); ?></th>
				<th><?php _e('Status', 'restaurant-reservations'); ?></th>
				<th><?php _e('Details', 'restaurant-reservations'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $query->posts as $booking ) { ?>
				<?php $booking_object = new rtbBooking(); ?>
				<?php $booking_object->load_post( $booking->ID ); ?>
				<tr>
					<?php if ( $rtb_controller->settings->get_setting( 'view-bookings-arrivals' ) ) {?>
						<?php if ( $booking_object->post_status != 'arrived' ) : ?><td><input type='checkbox' class='rtb-edit-view-booking' data-bookingid='<?php echo $booking_object->ID; ?>' /></td></th>
						<?php else : ?><td></td>
						<?php endif; ?>
					<?php } ?>
					<td><?php echo date('H:i:s', strtotime($booking_object->date)); ?></td>
					<td><?php echo $booking_object->party; ?></td>
					<td><?php echo $booking_object->name; ?></td>
					<td><?php echo $booking_object->email; ?></td>
					<td><?php echo $booking_object->phone; ?></td>
					<td><?php echo $rtb_controller->cpts->booking_statuses[$booking_object->post_status]['label'] ?></td>
					<td><?php echo apply_filters( 'rtb_bookings_table_column_details', $booking_object->message, $booking_object ); ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

</div>

	<?php

	wp_reset_postdata();

	$output = ob_get_clean();

	$output = apply_filters( 'rtb_display_bookings_form_html_post', $output );

	return $output;
}
} // endif;

/**
 * Enqueue the front-end CSS and Javascript for the booking form
 * @since 0.0.1
 */
if ( !function_exists( 'rtb_enqueue_assets' ) ) {
function rtb_enqueue_assets() {

	global $rtb_controller;

	wp_enqueue_style( 'rtb-booking-form' );

	wp_enqueue_style( 'pickadate-default' );
	wp_enqueue_style( 'pickadate-date' );
	wp_enqueue_style( 'pickadate-time' );
	wp_enqueue_script( 'pickadate' );
	wp_enqueue_script( 'pickadate-date' );
	wp_enqueue_script( 'pickadate-time' );
	wp_enqueue_script( 'pickadate-legacy' );
	wp_enqueue_script( 'pickadate-i8n' ); // only registered if needed
	wp_enqueue_style( 'pickadate-rtl' ); // only registered if needed

	wp_enqueue_script( 'rtb-booking-form' );

	if ( $rtb_controller->settings->get_setting( 'enable-captcha' ) ) {
		$site_key = $rtb_controller->settings->get_setting( 'captcha-site-key' );

		wp_enqueue_script( 'rtb-google-recaptcha', 'https://www.google.com/recaptcha/api.js?hl=' . get_locale() . '&render=explicit&onload=rtbLoadRecaptcha' );
		wp_enqueue_script( 'rtb-process-recaptcha', RTB_PLUGIN_URL . '/assets/js/rtb-recaptcha.js', array( 'rtb-google-recaptcha' ) );

		wp_localize_script( 'rtb-process-recaptcha', 'rtb_recaptcha', array( 'site_key' => $site_key ) );
	}

	if ( function_exists('get_current_screen') ) {
		$screen = get_current_screen();
		$screenID = $screen->id;
	}
	else {
		$screenID = '';
	}
	
	if( $rtb_controller->settings->get_setting( 'rtb-styling-layout' ) == 'contemporary' && $screenID != 'toplevel_page_rtb-bookings' ){
		wp_enqueue_style( 'rtb-contemporary-css', RTB_PLUGIN_URL . '/assets/css/contemporary.css' );
	}
	if( $rtb_controller->settings->get_setting( 'rtb-styling-layout' ) == 'columns' && $screenID != 'toplevel_page_rtb-bookings' ){
		wp_enqueue_style( 'rtb-columns-css', RTB_PLUGIN_URL . '/assets/css/columns.css' );
		wp_enqueue_script( 'rtb-columns-js', RTB_PLUGIN_URL . '/assets/js/columns.js', array( 'jquery' ), '', true );
	}

	// Pass date and time format settings to the pickadate controls
	wp_localize_script(
		'rtb-booking-form',
		'rtb_pickadate',
		apply_filters(
			'rtb_pickadate_args',
			array(
				'date_format' => rtb_esc_js( $rtb_controller->settings->get_setting( 'date-format' ) ),
				'time_format'  => rtb_esc_js( $rtb_controller->settings->get_setting( 'time-format' ) ),
				'disable_dates'	=> rtb_get_datepicker_rules(),
				'schedule_open' => $rtb_controller->settings->get_setting( 'schedule-open' ),
				'schedule_closed' => $rtb_controller->settings->get_setting( 'schedule-closed' ),
				'early_bookings' => is_admin() && current_user_can( 'manage_bookings' ) ? '' : $rtb_controller->settings->get_setting( 'early-bookings' ),
				'late_bookings' => is_admin() && current_user_can( 'manage_bookings' ) ? '' : $rtb_controller->settings->get_setting( 'late-bookings' ),
				'enable_max_reservations' => is_admin() && current_user_can( 'manage_bookings' ) ? false : $rtb_controller->settings->get_setting( 'rtb-enable-max-tables' ),
				'date_onload' => $rtb_controller->settings->get_setting( 'date-onload' ),
				'time_interval' => $rtb_controller->settings->get_setting( 'time-interval' ),
				'first_day' => $rtb_controller->settings->get_setting( 'week-start' ),
				'allow_past' => is_admin() && current_user_can( 'manage_bookings' ),
			)
		)
	);

}
} // endif;

/**
 * Get rules for datepicker date ranges
 * See: http://amsul.ca/pickadate.js/date/#disable-dates
 * @since 0.0.1
 */
if ( !function_exists( 'rtb_get_datepicker_rules' ) ) {
function rtb_get_datepicker_rules() {

	global $rtb_controller;

	// First day of the week
	$first_day = (int) $rtb_controller->settings->get_setting( 'week-start' );

	$disable_rules = array();

	$disabled_weekdays = array(
		'sunday'	=> ( 1 - $first_day ) === 0 ? 7 : 1,
		'monday'	=> 2 - $first_day,
		'tuesday'	=> 3 - $first_day,
		'wednesday'	=> 4 - $first_day,
		'thursday'	=> 5 - $first_day,
		'friday'	=> 6 - $first_day,
		'saturday'	=> 7 - $first_day,
	);

	// Determine which weekdays should be disabled
	$enabled_dates = array();
	$schedule_open = $rtb_controller->settings->get_setting( 'schedule-open' );
	if ( is_array( $schedule_open ) ) {
		foreach ( $schedule_open as $rule ) {
			if ( !empty( $rule['weekdays'] ) ) {
				foreach ( $rule['weekdays'] as $weekday => $value ) {
					unset( $disabled_weekdays[ $weekday ] );
				}
			}
		}

		if ( count( $disabled_weekdays ) < 7 ) {
			foreach ( $disabled_weekdays as $weekday ) {
				$disable_rules[] = $weekday;
			}
		}
	}

	// Handle exception dates
	$schedule_closed = $rtb_controller->settings->get_setting( 'schedule-closed' );
	if ( is_array( $schedule_closed ) ) {
		foreach ( $schedule_closed as $rule ) {

			// Disable exception dates that are closed all day
			if ( !empty( $rule['date'] ) && empty( $rule['time'] ) ) {
				$date = new DateTime( $rule['date'] );
				$disable_rules[] = array( $date->format( 'Y' ), ( $date->format( 'n' ) - 1 ), $date->format( 'j' ) );

			// Enable exception dates that have opening times
			} elseif ( !empty( $rule['date'] ) ) {
				$date = new DateTime( $rule['date'] );
				$disable_rules[] = array( $date->format( 'Y' ), ( $date->format( 'n' ) - 1 ), $date->format( 'j' ), 'inverted' );
			}

		}
	}

	return apply_filters( 'rtb_datepicker_disable_rules', $disable_rules, $schedule_open, $schedule_closed );

}
} // endif;

/**
 * Print a text input form field
 * @since 1.3
 */
if ( !function_exists( 'rtb_print_form_text_field' ) ) {
function rtb_print_form_text_field( $slug, $title, $value, $args = array() ) {

	$slug = esc_attr( $slug );
	$value = esc_attr( $value );
	$type = empty( $args['input_type'] ) ? 'text' : esc_attr( $args['input_type'] );
	$classes = isset( $args['classes'] ) ? $args['classes'] : array();
	$classes[] = 'rtb-text';
	$required = isset( $args['required'] ) && $args['required'] ? ' required aria-required="true"' : '';

	?>

	<div <?php echo rtb_print_element_class( $slug, $classes ); ?>>
		<?php echo rtb_print_form_error( $slug ); ?>
		<label for="rtb-<?php echo $slug; ?>">
			<?php echo $title; ?>
		</label>
		<input type="<?php echo $type; ?>" name="rtb-<?php echo $slug; ?>" id="rtb-<?php echo $slug; ?>" value="<?php echo esc_attr( $value ); ?>"<?php echo $required; ?>>
	</div>

	<?php

}
} // endif;

/**
 * Print a textarea form field
 * @since 1.3
 */
if ( !function_exists( 'rtb_print_form_textarea_field' ) ) {
function rtb_print_form_textarea_field( $slug, $title, $value, $args = array() ) {

	$slug = esc_attr( $slug );
	// Strip out <br> tags when placing in a textarea
	$value = preg_replace('/\<br(\s*)?\/?\>/i', '', $value);
	$classes = isset( $args['classes'] ) ? $args['classes'] : array();
	$classes[] = 'rtb-textarea';
	$required = isset( $args['required'] ) && $args['required'] ? ' required aria-required="true"' : '';

	?>

	<div <?php echo rtb_print_element_class( $slug, $classes ); ?>>
		<?php echo rtb_print_form_error( $slug ); ?>
		<label for="rtb-<?php echo $slug; ?>">
			<?php echo $title; ?>
		</label>
		<textarea name="rtb-<?php echo $slug; ?>" id="rtb-<?php echo $slug; ?>"<?php echo $required; ?>><?php echo esc_html( $value ); ?></textarea>
	</div>

	<?php

}
} // endif;

/**
 * Print a select form field
 * @since 1.3
 */
if ( !function_exists( 'rtb_print_form_select_field' ) ) {
function rtb_print_form_select_field( $slug, $title, $value, $args ) {

	$slug = esc_attr( $slug );
	$value = esc_attr( $value );
	$options = is_array( $args['options'] ) ? $args['options'] : array();
	$classes = isset( $args['classes'] ) ? $args['classes'] : array();
	$classes[] = 'rtb-select';
	$required = isset( $args['required'] ) && $args['required'] ? ' required aria-required="true"' : '';

	?>

	<div <?php echo rtb_print_element_class( $slug, $classes ); ?>>
		<?php echo rtb_print_form_error( $slug ); ?>
		<label for="rtb-<?php echo $slug; ?>">
			<?php echo $title; ?>
		</label>
		<select name="rtb-<?php echo $slug; ?>" id="rtb-<?php echo $slug; ?>"<?php echo $required; ?>>
			<?php foreach ( $options as $opt_value => $opt_label ) : ?>
			<option value="<?php echo esc_attr( $opt_value ); ?>" <?php selected( $opt_value, $value ); ?>><?php echo esc_attr( $opt_label ); ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<?php

}
} // endif;

/**
 * Print a checkbox form field
 *
 * @since 1.3.1
 */
if ( !function_exists( 'rtb_print_form_checkbox_field' ) ) {
function rtb_print_form_checkbox_field( $slug, $title, $value, $args ) {

	$slug = esc_attr( $slug );
	$value = !empty( $value ) ? array_map( 'esc_attr', $value ) : array();
	$options = is_array( $args['options'] ) ? $args['options'] : array();
	$classes = isset( $args['classes'] ) ? $args['classes'] : array();
	$classes[] = 'rtb-checkbox';

	?>

	<div <?php echo rtb_print_element_class( $slug, $classes ); ?>>
		<?php echo rtb_print_form_error( $slug ); ?>
		<label>
			<?php echo $title; ?>
		</label>
		<?php foreach ( $options as $opt_value => $opt_label ) : ?>
		<label>
			<input type="checkbox" name="rtb-<?php echo $slug; ?>[]" id="rtb-<?php echo $slug; ?>-<?php echo esc_attr( $opt_value ); ?>" value="<?php echo esc_attr( $opt_value ); ?>"<?php echo !empty( $value ) && in_array( $opt_value, $value ) ? ' checked' : ''; ?>>
			<?php echo $opt_label; ?>
		</label>
		<?php endforeach; ?>
	</div>

	<?php
}
} // endif;

/**
 * Print a radio button form field
 *
 * @since 1.3.1
 */
if ( !function_exists( 'rtb_print_form_radio_field' ) ) {
function rtb_print_form_radio_field( $slug, $title, $value, $args ) {

	$slug = esc_attr( $slug );
	$value = esc_attr( $value );
	$options = is_array( $args['options'] ) ? $args['options'] : array();
	$classes = isset( $args['classes'] ) ? $args['classes'] : array();
	$classes[] = 'rtb-radio';
	$required = isset( $args['required'] ) && $args['required'] ? ' required aria-required="true"' : '';

	?>

	<div <?php echo rtb_print_element_class( $slug, $classes ); ?>>
		<?php echo rtb_print_form_error( $slug ); ?>
		<label>
			<?php echo $title; ?>
		</label>
		<?php foreach ( $options as $opt_value => $opt_label ) : ?>
		<label>
			<input type="radio" name="rtb-<?php echo $slug; ?>" id="rtb-<?php echo $slug; ?>" value="<?php echo esc_attr( $opt_value ); ?>" <?php checked( $opt_value, $value ); ?><?php echo $required; ?>>
			<?php echo $opt_label; ?>
		</label>
		<?php endforeach; ?>
	</div>

	<?php
}
} // endif;

/**
 * Print a confirm prompt form field
 *
 * @since 1.3.1
 */
if ( !function_exists( 'rtb_print_form_confirm_field' ) ) {
function rtb_print_form_confirm_field( $slug, $title, $value, $args ) {

	$slug = esc_attr( $slug );
	$value = esc_attr( $value );
	$classes = isset( $args['classes'] ) ? $args['classes'] : array();
	$classes[] = 'rtb-confirm';
	$required = isset( $args['required'] ) && $args['required'] ? ' required aria-required="true"' : '';

	?>

	<div <?php echo rtb_print_element_class( $slug, $classes ); ?>>
		<?php echo rtb_print_form_error( $slug ); ?>
		<label for="rtb-<?php echo $slug; ?>">
			<input type="checkbox" name="rtb-<?php echo $slug; ?>" id="rtb-<?php echo $slug; ?>" value="1" <?php checked( $value, 1 ); ?><?php echo $required; ?>>
			<?php echo $title; ?>
		</label>
	</div>

	<?php

}
} // endif;

/**
 * Print the Add Message link to display the message field
 * @since 1.3
 */
if ( !function_exists( 'rtb_print_form_message_link' ) ) {
function rtb_print_form_message_link( $slug, $title, $value, $args = array() ) {

	$slug = esc_attr( $slug );
	$value = esc_attr( $value );
	$classes = isset( $args['classes'] ) ? $args['classes'] : array();

	?>

	<div <?php echo rtb_print_element_class( $slug, $classes ); ?>>
		<a href="#">
			<?php echo $title; ?>
		</a>
	</div>

	<?php

}
} // endif;

/**
 * Print a form validation error
 * @since 0.0.1
 */
if ( !function_exists( 'rtb_print_form_error' ) ) {
function rtb_print_form_error( $field ) {

	global $rtb_controller;

	if ( !empty( $rtb_controller->request ) && !empty( $rtb_controller->request->validation_errors ) ) {
		foreach ( $rtb_controller->request->validation_errors as $error ) {
			if ( $error['field'] == $field ) {
				echo '<div class="rtb-error">' . $error['message'] . '</div>';
			}
		}
	}
}
} // endif;

/**
 * Print a class attribute based on the slug and optional classes, provided with arguments
 * @since 1.3
 */
if ( !function_exists( 'rtb_print_element_class' ) ) {
function rtb_print_element_class( $slug, $additional_classes = array() ) {
	$classes = empty( $additional_classes ) ? array() : $additional_classes;

	if ( ! empty( $slug ) ) {
		array_push( $classes, $slug );
	}

	$class_attr = esc_attr( join( ' ', $classes ) );

	return empty( $class_attr ) ? '' : sprintf( 'class="%s"', $class_attr );

}
} // endif;


/**
 * Retrieve an array of custom `cffrtbField` objects
 *
 * @since 0.1
 */
if ( !function_exists( 'rtb_get_custom_fields' ) ) {
function rtb_get_custom_fields() {

	$fields = array();

	// Avoid use of WP_Query here so that we don't tamper with the $post global.
	// This function gets called during `init` in the admin area, before
	// any $post global is setup, so wp_reset_postdata is unable to restore it
	// to `null` after modifying it. This caused issues, such as overriding the
	// date folder media uploads are saved into.
	$posts = get_posts( array( 'post_type' => 'cffrtb_field', 'post_status' => 'publish', 'posts_per_page' => 1000 ) );

	foreach ($posts as $post) {
		$fields[] = new cffrtbField(
			array(
				'ID'	=> $post->ID,
			)
		);
	}

	return $fields;
}
}

/**
 * Retrieve the submitted request data for a custom field
 *
 * @lookup int|string field ID or slug
 * @since 0.1
 */
if ( !function_exists( 'rtb_get_request_input' ) ) {
function rtb_get_request_input( $lookup, $request ) {

	// Retrieve slug from ID
	if ( is_int( $lookup ) ) {
		$post = get_post( $lookup );
		$lookup = $post->post_name;
	}

	if ( empty( $request->custom_fields ) || !isset( $request->custom_fields[ $lookup ] ) ) {
		return '';
	}

	return $request->custom_fields[ $lookup ];
}
}

if ( !function_exists( 'rtb_add_custom_styling' ) ) {
	function rtb_add_custom_styling() {
		global $rtb_controller;
		$styling = '<style>';
			if ( $rtb_controller->settings->get_setting('rtb-styling-section-title-font-family') != '' ) { $styling .= '.rtb-booking-form fieldset legend { font-family: \'' . $rtb_controller->settings->get_setting('rtb-styling-section-title-font-family') . '\' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-section-title-font-size') != '' ) { $styling .=  '.rtb-booking-form fieldset legend { font-size: ' . $rtb_controller->settings->get_setting('rtb-styling-section-title-font-size') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-section-title-color') != '' ) { $styling .=  '.rtb-booking-form fieldset legend { color: ' . $rtb_controller->settings->get_setting('rtb-styling-section-title-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-section-background-color') != '' ) { $styling .=  '.rtb-booking-form fieldset { background-color: ' . $rtb_controller->settings->get_setting('rtb-styling-section-background-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-section-border-color') != '' ) { $styling .=  '.rtb-booking-form fieldset { border-color: ' . $rtb_controller->settings->get_setting('rtb-styling-section-border-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-section-border-size') != '' ) { $styling .=  '.rtb-booking-form fieldset { border-width: ' . $rtb_controller->settings->get_setting('rtb-styling-section-border-size') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-label-font-family') != '' ) { $styling .=  '.rtb-booking-form fieldset label, .rtb-booking-form .add-message a { font-family: \'' . $rtb_controller->settings->get_setting('rtb-styling-label-font-family') . '\' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-label-font-size') != '' ) { $styling .=  '.rtb-booking-form fieldset label { font-size: ' . $rtb_controller->settings->get_setting('rtb-styling-label-font-size') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-label-color') != '' ) { $styling .=  '.rtb-booking-form fieldset label { color: ' . $rtb_controller->settings->get_setting('rtb-styling-label-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-add-message-button-background-color') != '' ) { $styling .=  '.rtb-booking-form .add-message a { background-color: ' . $rtb_controller->settings->get_setting('rtb-styling-add-message-button-background-color') . ' !important; border-color: ' . $rtb_controller->settings->get_setting('rtb-styling-add-message-button-background-color') . ' !important; padding: 6px 12px !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-add-message-button-background-hover-color') != '' ) { $styling .=  '.rtb-booking-form .add-message a:hover { background-color: ' . $rtb_controller->settings->get_setting('rtb-styling-add-message-button-background-hover-color') . ' !important; border-color: ' . $rtb_controller->settings->get_setting('rtb-styling-add-message-button-background-hover-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-add-message-button-text-color') != '' ) { $styling .=  '.rtb-booking-form .add-message a { color: ' . $rtb_controller->settings->get_setting('rtb-styling-add-message-button-text-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-add-message-button-text-hover-color') != '' ) { $styling .=  '.rtb-booking-form .add-message a:hover { color: ' . $rtb_controller->settings->get_setting('rtb-styling-add-message-button-text-hover-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-request-booking-button-background-color') != '' ) { $styling .=  '.rtb-booking-form form button { background-color: ' . $rtb_controller->settings->get_setting('rtb-styling-request-booking-button-background-color') . ' !important; border-color: ' . $rtb_controller->settings->get_setting('rtb-styling-request-booking-button-background-color') . ' !important; padding: 13px 28px !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-request-booking-button-background-hover-color') != '' ) { $styling .=  '.rtb-booking-form form button:hover { background-color: ' . $rtb_controller->settings->get_setting('rtb-styling-request-booking-button-background-hover-color') . ' !important; border-color: ' . $rtb_controller->settings->get_setting('rtb-styling-request-booking-button-background-hover-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-request-booking-button-text-color') != '' ) { $styling .=  '.rtb-booking-form form button { color: ' . $rtb_controller->settings->get_setting('rtb-styling-request-booking-button-text-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-request-booking-button-text-hover-color') != '' ) { $styling .=  '.rtb-booking-form form button:hover { color: ' . $rtb_controller->settings->get_setting('rtb-styling-request-booking-button-text-hover-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-cancel-button-background-color') != '' ) { $styling .=  '.rtb-cancellation-toggle { background-color: ' . $rtb_controller->settings->get_setting('rtb-styling-cancel-button-background-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-cancel-button-background-hover-color') != '' ) { $styling .=  '.rtb-cancellation-toggle:hover { background-color: ' . $rtb_controller->settings->get_setting('rtb-styling-cancel-button-background-hover-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-cancel-button-text-color') != '' ) { $styling .=  '.rtb-cancellation-toggle { color: ' . $rtb_controller->settings->get_setting('rtb-styling-cancel-button-text-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-cancel-button-text-hover-color') != '' ) { $styling .=  '.rtb-cancellation-toggle:hover { color: ' . $rtb_controller->settings->get_setting('rtb-styling-cancel-button-text-hover-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-find-reservations-button-background-color') != '' ) { $styling .=  '.rtb-cancel-button { background-color: ' . $rtb_controller->settings->get_setting('rtb-styling-find-reservations-button-background-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-find-reservations-button-background-hover-color') != '' ) { $styling .=  '.rtb-cancel-button:hover { background-color: ' . $rtb_controller->settings->get_setting('rtb-styling-find-reservations-button-background-hover-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-find-reservations-button-text-color') != '' ) { $styling .=  '.rtb-cancel-button { color: ' . $rtb_controller->settings->get_setting('rtb-styling-find-reservations-button-text-color') . ' !important; }'; }
			if ( $rtb_controller->settings->get_setting('rtb-styling-find-reservations-button-text-hover-color') != '' ) { $styling .=  '.rtb-cancel-button:hover { color: ' . $rtb_controller->settings->get_setting('rtb-styling-find-reservations-button-text-hover-color') . ' !important; }'; }
		$styling .=   '</style>';
		return $styling;
	}
}

if ( !function_exists('rtb_esc_js') ) {
	function rtb_esc_js( $value ) {

		return preg_replace( '/[^a-zA-Z ,.-:\/]/', '', $value ); 
	}
}
