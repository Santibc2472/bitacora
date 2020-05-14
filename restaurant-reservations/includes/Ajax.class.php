<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbAJAX' ) ) {
/**
 * Class to handle AJAX date interactions for Restaurant Reservations
 *
 * @since 2.0.0
 */
class rtbAJAX {

	/**
	 * The year of the booking date we're getting timeslots for
	 * @since 2.0.0
	 */
	public $year;

	/**
	 * The month of the booking date we're getting timeslots for
	 * @since 2.0.0
	 */
	public $month;

	/**
	 * The day of the booking date we're getting timeslots for
	 * @since 2.0.0
	 */
	public $day;

	public function __construct() {

		add_action( 'wp_ajax_rtb_get_available_time_slots', array( $this, 'get_time_slots' ) );
		add_action( 'wp_ajax_nopriv_rtb_get_available_time_slots', array( $this, 'get_time_slots' ) );

		add_action( 'wp_ajax_rtb_find_reservations', array( $this, 'get_reservations' ) );
		add_action( 'wp_ajax_nopriv_rtb_find_reservations', array( $this, 'get_reservations' ) );

		add_action( 'wp_ajax_rtb_cancel_reservations', array( $this, 'cancel_reservation' ) );
		add_action( 'wp_ajax_nopriv_rtb_cancel_reservations', array( $this, 'cancel_reservation' ) );
	}

	/**
	 * Get reservations that are associated with the email address that was sent
	 * @since 2.1.0
	 */
	public function get_reservations() {
		global $wpdb;

		$email = isset($_POST['booking_email']) ? sanitize_email( $_POST['booking_email'] ) : '';

		if ( ! $email ) {
			wp_send_json_error(
				array(
					'error' => 'noemail',
					'msg' => __( 'The email you entered is not valid.', 'restaurant-reservations' ),
				)
			);
		}

		require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );

		$bookings = array();
		$booking_ids = $wpdb->get_results($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='rtb' AND meta_value LIKE %s", '%' . $email . '%'));
		foreach ( $booking_ids as $booking_id ) {
			$booking = new rtbBooking();
			if ( $booking->load_post( $booking_id->post_id ) ) {
				if ( ( $booking->post_status == 'pending' or $booking->post_status == 'confirmed' ) and time() < strtotime( $booking->date ) ) {
					$bookings[] = array(
						'ID' 		=> $booking->ID,
						'email' 	=> $booking->email,
						'datetime' 	=> $booking->format_date( $booking->date ),
						'party'		=> $booking->party
					);
				}
			}
		}

		if ( ! empty($bookings) ) {
			wp_send_json_success(
				array(
					'bookings' => $bookings
				)
			);
		}
		else {
			wp_send_json_error(
				array(
					'error' => 'nobookings',
					'msg' => __( 'No bookings were found for the email address you entered.', 'restaurant-reservations' ),
				)
			);
		}

		die();
	}

	/**
	 * Cancel a reservation based on its ID, with the email address used for confirmation
	 * @since 2.1.0
	 */
	public function cancel_reservation( $non_ajax = true ) {
		global $rtb_controller;

		$booking_id = isset($_REQUEST['booking_id']) ? absint( $_REQUEST['booking_id'] ) : '';
		$booking_email = isset($_REQUEST['booking_email']) ? sanitize_email( $_REQUEST['booking_email'] ) : '';

		require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );

		$success = false;

		$booking = new rtbBooking();
		if ( $booking->load_post( $booking_id ) ) {
			if ( $booking_email == $booking->email ) {
				wp_update_post( array( 'ID' => $booking->ID, 'post_status' => 'cancelled' ) );

				$success = true;
			}
			else {
				wp_send_json_error(
					array(
						'error' => 'invalidemail',
						'msg' => __( 'No booking matches the information that was sent.', 'restaurant-reservations' ),
					)
				);
			}
		}
		else {
			wp_send_json_error(
				array(
					'error' => 'invalidid',
					'msg' => __( 'No booking matches the information that was sent.', 'restaurant-reservations' ),
				)
			);
		}

