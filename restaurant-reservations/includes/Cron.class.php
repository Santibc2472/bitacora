<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbCron' ) ) {
/**
 * This class handles scheduling of cron jobs for different notifications
 * such as reservation reminders or when customers are late for their reservations
 *
 * @since 2.0.0
 */
class rtbCron {

	/**
	 * Adds the necessary filter and action calls
	 * @since 2.0.0
	 */
	public function __construct() {
		add_filter( 'cron_schedules', array($this, 'add_cron_interval') );

		add_action( 'rtb_cron_jobs', array($this, 'handle_late_arrivals_task') );
		add_action( 'rtb_cron_jobs', array($this, 'handle_reminder_task') );

		// add_action('admin_init', array($this, 'handle_reminder_task') ); // Used for testing
	}

	/**
	 * Adds in 2, 5, 15, and 30 minute cron intervals
	 *
	 * @var array $schedules
	 * @since 2.0.0
	 */
	public function add_cron_interval( $schedules ) {
		$schedules['ten_minutes'] = array(
			'interval' => 600,
			'display' => esc_html__( 'Every Ten Minutes' )
		);

		return $schedules;
	}

	/**
	 * Creates a scheduled action called by wp_cron every 10 minutes 
	 * The class hooks into those calls for reminders and late arrivals
	 *
	 * @since 2.0.0
	 */
	public function schedule_events() {
		if (! wp_next_scheduled ( 'rtb_cron_jobs' )) {
			wp_schedule_event( time(), 'ten_minutes', 'rtb_cron_jobs' );
		}
	}

	/**
	 * Clears the rtb_cron_job hook so that it's no longer called after the plugin is deactivated
	 *
	 * @since 2.0.0
	 */
	public function unschedule_events() {
		wp_clear_scheduled_hook( 'rtb_cron_jobs' );
	}

	/**
	 * Handles the late arrival event when called by wp_scheduler
	 *
	 * @since 2.0.0
	 */
	public function handle_late_arrivals_task() {
		global $rtb_controller;

		if ( ! $rtb_controller->settings->get_setting( 'time-reminder-user' ) ) { return; }

		require_once( RTB_PLUGIN_DIR . '/includes/Notification.class.php' );
		require_once( RTB_PLUGIN_DIR . '/includes/Notification.Email.class.php' );
		require_once( RTB_PLUGIN_DIR . '/includes/Notification.SMS.class.php' );

		$bookings = $this->get_late_arrival_posts();

		foreach ($bookings as $booking) {
			
			if ( ! $booking->late_arrival_sent ) {
				if ( $rtb_controller->settings->get_setting( 'late-notification-format' ) == 'text' ) {
					$notification = new rtbNotificationSMS( 'late_user', 'user' ); 
				}
				else {
					$notification = new rtbNotificationEmail( 'late_user', 'user' ); 
				}

				$notification->set_booking($booking);

				$notification->prepare_notification();

				do_action( 'rtb_send_notification_before', $notification );
  				$sent = $notification->send_notification(); 
  				do_action( 'rtb_send_notification_after', $notification );

  				if ( $sent ) {
  					$booking->late_arrival_sent = true;
  					$booking->insert_post_meta();
  				}
			}
		}

		wp_reset_postdata();
	}

	/**
	 * Handles the notification reminders event when called by wp_scheduler
	 *
	 * @since 2.0.0
	 */
	public function handle_reminder_task() {
		global $rtb_controller;

		if ( ! $rtb_controller->settings->get_setting( 'time-reminder-user' ) ) { return; }

		require_once( RTB_PLUGIN_DIR . '/includes/Notification.class.php' );
		require_once( RTB_PLUGIN_DIR . '/includes/Notification.Email.class.php' );
		require_once( RTB_PLUGIN_DIR . '/includes/Notification.SMS.class.php' );

		$bookings = $this->get_reminder_posts();
 		
		foreach ($bookings as $booking) {
			
			if ( ! $booking->reminder_sent ) {
				if ( $rtb_controller->settings->get_setting( 'reminder-notification-format' ) == 'text' ) {
					$notification = new rtbNotificationSMS( 'reminder', 'user' ); 
				}
				else {
					$notification = new rtbNotificationEmail( 'reminder', 'user' ); 
				}
				
				$notification->set_booking($booking);

				$notification->prepare_notification();

				do_action( 'rtb_send_notification_before', $notification );
  				$sent = $notification->send_notification();
  				do_action( 'rtb_send_notification_after', $notification );

  				if ( $sent ) {
  					$booking->reminder_sent = true;
  					$booking->insert_post_meta();
  				}
			}
		}

		wp_reset_postdata();
	}

	/**
	 * Gets the bookings that might need reminders sent to them
	 *
	 * @since 2.0.0
	 */
	public function get_late_arrival_posts() {
		global $rtb_controller;

		$late_arrival_time = $rtb_controller->settings->get_setting( 'time-late-user' );
		$count = substr( $late_arrival_time, 0, strpos( $late_arrival_time, "_" ) );
		$unit = substr( $late_arrival_time, strpos( $late_arrival_time, "_" ) + 1 );

		$time_interval = $this->get_time_interval( $count, $unit );

		$after_datetime = new DateTime( '@' . ( time() - ( $time_interval + 3600 ) ) );
		$before_datetime = new DateTime( '@' . ( time() - $time_interval ) );


		$args = array(
			'post_status' => 'confirmed,',
			'posts_per_page' => -1,
			'date_query' => array(
				'before' => $before_datetime->format( 'c' ),
				'after' => $after_datetime->format( 'c' ),
				'column' => 'post_date_gmt'
			)
		);
		require_once( RTB_PLUGIN_DIR . '/includes/Query.class.php' );
		$query = new rtbQuery( $args );

		$query->prepare_args();

		return $query->get_bookings();
	}

	/**
	 * Gets the bookings that might need reminders sent to them
	 *
	 * @since 2.0.0
	 */
	public function get_reminder_posts() {
		global $rtb_controller;

		$reminder_time = $rtb_controller->settings->get_setting( 'time-reminder-user' );
		$count = substr( $reminder_time, 0, strpos( $reminder_time, "_" ) );
		$unit = substr( $reminder_time, strpos( $reminder_time, "_" ) + 1 );

		$time_interval = $this->get_time_interval( $count, $unit );

		$after_datetime = new DateTime( '@' . ( time() - max( $time_interval, 6*3600 ) ) );
		$before_datetime = new DateTime( '@' . ( time() + $time_interval ) );

		$args = array(
			'post_status' => 'confirmed,',
			'post_count' => -1,
			'date_query' => array(
				'before' => $before_datetime->format( 'c' ),
				'after' => $after_datetime->format( 'c' ),
				'column' => 'post_date_gmt'
			)
		);

		require_once( RTB_PLUGIN_DIR . '/includes/Query.class.php' );
		$query = new rtbQuery( $args );

		$query->prepare_args();
		
		return $query->get_bookings();
	}

	/**
	 * Converts a time unit and interval into its value in seconds
	 *
	 * @since 2.0.0
	 */
	public function get_time_interval( $count, $unit ) {
		switch ($unit) {
			case 'days':
				$multiplier = 24*3600;
				break;
			case 'hours':
				$multiplier = 3600;
				break;
			case 'minutes':
				$multiplier = 60;
				break;
			
			default:
				$multiplier = 1;
				break;
		}

		return $count * $multiplier;
	}

}
} // endif;
