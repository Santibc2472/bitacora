<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbNotifications' ) ) {
/**
 * Class to process notifications for Restaurant Reservations
 *
 * This class contains the registered notifications and sends them when the
 * event is triggered.
 *
 * @since 0.0.1
 */
class rtbNotifications {

	/**
	 * Booking object (class rtbBooking)
	 *
	 * @var object
	 * @since 0.0.1
	 */
	public $booking;

	/**
	 * Array of rtbNotification objects
	 *
	 * @var array
	 * @since 0.0.1
	 */
	public $notifications;

	/**
	 * Register notifications hook early so that other early hooks can
	 * be used by the notification system.
	 * @since 0.0.1
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_notifications' ) );
	}

	/**
	 * Register notifications
	 * @since 0.0.1
	 */
	public function register_notifications() {

		// Hook into all events that require notifications
		$hooks = array(
			'rtb_insert_booking'		=> array( $this, 'new_submission' ), 					// Booking submitted
			'rtb_confirmed_booking'		=> array( $this, 'new_confirmed_submission' ), 			// Booking confirmed
			'pending_to_confirmed'		=> array( $this, 'pending_to_confirmed' ), 				// Booking confirmed
			'pending_to_closed'			=> array( $this, 'pending_to_closed' ), 				// Booking can not be made
			'pending_to_cancelled'		=> array( $this, 'booking_cancelled' ), 				// Booking cancelled
			'confirmed_to_cancelled'	=> array( $this, 'booking_cancelled' ), 				// Booking cancelled
		);

		$hooks = apply_filters( 'rtb_notification_transition_callbacks', $hooks );

		foreach ( $hooks as $hook => $callback ) {
			add_action( $hook, $callback );
		}

		// Register notifications
		require_once( RTB_PLUGIN_DIR . '/includes/Notification.class.php' );
		require_once( RTB_PLUGIN_DIR . '/includes/Notification.Email.class.php' );

		$this->notifications = array(
			new rtbNotificationEmail( 'new_submission', 'user' ),
			new rtbNotificationEmail( 'pending_to_confirmed', 'user' ),
			new rtbNotificationEmail( 'pending_to_closed', 'user' ),
			new rtbNotificationEmail( 'booking_cancelled', 'user' ),
		);

		global $rtb_controller;
		if ( $rtb_controller->settings->get_setting( 'admin-email-option' ) ) {
			$this->notifications[] = new rtbNotificationEmail( 'new_submission', 'admin' );
		}

		if ( $rtb_controller->settings->get_setting( 'admin-confirmed-email-option' ) ) {
			$this->notifications[] = new rtbNotificationEmail( 'rtb_confirmed_booking', 'admin' );
		}

		if ( $rtb_controller->settings->get_setting( 'admin-cancelled-email-option' ) ) {
			$this->notifications[] = new rtbNotificationEmail( 'booking_cancelled', 'admin' );
		}

		$this->notifications = apply_filters( 'rtb_notifications', $this->notifications );
	}

	/**
	 * Set booking data
	 * @since 0.0.1
	 */
	public function set_booking( $booking_post ) {
		require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );
		$this->booking = new rtbBooking();
		$this->booking->load_wp_post( $booking_post );
	}

	/**
	 * New booking submissions
	 *
	 * @var object $booking
	 * @since 0.0.1
	 */
	public function new_submission( $booking ) {

		// Bail early if $booking is not a rtbBooking object
		if ( get_class( $booking ) != 'rtbBooking' ) {
			return;
		}

		// trigger an event so that admin notifications for a new confirmed booking can be sent
		if ( $booking->post_status == 'confirmed' ) { 
			do_action( 'rtb_confirmed_booking', get_post( $booking->ID ) );
		}

		// If the post status is not pending, trigger a post status
		// transition as though it's gone from pending_to_{status}
		if ( $booking->post_status != 'pending' ) {
			do_action( 'pending_to_' . $booking->post_status, get_post( $booking->ID ) );

		// Otherwise proceed with the new_submission event
		} else {
			$this->booking = $booking;
			$this->event( 'new_submission' );
		}
	}

	/**
	 * New confirmed booking
	 * @since 2.1.0
	 */
	public function new_confirmed_submission( $booking_post ) {

		if ( $booking_post->post_type != RTB_BOOKING_POST_TYPE ) {
			return;
		}

		$this->set_booking( $booking_post );

		$this->event( 'rtb_confirmed_booking' );

	}

	/**
	 * Booking confirmed
	 * @since 0.0.1
	 */
	public function pending_to_confirmed( $booking_post ) {

		if ( $booking_post->post_type != RTB_BOOKING_POST_TYPE ) {
			return;
		}

		$this->set_booking( $booking_post );

		$this->event( 'pending_to_confirmed' );

	}

	/**
	 * Booking can not be made
	 * @since 0.0.1
	 */
	public function pending_to_closed( $booking_post ) {

		if ( $booking_post->post_type != RTB_BOOKING_POST_TYPE ) {
			return;
		}

		$this->set_booking( $booking_post );

		$this->event( 'pending_to_closed' );

	}

	/**
	 * Booking has been cancelled by the guest
	 */
	public function booking_cancelled( $booking_post ) {

		if ( $booking_post->post_type != RTB_BOOKING_POST_TYPE ) {
			return;
		}

		$this->set_booking( $booking_post );

		$this->event( 'booking_cancelled' );

	}

	/**
	 * Booking was confirmed and is now completed. Send out an optional
	 * follow-up email.
	 *
	 * @since 0.0.1
	 */
	public function confirmed_to_closed( $booking_post ) {

		if ( $booking_post->post_type != RTB_BOOKING_POST_TYPE ) {
			return;
		}

		$this->set_booking( $booking_post );

		$this->event( 'confirmed_to_closed' );

	}

	/**
	 * Process notifications for an event
	 * @since 0.0.1
	 */
	public function event( $event ) {

		foreach( $this->notifications as $notification ) {

			if ( $event == $notification->event ) {
				$notification->set_booking( $this->booking );
				if ( $notification->prepare_notification() ) {
					do_action( 'rtb_send_notification_before', $notification );
					$notification->send_notification();
					do_action( 'rtb_send_notification_after', $notification );
				}
			}
		}

	}

}
} // endif;