		if ( $ajax ) { 
			if ( $success ) {
				wp_send_json_success(
					array(
						'booking_id' => $booking_id
					)
				);
			}

			die(); 
		}
		elseif ( $success ) {
			$booking_page_id = $rtb_controller->settings->get_setting( 'booking-page' );
			$booking_page_url = get_permalink( $booking_page_id );

			$cancelled_url = add_query_arg(
				array(
					'bookingCancelled' => 'success'
				),
				$booking_page_url
			);

			header( 'location:' . $cancelled_url );
		}
	}

	/**
	 * Get available timeslots when "Max Reservations" is enabled
	 * @since 2.0.0
	 */
	public function get_time_slots() {
		global $rtb_controller;

		$max_reservations_setting = $rtb_controller->settings->get_setting( 'rtb-max-tables-count' );
		$max_reservations = substr( $max_reservations_setting, 0, strpos( $max_reservations_setting, '_' ) );
		
		$this->year = sanitize_text_field( $_POST['year'] );
		$this->month = sanitize_text_field( $_POST['month'] );
		$this->day = sanitize_text_field( $_POST['day'] );
		
		$dining_block_setting = $rtb_controller->settings->get_setting( 'rtb-dining-block-length' );
		$dining_block = substr( $dining_block_setting, 0, strpos( $dining_block_setting, '_' ) );
		$dining_block_seconds = ( $dining_block * 60 - 1 ); // Take 1 second off, to avoid bookings that start or end exactly at the beginning of a booking block
		
		// Get opening/closing times for this particular day
		$hours = $this->get_opening_hours();
		
		// If the restaurant is closed that day, return false
		if ( ! $hours ) { echo $hours; die(); }
		
		$args = array(
			'posts_per_page' => -1,
			'date_range' => 'dates',
			'start_date' => $this->year . '-' . $this->month . '-' . $this->day,
			'end_date' => $this->year . '-' . $this->month . '-' . $this->day
		);
		
		require_once( RTB_PLUGIN_DIR . '/includes/Query.class.php' );
		$query = new rtbQuery( $args );
		$query->prepare_args();
			
		// Get all current booking times in seconds from UNIX
		$times = array();
		foreach ( $query->get_bookings() as $booking ) {
			$times[] = strtotime( $booking->date );
		}
		
		sort( $times );
		
		// Go through all current booking times and figure out when we're at or above the max
		$blocked = false;
		$blocked_times = array();
		$current_times = array(); 
		if ($max_reservations != 'undefined' and $max_reservations != 0) {
			foreach ( $times as $key => $time ) {
				$current_times[] = $time;
			
				while ( sizeOf( $current_times ) > 0 and  reset( $current_times ) < $time - $dining_block_seconds ) { 
					//save the time to know when the blocking potentially ends
					$removed_time = reset( $current_times );

					// remove the expired time
					array_shift( $current_times ); 

					// remove the block if we've dropped below the max reservation count
					if ( $blocked and sizeOf( $current_times ) < $max_reservations ) {
						$blocked = false;
						$blocked_times[] = $removed_time + $dining_block_seconds;
					}
				}
			
				// Check if we're at or above the maximum number of reservations
				if ( ! $blocked and sizeOf( $current_times ) >= $max_reservations ) {
					$blocked = true;
					$blocked_times[] = $time - $dining_block_seconds;
				} 
			}
		}
		
		if ( $blocked ) { $blocked_times[] = end( $current_times ) + $dining_block_seconds; }
		
		$combined_times = array_merge( $blocked_times, $hours );
		sort( $combined_times );
		
		//Go through all of times to determine when the restaurant is open and not blocked
		$open = false;
		$blocked = false;
		$valid_times = array(); 
		foreach ( $combined_times as $time ) {
			if ( in_array( $time, $blocked_times ) ) {
				if ( ! $blocked ) {
					$blocked = true;
					if ( $open ) { 
						$valid_times[] = (object) array( 'from' => $this->format_pickadate_time( $open_time ), 'to' => $this->format_pickadate_time( $time ), 'inverted' => true );
					}
				}
				else {
					$blocked = false;
					if ( $open ) { $open_time = $time; }
				}
			}
			else {
				if ( ! $open ) {
					$open = true;
					if ( ! $blocked ) { $open_time = $time; }
				}
				else {
					$open = false;
					if ( ! $blocked ) { $valid_times[] = (object) array( 'from' => $this->format_pickadate_time( $open_time ), 'to' => $this->format_pickadate_time( $time ), 'inverted' => true ); }
				}
			}
		}
		
		echo json_encode( $valid_times );
		
		die();
	}

	public function get_opening_hours() {
		global $rtb_controller;

		$schedule_closed = $rtb_controller->settings->get_setting( 'schedule-closed' );

		$valid_times = array();

		// Check if this date is an exception to the rules
		if ( $schedule_closed !== 'undefined' ) {

			foreach ( $schedule_closed as $closing ) {
				$time = strtotime( $closing['date'] );

				if ( date( 'Y', $time ) == $this->year &&
						date( 'm', $time ) == $this->month &&
						date( 'd', $time ) == $this->day
						) {

					// Closed all day
					if ( $closing['time'] == 'undefined' ) {
						return false;
					}

					if ( $closing['time']['start'] !== 'undefined' ) {
						$open_time = strtotime( $closing['date'] . ' ' . $closing['time']['start'] );
					} else {
						$open_time = strtotime( $closing['date'] ); // Start of the day
					}

					if ( $closing['time']['end'] !== 'undefined' ) {
						$close_time = strtotime( $closing['date'] . ' ' . $closing['time']['end'] );
					} else {
						$close_time = strtotime( $closing['date'] . ' 23:59:59' ); // End of the day
					}

					$open_time = $this->get_earliest_time( $open_time );

					if ( $open_time < $close_time ) {
						$valid_times[] = $open_time;
						$valid_times[] = $close_time;
					}
					else {
						return false;
					}
				}
			}

			// Exit early if this date is an exception
			if ( isset( $open_time ) ) {
				return $valid_times;
			}
		}

		$schedule_open = $rtb_controller->settings->get_setting( 'schedule-open' );

		// Get any rules which apply to this weekday
		if ( $schedule_open != 'undefined' ) {

			$day_of_week =  strtolower( date( 'l', strtotime( $this->year . '-' . $this->month . '-' . $this->day . ' 1:00:00' ) ) );

			foreach ( $schedule_open as $opening ) {

				if ( $opening['weekdays'] !== 'undefined' ) {
					foreach ( $opening['weekdays'] as $weekday => $value ) {
						if ( $weekday == $day_of_week ) {

							// Closed all day
							if ( $opening->time == 'undefined' ) {
								return false;
							}

							if ( $opening['time']['start'] !== 'undefined' ) {
								$open_time = strtotime( $this->year . '-' . $this->month . '-' . $this->day . ' ' . $opening['time']['start'] );
							} else {
								$open_time = strtotime( $this->year . '-' . $this->month . '-' . $this->day );
							}

							if ( $opening['time']['end'] !== 'undefined' ) {
								$close_time = strtotime( $this->year . '-' . $this->month . '-' . $this->day . ' ' . $opening['time']['end'] );
							} else {
								$close_time = strtotime( $this->year . '-' . $this->month . '-' . $this->day . ' 23:59:59' ); // End of the day
							}

							$open_time = $this->get_earliest_time( $open_time );

							if ( $open_time < $close_time ) {
								$valid_times[] = $open_time;
								$valid_times[] = $close_time;
							}
							else {
								return false;
							}
						}
					}
				}
			}

			// Pass any valid times located
			if ( sizeOf( $valid_times ) >= 1 ) {
				return $valid_times;
			}
		}

		return false;
	}

	public function get_earliest_time( $open_time ) {
		global $rtb_controller;

		// Only make adjustments for current day selections
		if ( date( 'y-m-d', strtotime( $this->year . '-' . $this->month . '-' . $this->day ) ) !== date( 'y-m-d' ) ) {
			return $open_time;
		}

		$late_bookings = ( is_admin() && current_user_can( 'manage_bookings' ) ) ? '' : $rtb_controller->settings->get_setting( 'late-bookings' );

		$open_time = time() > $open_time ? time() : $open_time;

		if ( $late_bookings === 'number' && $late_bookings % 1 === 0 ) {
			if ( time() + $late_bookings * 60 > $open_time ) {
				$open_time = time() + $late_bookings;
			}
		}

		return $open_time;
	}

	public function format_pickadate_time( $time ) {
		return array( date( 'G', $time ), date( 'i', $time ) );
	}
}

}