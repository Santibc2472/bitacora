<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbAdminBookings' ) ) {
/**
 * Class to handle the admin bookings page for Restaurant Reservations
 *
 * @since 1.3
 */
class rtbAdminBookings {

	/**
	 * The bookings table
	 *
	 * This is only instantiated on the bookings admin page at the moment when
	 * it is generated.
	 *
	 * @see self::show_admin_bookings_page()
	 * @see WP_List_table.BookingsTable.class.php
	 * @since 1.6
	 */
	public $bookings_table;

	public function __construct() {

		// Add the admin menu
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );

		// Print the modals
		add_action( 'admin_footer-toplevel_page_rtb-bookings', array( $this, 'print_modals' ) );

		// Receive Ajax requests
		add_action( 'wp_ajax_nopriv_rtb-admin-booking-modal' , array( $this , 'nopriv_ajax' ) );
		add_action( 'wp_ajax_rtb-admin-booking-modal', array( $this, 'booking_modal_ajax' ) );
		add_action( 'wp_ajax_nopriv_rtb-admin-trash-booking' , array( $this , 'nopriv_ajax' ) );
		add_action( 'wp_ajax_rtb-admin-trash-booking', array( $this, 'trash_booking_ajax' ) );
		add_action( 'wp_ajax_nopriv_rtb-admin-email-modal' , array( $this , 'nopriv_ajax' ) );
		add_action( 'wp_ajax_rtb-admin-email-modal', array( $this, 'email_modal_ajax' ) );
		add_action( 'wp_ajax_nopriv_rtb-admin-column-modal' , array( $this , 'nopriv_ajax' ) );
		add_action( 'wp_ajax_rtb-admin-column-modal', array( $this, 'column_modal_ajax' ) );
		add_action( 'wp_ajax_nopriv_rtb-admin-ban-modal' , array( $this , 'nopriv_ajax' ) );
		add_action( 'wp_ajax_rtb-admin-ban-modal', array( $this, 'ban_modal_ajax' ) );
		add_action( 'wp_ajax_nopriv_rtb-admin-delete-modal' , array( $this , 'nopriv_ajax' ) );
		add_action( 'wp_ajax_rtb-admin-delete-modal', array( $this, 'delete_modal_ajax' ) );

		add_action( 'wp_ajax_nopriv_rtb_set_reservation_arrived' , array( $this , 'nopriv_ajax' ) );
		add_action( 'wp_ajax_rtb_set_reservation_arrived', array( $this, 'set_booking_arrived' ) );

		// Validate post status and notification fields
		add_action( 'rtb_validate_booking_submission', array( $this, 'validate_admin_fields' ) );

		// Set post status when adding to the database
		add_filter( 'rtb_insert_booking_data', array( $this, 'insert_booking_data' ), 10, 2 );

