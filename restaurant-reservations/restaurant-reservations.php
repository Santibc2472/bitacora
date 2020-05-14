<?php
/**
 * Plugin Name: Five Star Restaurant Reservations
 * Plugin URI: http://www.fivestarplugins.com/plugins/five-star-restaurant-reservations/
 * Description: Restaurant reservations made easy. Accept bookings online. Quickly confirm or reject reservations, send email notifications, set booking times and more.
 * Version: 2.1.2
 * Author: FiveStarPlugins
 * Author URI: https://profiles.wordpress.org/fivestarplugins/
 * Text Domain: restaurant-reservations
 */
if ( ! defined( 'ABSPATH' ) )
	exit;

if ( !class_exists( 'rtbInit' ) ) {
class rtbInit {

	/**
	 * Set a flag which tracks whether the form has already been rendered on
	 * the page. Only one form per page for now.
	 * @todo support multiple forms per page
	 */
	public $form_rendered = false;

	/**
	* Set a flag which tracks whether the view bookings form has already been 
	* rendered on the page. Only one form per page for now.
	*/
	public $display_bookings_form_rendered = false;

	/**
	 * An object which stores a booking request, or an empty object if
	 * no request has been processed.
	 */
	public $request;

	/**
	 * Initialize the plugin and register hooks
	 */
	public function __construct() {

		// Common strings
		define( 'RTB_VERSION', '2.0.7' );
		define( 'RTB_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'RTB_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
		define( 'RTB_PLUGIN_FNAME', plugin_basename( __FILE__ ) );
		define( 'RTB_BOOKING_POST_TYPE', 'rtb-booking' );
		define( 'RTB_BOOKING_POST_TYPE_SLUG', 'booking' );

		// Initialize the plugin
		add_action( 'init', array( $this, 'load_textdomain' ) );

		// Set up empty request object
		$this->request = new stdClass();
		$this->request->request_processed = false;
		$this->request->request_inserted = false;

		// Load query class
		require_once( RTB_PLUGIN_DIR . '/includes/Query.class.php' );

		// Add custom roles and capabilities
		add_action( 'init', array( $this, 'add_roles' ) );

		// Load the plugin permissions
		require_once( RTB_PLUGIN_DIR . '/includes/Permissions.class.php' );
		$this->permissions = new rtbPermissions();
		$this->handle_combination();

		// Load custom post types
		require_once( RTB_PLUGIN_DIR . '/includes/CustomPostTypes.class.php' );
		$this->cpts = new rtbCustomPostTypes();

		// Load deactivation survey
		require_once( RTB_PLUGIN_DIR . '/includes/DeactivationSurvey.class.php' );
		new rtbDeactivationSurvey();

		// Load review ask
		require_once( RTB_PLUGIN_DIR . '/includes/ReviewAsk.class.php' );
		new rtbReviewAsk();

		// Load multiple location support
		require_once( RTB_PLUGIN_DIR . '/includes/MultipleLocations.class.php' );
		$this->locations = new rtbMultipleLocations();

		// Flush the rewrite rules for the custom post types
		register_activation_hook( __FILE__, array( $this, 'rewrite_flush' ) );

		// Load the template functions which print the booking form, etc
		require_once( RTB_PLUGIN_DIR . '/includes/template-functions.php' );

		// Load the admin bookings page
		require_once( RTB_PLUGIN_DIR . '/includes/AdminBookings.class.php' );
		$this->bookings = new rtbAdminBookings();

		// Load assets
		add_action( 'admin_notices', array($this, 'display_header_area'));
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );

		// Handle notifications
		require_once( RTB_PLUGIN_DIR . '/includes/Notifications.class.php' );
		$this->notifications = new rtbNotifications();

		// Load settings
		require_once( RTB_PLUGIN_DIR . '/includes/Settings.class.php' );
		$this->settings = new rtbSettings();

		// Load plugin dashboard
		require_once( RTB_PLUGIN_DIR . '/includes/Dashboard.class.php' );
		new rtbDashboard();

		// Load walk-through
		require_once( RTB_PLUGIN_DIR . '/includes/InstallationWalkthrough.class.php' );
		new rtbInstallationWalkthrough();
		register_activation_hook( __FILE__, array( $this, 'run_walkthrough' ) );

		// Create cron jobs for reminders and late arrivals
		require_once( RTB_PLUGIN_DIR . '/includes/Cron.class.php' );
		$this->cron = new rtbCron();
		register_activation_hook( __FILE__, array( $this, 'cron_schedule_events' ) );
		register_deactivation_hook( __FILE__, array( $this, 'cron_unschedule_events' ) );

		// Handle AJAX actions
		require_once( RTB_PLUGIN_DIR . '/includes/Ajax.class.php' );
		$this->ajax = new rtbAJAX();

		// Handle setting up exports
		require_once( RTB_PLUGIN_DIR . '/includes/ExportHandler.class.php' );
		$this->exports = new rtbExportHandler();

		// Handle setting up exports
		require_once( RTB_PLUGIN_DIR . '/includes/EmailTemplates.class.php' );
		$this->email_templates = new rtbEmailTemplates();

		// Load the custom fields
		require_once( RTB_PLUGIN_DIR . '/includes/CustomFields.class.php' );
		$this->custom_fields = new rtbCustomFields();

		// Load in the custom fields controller
		require_once( RTB_PLUGIN_DIR . '/includes/Field.Controller.class.php' );
		require_once( RTB_PLUGIN_DIR . '/includes/Field.class.php' );
		$this->fields = new rtbFieldController();

		// Load the custom fields editor page
		require_once( RTB_PLUGIN_DIR . '/includes/Editor.class.php' );
		$this->editor = new cffrtbEditor();

		// Load MailChimp integration
		require_once( RTB_PLUGIN_DIR . '/includes/MailChimp.class.php' );
		$this->mailchimp = new mcfrtbInit();

		// Append booking form to a post's $content variable
		add_filter( 'the_content', array( $this, 'append_to_content' ) );

		// Register the widget
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );

		// Add links to plugin listing
		add_filter('plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2);

		// Load integrations with other plugins
		require_once( RTB_PLUGIN_DIR . '/includes/integrations/business-profile.php' );
		require_once( RTB_PLUGIN_DIR . '/includes/integrations/woocommerce.php' );

		// Load gutenberg blocks
		require_once( RTB_PLUGIN_DIR . '/includes/Blocks.class.php' );
		new rtbBlocks();

		// Load backwards compatibility functions
		require_once( RTB_PLUGIN_DIR . '/includes/Compatibility.class.php' );
		new rtbCompatibility();

	}

	/**
	 * Flush the rewrite rules when this plugin is activated to update with
	 * custom post types
	 * @since 0.0.1
	 */
	public function rewrite_flush() {
		$this->cpts->load_cpts();
		flush_rewrite_rules();
	}

	/**
	 * Load the plugin textdomain for localistion
	 * @since 0.0.1
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'restaurant-reservations', false, plugin_basename( dirname( __FILE__ ) ) . "/languages/" );
	}

	/**
	 * Set a transient so that the walk-through gets run
	 * @since 2.0
	 */
	public function run_walkthrough() {
		set_transient('rtb-getting-started', true, 30);
	} 

	/**
	 * Add a role to manage the bookings and add the capability to Editors,
	 * Administrators and Super Admins
	 * @since 0.0.1
	 */
	public function add_roles() {

		// The booking manager should be able to access the bookings list and
		// update booking statuses, but shouldn't be able to touch anything else
		// in the account.
		$booking_manager = add_role(
			'rtb_booking_manager',
			__( 'Booking Manager', 'restaurant-reservations' ),
			array(
				'read'				=> true,
				'manage_bookings'	=> true,
			)
		);

		$manage_bookings_roles = apply_filters(
			'rtb_manage_bookings_roles',
			array(
				'administrator',
				'editor',
			)
		);

		global $wp_roles;
		foreach ( $manage_bookings_roles as $role ) {
			$wp_roles->add_cap( $role, 'manage_bookings' );
		}
	}

	/**
	 * Append booking form to a post's $content variable
	 * @since 0.0.1
	 */
	function append_to_content( $content ) {
		global $post;

		if ( !is_main_query() || !in_the_loop() || post_password_required() ) {
			return $content;
		}

		if ( $post->ID == $this->settings->get_setting( 'booking-page' ) ) {
			return $content . rtb_print_booking_form();
		}

		if ( $post->ID == $this->settings->get_setting( 'view-bookings-page' ) ) {

			if ( $this->settings->get_setting( 'view-bookings-private' ) and ! is_user_logged_in() ) { return $content; }

			$args = array();
			if ( isset($_GET['date']) ) { $args['date'] = $_GET['date']; }

			return $content . rtb_print_view_bookings_form( $args );
		}
		$view_bookings_page = $this->settings->get_setting( 'view-bookings-page' );

		return $content;
	}

	/**
	 * Adds in a menu bar for the plugin
	 * @since 2.0
	 */
	public function display_header_area() {
		global $rtb_controller, $admin_page_hooks, $post;

		$screen = get_current_screen();
		$screenID = $screen->id;
		
		if ( $screenID != $admin_page_hooks['rtb-bookings'] . '_page_rtb-settings' && $screenID != 'toplevel_page_rtb-bookings' && $screenID != $admin_page_hooks['rtb-bookings'] . '_page_rtb-dashboard' && $screenID != $admin_page_hooks['rtb-bookings'] . '_page_cffrtb-editor' ) {return;}

		if ( ! $rtb_controller->permissions->check_permission( 'styling' ) || get_option("RTB_Trial_Happening") == "Yes" ) {
			?>
			<div class="rtb-dashboard-new-upgrade-banner">
				<div class="rtb-dashboard-banner-icon"></div>
				<div class="rtb-dashboard-banner-buttons">
					<a class="rtb-dashboard-new-upgrade-button" href="https://www.fivestarplugins.com/license-payment/?Selected=RTB&Quantity=1" target="_blank">UPGRADE NOW</a>
				</div>
				<div class="rtb-dashboard-banner-text">
					<div class="rtb-dashboard-banner-title">
						GET FULL ACCESS WITH OUR PREMIUM VERSION
					</div>
					<div class="rtb-dashboard-banner-brief">
						New layouts, custom fields, MailChimp integration and more!
					</div>
				</div>
			</div>
			<?php
		}

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( get_option( 'rtb-pro-was-active' ) > time() - 7*24*3600 ) {
			echo "<div class='rtb-deactivate-pro'>";
			echo "<p>We've combined the code base for the free and pro versions into one plugin file for easier management.</p>";
			echo "<p>You still have access to the premium features you purchased, and you can read more about why we've combined them <a href='http://www.fivestarplugins.com/2019/10/21/five-star-restaurant-reservations-new-features-more-options/'>on our blog</a></p>";
			echo "</div>";
		}
		
		?>
		<div class="rtb-admin-header-menu">
			<h2 class="nav-tab-wrapper">
			<a id="rtb-dash-mobile-menu-open" href="#" class="menu-tab nav-tab"><?php _e("MENU", 'restaurant-reservations'); ?><span id="rtb-dash-mobile-menu-down-caret">&nbsp;&nbsp;&#9660;</span><span id="rtb-dash-mobile-menu-up-caret">&nbsp;&nbsp;&#9650;</span></a>
			<a id="dashboard-menu" href='admin.php?page=rtb-dashboard' class="menu-tab nav-tab <?php if ($screenID == 'bookings_page_rtb-dashboard') {echo 'nav-tab-active';}?>"><?php _e("Dashboard", 'restaurant-reservations'); ?></a>
			<a id="bookings-menu" href='admin.php?page=rtb-bookings' class="menu-tab nav-tab <?php if ($screenID == 'toplevel_page_rtb-bookings') {echo 'nav-tab-active';}?>"><?php _e("Bookings", 'restaurant-reservations'); ?></a>
			<a id="options-menu" href='admin.php?page=rtb-settings' class="menu-tab nav-tab <?php if ($screenID == 'bookings_page_rtb-settings') {echo 'nav-tab-active';}?>"><?php _e("Settings", 'restaurant-reservations'); ?></a>
			<?php if ($rtb_controller->permissions->check_permission( 'custom_fields' ) ) { ?><a id="customfields-menu" href='admin.php?page=cffrtb-editor' class="menu-tab nav-tab <?php if ($screenID == 'bookings_page_cffrtb-editor') {echo 'nav-tab-active';}?>"><?php _e("Custom Fields", 'restaurant-reservations'); ?></a><?php } ?>
			</h2>
		</div>
		<?php
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

		if ( $screen->base == 'toplevel_page_rtb-bookings' || $screen->base == $admin_page_hooks['rtb-bookings'] . '_page_rtb-settings' || $screen->base == $admin_page_hooks['rtb-bookings'] . '_page_rtb-addons' ) {
			wp_enqueue_style( 'rtb-admin-css', RTB_PLUGIN_URL . '/assets/css/admin.css', array(), RTB_VERSION );
			wp_enqueue_script( 'rtb-admin-js', RTB_PLUGIN_URL . '/assets/js/admin.js', array( 'jquery' ), '', true );
			wp_enqueue_style( 'rtb-spectrum-css', RTB_PLUGIN_URL . '/assets/css/spectrum.css' );
			wp_enqueue_script( 'rtb-spectrum-js', RTB_PLUGIN_URL . '/assets/js/spectrum.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'rtb-admin-settings-js', RTB_PLUGIN_URL . '/assets/js/admin-settings.js', array( 'jquery' ), '', true );
			wp_localize_script(
				'rtb-admin-js',
				'rtb_admin',
				array(
					'nonce'		=> wp_create_nonce( 'rtb-admin' ),
					'strings'	=> array(
						'add_booking'		=> __( 'Add Booking', 'restaurant-reservations' ),
						'edit_booking'		=> __( 'Edit Booking', 'restaurant-reservations' ),
						'error_unspecified'	=> __( 'An unspecified error occurred. Please try again. If the problem persists, try logging out and logging back in.', 'restaurant-reservations' ),
					),
					'banned_emails' => preg_split( '/\r\n|\r|\n/', (string) $rtb_controller->settings->get_setting( 'ban-emails' ) ),
					'banned_ips' => preg_split( '/\r\n|\r|\n/', (string) $rtb_controller->settings->get_setting( 'ban-ips' ) ),
					'export_url' => admin_url( '?action=ebfrtb-export' )
				)
			);
		}

		// Enqueue frontend assets to add/edit bookins on the bookings page
		if ( $screen->base == 'toplevel_page_rtb-bookings' ) {
			$this->register_assets();
			rtb_enqueue_assets();
		}
	}

	/**
	 * Register the front-end CSS and Javascript for the booking form
	 * @since 0.0.1
	 */
	function register_assets() {

		if ( !apply_filters( 'rtb-load-frontend-assets', true ) ) {
			return;
		}

		wp_register_style( 'pickadate-default', RTB_PLUGIN_URL . '/lib/simple-admin-pages/lib/pickadate/themes/default.css' );
		wp_register_style( 'pickadate-date', RTB_PLUGIN_URL . '/lib/simple-admin-pages/lib/pickadate/themes/default.date.css' );
		wp_register_style( 'pickadate-time', RTB_PLUGIN_URL . '/lib/simple-admin-pages/lib/pickadate/themes/default.time.css' );
		wp_register_script( 'pickadate', RTB_PLUGIN_URL . '/lib/simple-admin-pages/lib/pickadate/picker.js', array( 'jquery' ), '', true );
		wp_register_script( 'pickadate-date', RTB_PLUGIN_URL . '/lib/simple-admin-pages/lib/pickadate/picker.date.js', array( 'jquery' ), '', true );
		wp_register_script( 'pickadate-time', RTB_PLUGIN_URL . '/lib/simple-admin-pages/lib/pickadate/picker.time.js', array( 'jquery' ), '', true );
		wp_register_script( 'pickadate-legacy', RTB_PLUGIN_URL . '/lib/simple-admin-pages/lib/pickadate/legacy.js', array( 'jquery' ), '', true );

		$i8n = $this->settings->get_setting( 'i8n' );
		if ( !empty( $i8n ) ) {
			wp_register_script( 'pickadate-i8n', RTB_PLUGIN_URL . '/lib/simple-admin-pages/lib/pickadate/translations/' . esc_attr( $i8n ) . '.js', array( 'jquery' ), '', true );

			// Arabic and Hebrew are right-to-left languages
			if ( $i8n == 'ar' || $i8n == 'he_IL' ) {
				wp_register_style( 'pickadate-rtl', RTB_PLUGIN_URL . '/lib/simple-admin-pages/lib/pickadate/themes/rtl.css' );
			}
		}

		wp_register_style( 'rtb-booking-form', RTB_PLUGIN_URL . '/assets/css/booking-form.css' );
		wp_register_script( 'rtb-booking-form', RTB_PLUGIN_URL . '/assets/js/booking-form.js', array( 'jquery' ) );
	}

	/**
	 * Register the widgets
	 * @since 0.0.1
	 */
	public function register_widgets() {
		require_once( RTB_PLUGIN_DIR . '/includes/WP_Widget.BookingFormWidget.class.php' );
		register_widget( 'rtbBookingFormWidget' );
	}

	/**
	 * Add links to the plugin listing on the installed plugins page
	 * @since 0.0.1
	 */
	public function plugin_action_links( $links, $plugin ) {

		if ( $plugin == RTB_PLUGIN_FNAME ) {

			$links['help'] = '<a href="http://doc.fivestarplugins.com/plugins/restaurant-reservations/?utm_source=Plugin&utm_medium=Plugin%Help&utm_campaign=Restaurant%20Reservations" title="' . __( 'View the help documentation for Restaurant Reservations', 'restaurant-reservations' ) . '">' . __( 'Help', 'restaurant-reservations' ) . '</a>';
		}

		return $links;

	}

	/**
	 * Register the cron hook that the plugin uses
	 * @since 2.0
	 */
	public function cron_schedule_events() {
		$this->cron->schedule_events();
	}

	/**
	 * Unregister the cron hook that the plugin uses
	 * @since 2.0
	 */
	public function cron_unschedule_events() {
		$this->cron->unschedule_events();
	}

	/**
	 * Handle the codebase combination
	 * @since 2.0
	 */
	public function handle_combination() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		if ( is_plugin_active( "custom-fields-for-rtb/custom-fields-for-rtb.php" ) ) {
			update_option('rtb-pro-was-active', time());
			deactivate_plugins("custom-fields-for-rtb/custom-fields-for-rtb.php");
		}

		if ( is_plugin_active( "email-templates-for-rtb/email-templates-for-rtb.php" ) ) {
			update_option('rtb-pro-was-active', time());
			deactivate_plugins("email-templates-for-rtb/email-templates-for-rtb.php");
		}

		if ( is_plugin_active( "export-bookings-for-rtb/export-bookings-for-rtb.php" ) ) {
			update_option('rtb-pro-was-active', time());
			deactivate_plugins("export-bookings-for-rtb/export-bookings-for-rtb.php");
		}

		if ( is_plugin_active( "mailchimp-for-rtb/mailchimp-for-rtb.php" ) ) {
			update_option('rtb-pro-was-active', time());
			deactivate_plugins("mailchimp-for-rtb/mailchimp-for-rtb.php");
		}
	}

}
} // endif;

global $rtb_controller;
$rtb_controller = new rtbInit();