		// Add the columns configuration button to the table
		add_action( 'rtb_bookings_table_actions', array( $this, 'print_columns_config_button' ), 9 );

	}

	/**
	 * Add the top-level admin menu page
	 * @since 0.0.1
	 */
	public function add_menu_page() {

		add_menu_page(
			_x( 'Bookings', 'Title of admin page that lists bookings', 'restaurant-reservations' ),
			_x( 'Bookings', 'Title of bookings admin menu item', 'restaurant-reservations' ),
			'manage_bookings',
			'rtb-bookings',
			array( $this, 'show_admin_bookings_page' ),
			'dashicons-calendar',
			'26.2987'
		);

	}

	/**
	 * Display the admin bookings page
	 * @since 0.0.1
	 */
	public function show_admin_bookings_page() {

		require_once( RTB_PLUGIN_DIR . '/includes/WP_List_Table.BookingsTable.class.php' );
		$this->bookings_table = new rtbBookingsTable();
		$this->bookings_table->prepare_items();
		?>

		<div class="wrap">
			<h1>
				<?php _e( 'Restaurant Bookings', 'restaurant-reservations' ); ?>
				<a href="#" class="add-new-h2 page-title-action add-booking"><?php _e( 'Add New', 'restaurant-reservations' ); ?></a>
			</h1>

			<?php do_action( 'rtb_bookings_table_top' ); ?>
			<form id="rtb-bookings-table" method="POST" action="">
				<input type="hidden" name="post_type" value="<?php echo RTB_BOOKING_POST_TYPE; ?>" />
				<input type="hidden" name="page" value="rtb-bookings">

				<div class="rtb-primary-controls clearfix">
					<div class="rtb-views">
						<?php $this->bookings_table->views(); ?>
					</div>
					<?php $this->bookings_table->advanced_filters(); ?>
				</div>

				<?php $this->bookings_table->display(); ?>
			</form>
			<?php do_action( 'rtb_bookings_table_btm' ); ?>
		</div>

		<?php
	}

	/**
	 * Print button for configuring columns
	 *
	 * @param string pos Position of this tablenav: top|btm
	 * @since 0.1
	 */
	public function print_columns_config_button( $pos ) {
		if ( $pos != 'top' ) {
			return;
		}
		?>

		<div class="alignleft actions rtb-actions">
			<a href="#" class="button rtb-columns-button">
				<span class="dashicons dashicons-admin-settings"></span>
				<?php esc_html_e( 'Columns', 'restaurant-reservations' ); ?>
			</a>
		</div>

		<?php
	}

	/**
	 * Print the modal containers
	 *
	 * New/edit bookings, send email, configure columns, errors.
	 *
	 * @since 0.0.1
	 */
	public function print_modals() {

		global $rtb_controller;
		?>

		<!-- Restaurant Reservations add/edit booking modal -->
		<div id="rtb-booking-modal" class="rtb-admin-modal">
			<div class="rtb-booking-form rtb-container">
				<form method="POST">
					<input type="hidden" name="action" value="admin_booking_request">
					<input type="hidden" name="ID" value="">

					<?php
					/**
					 * The generated fields are wrapped in a div so we can
					 * replace its contents with an HTML blob passed back from
					 * an Ajax request. This way the field data and error
					 * messages are always populated from the same server-side
					 * code.
					 */
					?>
					<div id="rtb-booking-form-fields">
						<?php echo $this->print_booking_form_fields(); ?>
					</div>

					<button type="submit" class="button button-primary">
						<?php _e( 'Add Booking', 'restaurant-reservations' ); ?>
					</button>
					<a href="#" class="button" id="rtb-cancel-booking-modal">
						<?php _e( 'Cancel', 'restaurant-reservations' ); ?>
					</a>
					<div class="action-status">
						<span class="spinner loading"></span>
						<span class="dashicons dashicons-no-alt error"></span>
						<span class="dashicons dashicons-yes success"></span>
					</div>
				</form>
			</div>
		</div>

		<!-- Restaurant Reservations send email modal -->
		<div id="rtb-email-modal" class="rtb-admin-modal">
			<div class="rtb-email-form rtb-container">
				<form method="POST">
					<input type="hidden" name="action" value="admin_send_email">
					<input type="hidden" name="ID" value="">
					<input type="hidden" name="name" value="">
					<input type="hidden" name="email" value="">

					<fieldset>
						<legend><?php _e( 'Send Email', 'retaurant-reservations' ); ?></legend>

						<div class="to">
							<label for="rtb-email-to"><?php _ex( 'To', 'Label next to the email address to which an email will be sent', 'restaurant-reservations' ); ?></label>
							<span class="rtb-email-to"></span>
						</div>
						<div class="subject">
							<label for="rtb-email-subject"><?php _e( 'Subject', 'restaurant-reservations' ); ?></label>
							<input type="text" name="rtb-email-subject" placeholder="<?php echo $rtb_controller->settings->get_setting( 'subject-admin-notice'); ?>">
						</div>
						<div class="message">
							<label for="rtb-email-message"><?php _e( 'Message', 'restaurant-reservations' ); ?></label>
							<textarea name="rtb-email-message" id="rtb-email-message"></textarea>
						</div>
					</fieldset>

					<button type="submit" class="button button-primary">
						<?php _e( 'Send Email', 'restaurant-reservations' ); ?>
					</button>
					<a href="#" class="button" id="rtb-cancel-email-modal">
						<?php _e( 'Cancel', 'restaurant-reservations' ); ?>
					</a>
					<div class="action-status">
						<span class="spinner loading"></span>
						<span class="dashicons dashicons-no-alt error"></span>
						<span class="dashicons dashicons-yes success"></span>
					</div>
				</form>
			</div>
		</div>

		<!-- Restaurant Reservations column configuration modal -->
		<div id="rtb-column-modal" class="rtb-admin-modal">
			<div class="rtb-column-form rtb-container">
				<form method="POST">
					<input type="hidden" name="action" value="admin_column_config">

					<fieldset>
						<legend><?php esc_html_e( 'Columns', 'restaurant-reservations' ); ?></legend>
						<ul>
							<?php
								$columns = $this->bookings_table->get_all_columns();
								$visible = $this->bookings_table->get_columns();
								foreach( $columns as $column => $label ) :
									// Don't allow these columns to be hidden
									if ( $column == 'cb' || $column == 'details' || $column == 'date' ) {
										continue;
									}
									?>
										<li>
											<label>
												<input type="checkbox" name="rtb-columns-config" value="<?php esc_attr_e( $column ); ?>"<?php if ( array_key_exists( $column, $visible ) ) : ?> checked<?php endif; ?>>
												<?php esc_html_e( $label ); ?>
											</label>
										</li>
									<?php
								endforeach;
							?>
						</ul>
					</fieldset>

					<button type="submit" class="button button-primary">
						<?php _e( 'Update', 'restaurant-reservations' ); ?>
					</button>
					<a href="#" class="button" id="rtb-cancel-column-modal">
						<?php _e( 'Cancel', 'restaurant-reservations' ); ?>
					</a>
					<div class="action-status">
						<span class="spinner loading"></span>
						<span class="dashicons dashicons-no-alt error"></span>
						<span class="dashicons dashicons-yes success"></span>
					</div>
				</form>
			</div>
		</div>

		<!-- Restaurant Reservations details modal -->
		<div id="rtb-details-modal" class="rtb-admin-modal">
			<div class="rtb-details-form rtb-container">
				<div class="rtb-details-data"></div>
				<a href="#" class="button" id="rtb-cancel-details-modal">
					<?php _e( 'Close', 'restaurant-reservations' ); ?>
				</a>
			</div>
		</div>

		<!-- Restaurant Reservations ban email/ip modal -->
		<div id="rtb-ban-modal" class="rtb-admin-modal">
			<div class="rtb-ban-form rtb-container">
				<div class="rtb-ban-msg">
					<p class="intro">
						<?php
							printf(
								__( 'Ban future bookings from the email address %s or the IP address %s?', 'restaurant-reservations' ),
								'<span id="rtb-ban-modal-email"></span>',
								'<span id="rtb-ban-modal-ip"></span>'
							);
						?>
					</p>
					<p>
						<?php
							esc_html_e( 'It is recommended to ban by email address instead of IP. Only ban by IP address to block a malicious user who is using different email addresses to avoid a previous ban.', 'restaurant-reservations' );
						?>
					</p>
				</div>
				<button class="button button-primary" id="rtb-ban-modal-email-btn">Ban Email</button>
				<button class="button button-primary" id="rtb-ban-modal-ip-btn">Ban IP</button>
				<a href="#" id="rtb-cancel-ban-modal" class="button"><?php _e( 'Close', 'restaurant-reservations' ); ?></a>
				<a class="button-link" href="<?php echo esc_url( admin_url( '/admin.php?page=rtb-settings' ) ); ?>" target="_blank">
					<?php esc_html_e( 'View all bans', 'restaurant-reservations' ); ?>
				</a>
				<div class="action-status">
					<span class="spinner loading"></span>
					<span class="dashicons dashicons-no-alt error"></span>
					<span class="dashicons dashicons-yes success"></span>
				</div>
			</div>
		</div>

		<!-- Restaurant Reservations delete customer modal -->
		<div id="rtb-delete-modal" class="rtb-admin-modal">
			<div class="rtb-delete-form rtb-container">
				<div class="rtb-delete-msg">
					<?php
						printf(
							__( 'Delete all booking records related to email address %s? This action can not be undone.', 'restaurant-reservations' ),
							'<span id="rtb-delete-modal-email"></span>'
						);
					?>
				</div>
				<div id="rtb-delete-status">
					<span class="rtb-delete-status-total">
						<span id="rtb-delete-status-progress" class="rtb-delete-status-progress"></span>
					</span>
					<div id="rtb-delete-status-deleted"></div>
				</div>
				<button class="button button-primary" id="rtb-delete-modal-btn">Delete Bookings</button>
				<button id="rtb-cancel-delete-modal" class="button"><?php _e( 'Close', 'restaurant-reservations' ); ?></button>
				<div class="action-status">
					<span class="spinner loading"></span>
					<span class="dashicons dashicons-no-alt error"></span>
					<span class="dashicons dashicons-yes success"></span>
				</div>
			</div>
		</div>

		<!-- Restaurant Reservations error message modal -->
		<div id="rtb-error-modal" class="rtb-admin-modal">
			<div class="rtb-error rtb-container">
				<div class="rtb-error-msg"></div>
				<a href="#" class="button"><?php _e( 'Close', 'restaurant-reservations' ); ?></a>
			</div>
		</div>

		<?php
	}

	/**
	 * Retrieve booking form fields used in the admin booking modal. These
	 * fields are also passed back with ajax requests since they render error
	 * messages and populate fields with validated data.
	 * @since 0.0.1
	 */
	public function print_booking_form_fields() {

		global $rtb_controller;

		// Add post status and notification fields to admin booking form
		add_filter( 'rtb_booking_form_fields', array( $this, 'add_admin_fields' ), 20, 2 );

		// Retrieve the form fields
		$fields = $rtb_controller->settings->get_booking_form_fields( $rtb_controller->request );

		ob_start();
		?>

			<?php foreach( $fields as $fieldset => $contents ) : ?>
			<fieldset class="<?php echo $fieldset; ?>">
				<?php
					foreach( $contents['fields'] as $slug => $field ) {

						$args = empty( $field['callback_args'] ) ? null : $field['callback_args'];

						call_user_func( $field['callback'], $slug, $field['title'], $field['request_input'], $args );
					}
				?>
			</fieldset>
			<?php endforeach;

		// Remove the admin fields filter
		remove_filter( 'rtb_booking_form_fields', array( $this, 'add_admin_fields' ) );

		return ob_get_clean();
	}

	/**
	 * Add the post status and notifications fields to the booking form fields
	 * @since 1.3
	 */
	public function add_admin_fields( $fields, $request ) {

		if ( !is_admin() || !current_user_can( 'manage_bookings' ) ) {
			return $fields;
		}

		global $rtb_controller;

		// Get all valid booking statuses
		$booking_statuses = array();
		foreach( $rtb_controller->cpts->booking_statuses as $status => $args ) {
			$booking_statuses[ $status ] = $args['label'];
		}

		$fields['admin'] = array(
			'fields'	=> array(
				'post-status'	=> array(
					'title'			=> __( 'Booking Status', 'restaurant-reservations' ),
					'request_input'	=> empty( $request->post_status ) ? '' : $request->post_status,
					'callback'		=> 'rtb_print_form_select_field',
					'callback_args'	=> array(
						'options'		=> $booking_statuses,
					)
				),
				'notifications'	=> array(
					'title'			=> __( 'Send notifications', 'restaurant-reservations' ),
					'request_input'	=> empty( $request->send_notifications ) ? false : $request->send_notifications,
					'callback'		=> array( $this, 'print_form_send_notifications_field' ),
					'callback_args'	=> array(
						'description'	=> array(
							'prompt'		=> __( 'Learn more', 'restaurant-reservations' ),
							'text'			=> __( "When adding a booking or changing a booking's status with this form, no email notifications will be sent. Check this option if you want to send email notifications.", 'restaurant-reservations' ),
						),
					),
				),
			),
		);

		return $fields;
	}


	/**
	 * Print a field to toggle notifications when adding/editing a booking from
	 * the admin
	 * @since 1.3
	 */
	function print_form_send_notifications_field( $slug, $title, $value, $args ) {

		$slug = esc_attr( $slug );
		$title = esc_attr( $title );
		$value = (bool) $value;
		$description = empty( $args['description'] ) || empty( $args['description']['prompt'] ) || empty( $args['description']['text'] ) ? null : $args['description'];
		?>

		<div class="<?php echo $slug; ?>">
			<?php echo rtb_print_form_error( $slug ); ?>
			<label>
				<input type="checkbox" name="rtb-<?php echo esc_attr( $slug ); ?>" value="1"<?php checked( $value ); ?>>
				<?php echo $title; ?>
				<?php if ( !empty( $description ) ) : ?>
				<a href="#" class="rtb-description-prompt">
					<?php echo $description['prompt']; ?>
				</a>
				<?php endif; ?>
			</label>
			<?php if ( !empty( $description ) ) : ?>
			<div class="rtb-description">
				<?php echo $description['text']; ?>
			</div>
			<?php endif; ?>
		</div>

		<?php
	}

	/**
	 * Handle ajax requests from the admin bookings area from logged out users
	 * @since 1.3
	 */
	public function nopriv_ajax() {

		wp_send_json_error(
			array(
				'error' => 'loggedout',
				'msg' => sprintf( __( 'You have been logged out. Please %slogin again%s.', 'restaurant-reservations' ), '<a href="' . wp_login_url( admin_url( 'admin.php?page=rtb-bookings&status=pending' ) ) . '">', '</a>' ),
			)
		);
	}

	/**
	 * Handle ajax requests from the admin bookings area
	 * @since 1.3
	 */
	public function booking_modal_ajax() {

		global $rtb_controller;

		// Authenticate request
		if ( !check_ajax_referer( 'rtb-admin', 'nonce' ) || !current_user_can( 'manage_bookings' ) ) {
			$this->nopriv_ajax();
		}

		// Retrieve a booking with a GET request
		if ( !empty( $_GET['booking'] ) && !empty( $_GET['booking']['ID'] ) ) {

			$id = (int) $_GET['booking']['ID'];

			require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );
			$rtb_controller->request = new rtbBooking();
			$result = $rtb_controller->request->load_post( $id );

			if ( $result ) {

				// Don't allow editing of trashed bookings. This wil force
				// appropriate use of the trash status and (hopefully) prevent
				// mistakes in booking management.
				if ( $rtb_controller->request->post_status == 'trash' ) {
					wp_send_json_error(
						array(
							'error'		=> 'booking_trashed',
							'msg'		=> sprintf( __( 'This booking has been sent to the %sTrash%s where it can not be edited. Set the booking to Pending or Confirmed to edit it.', 'restaurant-reservations' ), '<a href="' . admin_url( 'admin.php?page=rtb-bookings&status=trash' ) . '">', '</a>' ),
						)
					);
				}

				$rtb_controller->request->prepare_request_data();
				wp_send_json_success(
					array(
						'booking'	=> $rtb_controller->request,
						'fields'	=> $this->print_booking_form_fields(),
					)
				);

			} else {
				wp_send_json_error(
					array(
						'error'		=> 'booking_not_found',
						'msg'		=> __( 'The booking could not be retrieved. Please reload the page and try again.', 'restaurant-reservations' ),
					)
				);
			}

		// Insert or update a booking with a POST request
		} elseif ( !empty( $_POST['booking'] ) ) {

			// Set up $_POST object for validation
			foreach( $_POST['booking'] as $field ) {

				// $field is setup by jQuery's serializeArray(), which will preserve
				// array indicators in field names. So name[] is passed as "name[]"
				// instead of "name". Let's strip out any trailing brackets to match
				// the normal behaviour  when receiving $_POST data on the server.
				if ( substr( $field['name'], -2 ) === '[]' ) {
					$name = substr( $field['name'], 0, -2 );
					if ( !isset( $_POST[ $name ] ) ) {
						$_POST[ $name ] = array();
					}
					$_POST[ $name ][] = $field['value'];
				} else {
					$_POST[ $field['name'] ] = $field['value'];
				}

			}

			require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );
			$rtb_controller->request = new rtbBooking();

			// Add an ID if we're updating the post
			if ( !empty( $_POST['ID'] ) ) {
				$result = $rtb_controller->request->load_post((int) $_POST['ID']);
				if (!$result) {
					wp_send_json_error(
						array(
							'error'		=> 'no_booking_found',
							'booking'	=> $rtb_controller->request,
							'fields'	=> $this->print_booking_form_fields(),
						)
					);
				}
			}

			// Disable notifications
			$this->maybe_disable_notifications();

			$result = $rtb_controller->request->insert_booking();

			if ( $result ) {
				wp_send_json_success(
					array(
						'booking'	=> $rtb_controller->request,
					)
				);
			} else {
				wp_send_json_error(
					array(
						'error'		=> 'invalid_booking_data',
						'booking'	=> $rtb_controller->request,
						'fields'	=> $this->print_booking_form_fields(),
					)
				);
			}
		}

		// Fallback to a valid error
		wp_send_json_error();
	}

	/**
	 * Set booking status to trash
	 * @since 1.3
	 */
	public function trash_booking_ajax() {

		global $rtb_controller;

		// Authenticate request
		if ( !check_ajax_referer( 'rtb-admin', 'nonce' ) || !current_user_can( 'manage_bookings' ) || empty( $_POST['booking'] ) ) {
			$this->nopriv_ajax();
		}

		$id = (int) $_POST['booking'];

		$result = wp_trash_post( $id );

		if ( $result === false ) {
			wp_send_json_error(
				array(
					'error'		=> 'trash_failed',
					'msg'		=> __( 'Unable to trash this post. Please try again. If you continue to have trouble, please refresh the page.', 'restaurant-reservations' ),
				)
			);

		} else {
			wp_send_json_success(
				array(
					'booking'	=> $id,
				)
			);
		}
	}

	/**
	 * Handle ajax requests to send an email
	 *
	 * @since 1.3.1
	 */
	public function email_modal_ajax() {

		global $rtb_controller;

		// Authenticate request
		if ( !check_ajax_referer( 'rtb-admin', 'nonce' ) || !current_user_can( 'manage_bookings' ) ) {
			$this->nopriv_ajax();
		}

		// Set up $_POST object for validation
		foreach( $_POST['email'] as $field ) {
			$_POST[ $field['name'] ] = $field['value'];
		}

		$id = (int) $_POST['ID'];
		$name = sanitize_text_field( $_POST['name'] );
		$email = sanitize_text_field( $_POST['email'] );
		$subject = stripcslashes( sanitize_text_field( $_POST['rtb-email-subject'] ) );
		$message = stripcslashes( wp_kses_post( $_POST['rtb-email-message'] ) );

		if ( empty( $message ) ) {
			wp_send_json_error(
				array(
					'error'		=> 'email_missing_message',
					'msg'		=> __( 'Please enter a message before sending the email.', 'restaurant-reservations' ),
				)
			);
		}

		if ( empty( $id ) || empty( $name ) || empty( $email ) ) {
			wp_send_json_error(
				array(
					'error'		=> 'email_missing_data',
					'msg'		=> __( 'The email could not be sent because some critical information was missing.', 'restaurant-reservations' ),
				)
			);
		}

		require_once( RTB_PLUGIN_DIR . '/includes/Booking.class.php' );
		$booking = new rtbBooking();

		if ( !$booking->load_post( $id ) ) {
			wp_send_json_error(
				array(
					'error'		=> 'email_missing_booking',
					'msg'		=> __( 'There was an error loading the booking and the email was not sent.', 'restaurant-reservations' ),
				)
			);
		}

		$email = new rtbNotificationEmail( 'admin_email_notice', 'user' );
		$email->subject = empty( $subject ) ? $rtb_controller->settings->get_setting( 'subject-admin-notice' ) : $subject;
		$email->message = $message;
		$email->set_booking( $booking );
		if ( $email->prepare_notification() ) {
			do_action( 'rtb_send_notification_before', $email );
			$email->send_notification();
			do_action( 'rtb_send_notification_after', $email );
		}

		// Store email in postmeta for log
		$booking->add_log( 'email', $email->subject, $email->message );
		$booking->insert_post_data();

		wp_send_json_success();
	}

	/**
	 * Handle ajax requests to configure columns
	 *
	 * @since 1.3.1
	 */
	public function column_modal_ajax() {

		global $rtb_controller;

		// Authenticate request
		if ( !check_ajax_referer( 'rtb-admin', 'nonce' ) || !current_user_can( 'manage_bookings' ) ) {
			$this->nopriv_ajax();
		}

		if ( !isset( $_POST['columns'] ) || !is_array( $_POST['columns'] ) || empty( $_POST['columns'] ) ) {
			wp_send_json_error(
				array(
					'error'		=> 'no_columns',
					'msg'		=> __( 'You must select at least one column to display.', 'restaurant-reservations' ),
				)
			);
		}

		$settings = get_option( 'rtb-settings' );
		$settings['bookings-table-columns'] = array_map( 'sanitize_key', $_POST['columns'] );
		update_option( 'rtb-settings', $settings );

		wp_send_json_success();
	}

	/**
	 * Handle ajax requests to ban by IP or email address
	 *
	 * @since 1.3.1
	 */
	public function ban_modal_ajax() {

		global $rtb_controller;

		// Authenticate request
		if ( !check_ajax_referer( 'rtb-admin', 'nonce' ) || !current_user_can( 'manage_bookings' ) ) {
			$this->nopriv_ajax();
		}

		// Ban an email address
		if ( isset( $_POST['email'] ) && !empty( $_POST['email'] ) ) {
			$email = trim( sanitize_text_field( $_POST['email'] ) );
			$banned_emails = preg_split( '/\r\n|\r|\n/', (string) $rtb_controller->settings->get_setting( 'ban-emails' ) );

			if ( !in_array( $email, $banned_emails ) ) {
				$banned_emails[] = $email;
				$rtb_controller->settings->settings['ban-emails'] = join( "\n", $banned_emails );
				update_option( 'rtb-settings', $rtb_controller->settings->settings );
			}

			wp_send_json_success();

		// Ban an IP address
		} elseif ( isset( $_POST['ip'] ) && !empty( $_POST['ip'] ) ) {
			$ip = trim( sanitize_text_field( $_POST['ip'] ) );
			$banned_ips = preg_split( '/\r\n|\r|\n/', (string) $rtb_controller->settings->get_setting( 'ban-ips' ) );

			if ( !in_array( $ip, $banned_ips ) ) {
				$banned_ips[] = $ip;
				$rtb_controller->settings->settings['ban-ips'] = join( "\n", $banned_ips );
				update_option( 'rtb-settings', $rtb_controller->settings->settings );
			}

			wp_send_json_success();
		}

		wp_send_json_error(
			array(
				'error'		=> 'no_data',
				'msg'		=> __( 'No IP or email address could be found for this ban request.', 'restaurant-reservations' ),
			)
		);
	}

	/**
	 * Handle ajax requests to delete bookings by email
	 *
	 * @since 1.7.7
	 */
	public function delete_modal_ajax() {

		global $rtb_controller;

		// Authenticate request
		if ( !check_ajax_referer( 'rtb-admin', 'nonce' ) || !current_user_can( 'manage_bookings' ) ) {
			$this->nopriv_ajax();
		}

		if ( !empty( $_POST['email'] ) ) {
			$email = sanitize_email( $_POST['email'] );

			$args = array(
				'date_range' => null,
				'posts_per_page'	=> 100,
				'paged' => !empty( $_POST['page'] ) ? (int) $_POST['page'] : 1,
			);

			$query = new rtbQuery( $args, 'delete-by-email' );
			$query->prepare_args();

			$bookings = $query->get_bookings();
			$deleted = 0;
			foreach( $bookings as $booking ) {
				if ( isset( $booking->email ) && $booking->email === $email) {
					wp_delete_post( $booking->ID, true );
					$deleted++;
				}
			}

			// Get count of all bookings
			global $wpdb;
			$where = "WHERE p.post_type = '" . RTB_BOOKING_POST_TYPE . "'";
			$query = "SELECT count( * ) AS num_posts
				FROM $wpdb->posts p
				$where
			";

			$count = $wpdb->get_results( $query );
			$count = (int) $count[0]->num_posts;

			wp_send_json_success(array(
				'processed' => count($bookings),
				'deleted' => $deleted,
				'total' => $count,
			));
		}

		wp_send_json_error(
			array(
			'error'		=> 'no_data',
			'msg'		=> __( 'No email address could be found for this delete request.', 'restaurant-reservations' ),
			)
		);
	}

	/**
	 * Register a party as having arrived
	 * @since 2.0.0
	 */
	public function set_booking_arrived() {
		$booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : 0;

		$booking_id = wp_update_post(array(
			'ID' => $booking_id,
			'post_status' => 'arrived'
		) );

		if ( $booking_id ) {
			wp_send_json_success();
		}
		else {
			wp_send_json_error(
				array(
					'error' => 'loggedout',
					'msg' => sprintf( __( 'You have been logged out. Please %slogin again%s.', 'restaurant-reservations' ), '<a href="' . wp_login_url( ) . '">', '</a>' ),
				)
			);
		}
	}

	/**
	 * Validate post status and notification fields
	 * @since 1.3
	 */
	public function validate_admin_fields( $booking ) {

		// Only validate in the admin
		if ( !$_POST['action'] || $_POST['action'] !== 'admin_booking_request' ) {
			return;
		}

		global $rtb_controller;

		// Disable Notifications
		$booking->send_notifications = empty( $_POST['rtb-notifications'] ) ? false : true;
	}

	/**
	 * Adjust post status when adding/editing a booking from the admin area
	 * @since 1.3
	 */
	public function insert_booking_data( $args, $booking ) {

		// Validate user request
		if ( empty( $_POST['action'] ) || $_POST['action'] !== 'admin_booking_request' || !current_user_can( 'manage_bookings' ) ) {
			return $args;
		}

		if ( !empty( $booking->post_status ) ) {
			$args['post_status'] = $booking->post_status;
		}

		return $args;
	}

	/**
	 * Maybe disable notifications when adding/editing bookings from the
	 * admin booking modal
	 * @since 1.3
	 */
	public function maybe_disable_notifications() {

		// Don't disable notifications if they have opted to send them
		if ( !empty( $_POST['rtb-notifications'] ) ) {
			return;
		}

		// Disable all notifications. This filter is here in case a
		// third-party sets up a notification that they don't want to be
		// disabled even if the user has opted not to send notifications
		// To exempt a notification, hook into the filter and copy it
		// from $rtb_notifications to the empty array.
		global $rtb_controller;
		$rtb_controller->notifications->notifications = apply_filters( 'rtb_admin_disabled_notifications_exemption', array(), $rtb_controller->notifications->notifications );
	}
}
} // endif;
