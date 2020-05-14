<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbDashboard' ) ) {
/**
 * Class to handle plugin dashboard
 *
 * @since 2.0.0
 */
class rtbDashboard {

	public $message;
	public $status = true;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_dashboard_to_menu' ), 99 );
		if ( isset($_POST['RTB_Upgrade_To_Full']) ) { add_action( 'init', array( $this, 'check_upgrade_code' ) ); }
		if ( get_option( 'RTB_Trial_Happening' ) == 'Yes' ) { 
			add_action('admin_init', array( $this, 'check_trial_status' ) ); 
		}

		add_action( 'admin_enqueue_scripts',  array( $this, 'enqueue_scripts' ) );

		add_action( 'wp_ajax_rtb_hide_upgrade_box', array($this, 'hide_upgrade_box') );
		add_action( 'wp_ajax_rtb_display_upgrade_box', array($this, 'display_upgrade_box') );
	}

	public function add_dashboard_to_menu() {
		global $menu, $submenu;

		add_submenu_page( 
			'rtb-bookings', 
			'Dashboard', 
			'Dashboard', 
			'manage_options', 
			'rtb-dashboard', 
			array($this, 'display_dashboard_screen') 
		);

		// Create a new sub-menu in the order that we want
		$new_submenu = array();
		$menu_item_count = 3;

		if ( ! isset( $submenu['rtb-bookings'] ) or  ! is_array($submenu['rtb-bookings']) ) { return; }
		
		foreach ( $submenu['rtb-bookings'] as $key => $sub_item ) {
			if ( $sub_item[0] == 'Dashboard' ) { $new_submenu[0] = $sub_item; }
			elseif ( $sub_item[0] == 'Bookings' ) { $new_submenu[1] = $sub_item; }
			elseif ( $sub_item[0] == 'Settings' ) { $new_submenu[2] = $sub_item; }
			else {
				$new_submenu[$menu_item_count] = $sub_item;
				$menu_item_count++;
			}
		}
		ksort($new_submenu);
		
		$submenu['rtb-bookings'] = $new_submenu;
		
		if ( isset( $dashboard_key ) ) {
			$submenu['rtb-bookings'][0] = $submenu['rtb-bookings'][$dashboard_key];
			unset($submenu['rtb-bookings'][$dashboard_key]);
		}
	}

	// Enqueues the admin script so that our hacky sub-menu opening function can run
	public function enqueue_scripts() {
		global $admin_page_hooks;

		$currentScreen = get_current_screen();
		if ( $currentScreen->id == $admin_page_hooks['rtb-bookings'] . '_page_rtb-dashboard' ) {
			wp_enqueue_style( 'rtb-admin-css', RTB_PLUGIN_URL . '/assets/css/admin.css', array(), RTB_VERSION );
			wp_enqueue_script( 'rtb-admin-js', RTB_PLUGIN_URL . '/assets/js/admin.js', array( 'jquery' ), RTB_VERSION, true );
		}
	}

	public function check_upgrade_code() {
		global $rtb_controller;

		$key = trim($_POST['Key']);
	
		if ($key == "FSP Trial" and !get_option("RTB_Trial_Happening")) {
			$this->message = __("Trial successfully started!", 'restaurant-reservations');
	
			update_option("RTB_Trial_Expiry_Time", time() + (7*24*60*60));
			update_option("RTB_Trial_Happening", "Yes");

			update_option( "rtb-pre-permission-level", get_option( 'rtb-permission-level' ) );
			update_option( "rtb-permission-level", 2 );
			$rtb_controller->permissions->update_permissions();
	
			$Admin_Email = get_option('admin_email');
	
			$opts = array('http'=>array('method'=>"GET"));
			$context = stream_context_create($opts);
			$Response = file_get_contents("http://www.fivestarplugins.com/key-check/Register_Trial.php?Plugin=RTB&Admin_Email=" . $Admin_Email . "&Site=" . get_bloginfo('wpurl'), false, $context);
		}
		elseif ($key == "FSP Trial") {
			$this->status = false;
			$this->message = __('Trial has already been used.', 'restaurant-reservations');
		}
		elseif (strlen($key) < 18 or strlen($key) > 22) {
			$this->status = false;
			$this->message = __('Invalid License Key', 'restaurant-reservations');
		}
		elseif ($key != "FSP Trial") {
			$opts = array('http'=>array('method'=>"GET"));
			$context = stream_context_create($opts);
			$Response = unserialize(file_get_contents("http://www.fivestarplugins.com/key-check/FSP_RTB_KeyCheck.php?Key=" . $key . "&Site=" . get_bloginfo('wpurl'), false, $context));
			
			if ($Response['Message_Type'] == "Error") {
				$this->status = false;
				$this->message = $Response['Message'];
			}
			else {
				$this->message = $Response['Message'];
				update_option("RTB_Trial_Happening", "No");
				delete_option("RTB_Trial_Expiry_Time");

				if ( is_array($Response) and isset($Response['Permission_Level']) and $Response['Permission_Level'] == 3 ) { update_option( "rtb-permission-level", 3 ); }
				else { update_option( "rtb-permission-level", 2 ); }
				$rtb_controller->permissions->update_permissions();
			}
		}

		add_action( 'admin_notices', array( $this, 'display_notice' ) );
	}

	public function check_trial_status() {
		global $rtb_controller;

		if ( get_option("RTB_Trial_Happening") == "Yes" and  get_option( 'RTB_Trial_Expiry_Time' ) < time() ) {
			update_option( 'RTB_Trial_Happening', 'No');

			$rtb_controller->settings->set_setting( 'view-bookings-page', '' );
			$rtb_controller->settings->set_setting( 'rtb-enable-max-tables', false );
			$rtb_controller->settings->set_setting( 'auto-confirm-max-reservations', '' );
			$rtb_controller->settings->set_setting( 'auto-confirm-max-seats', '' );
			$rtb_controller->settings->set_setting( 'mc-lists', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-layout', 'default' );
			$rtb_controller->settings->set_setting( 'rtb-styling-section-title-font-family', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-section-title-font-size', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-section-title-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-section-background-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-section-border-size', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-section-border-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-label-font-family', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-label-font-size', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-label-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-add-message-button-background-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-add-message-button-background-hover-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-add-message-button-text-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-add-message-button-text-hover-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-request-booking-button-background-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-request-booking-button-background-hover-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-request-booking-button-text-color', '' );
			$rtb_controller->settings->set_setting( 'rtb-styling-request-booking-button-text-hover-color', '' );
			$rtb_controller->settings->save_settings();

			ajax_reset_all( true );
			
			update_option( 'rtb-permission-level', get_option( 'rtb-pre-permission-level' ) );
			$rtb_controller->permissions->update_permissions();
		}
	}

	public function display_dashboard_screen() { 
		global $rtb_controller;

		$permission = $rtb_controller->permissions->check_permission( 'styling' );
		$ultimate = $rtb_controller->permissions->check_permission( 'payments' );

		?>
		<div id="rtb-dashboard-content-area">

			<div id="rtb-dashboard-content-left">
		
				<?php if ( ! $permission or ! $ultimate or get_option("RTB_Trial_Happening") == "Yes") { ?>
					<div id="rtb-dashboard-upgrade-box" class="rtb-dashboard-new-widget-box ewd-widget-box-full <?php echo ( get_option( 'rtb-hide-upgrade-box' ) ? 'rtb-hidden' : '' ); ?>">
						<div class="rtb-dashboard-new-widget-box-top">
							<?php if ( $permission ) { ?>
								<div class="rtb-ultimate-notification">
									<?php _e( 'Thanks for being a premium user! <strong>If you\'re looking to upgrade to our ultimate version, enter your new product key below.</strong>', 'restaurant-reservations' ); ?>
								</div>
								<div class="rtb-ultimate-upgrade-dismiss"></div>
							<?php } ?>
							<form method="post" action="admin.php?page=rtb-dashboard" class="rtb-dashboard-key-widget">
								<input class="rtb-dashboard-key-widget-input" name="Key" type="text" placeholder="<?php _e('Enter License Key Here', 'restaurant-reservations'); ?>">
								<input class="rtb-dashboard-key-widget-submit" name="RTB_Upgrade_To_Full" type="submit" value="<?php echo ( ! $permission ? __('UNLOCK PREMIUM', 'restaurant-reservations') : __('UNLOCK ULTIMATE', 'restaurant-reservations') ) ?>">
								<div class="rtb-dashboard-key-widget-text">Don't have a key? <a href="https://www.fivestarplugins.com/license-payment/?Selected=RTB&Quantity=1" target="_blank">Upgrade Now</a> to unlock all <?php echo (! $permission ? 'premium' : 'ultimate'); ?> features.</div>
							</form>
						</div>
					</div>
				<?php } ?>
		
				<div class="rtb-dashboard-new-widget-box ewd-widget-box-full" id="rtb-dashboard-support-widget-box">
					<div class="rtb-dashboard-new-widget-box-top">Get Support<span id="rtb-dash-mobile-support-down-caret">&nbsp;&nbsp;&#9660;</span><span id="rtb-dash-mobile-support-up-caret">&nbsp;&nbsp;&#9650;</span></div>
					<div class="rtb-dashboard-new-widget-box-bottom">
						<ul class="rtb-dashboard-support-widgets">
							<li>
								<a href="https://www.youtube.com/channel/UCZPuaoetCJB1vZOmpnMxJNw/featured" target="_blank">
									<img src="<?php echo plugins_url( '../assets/img/ewd-support-icon-youtube.png', __FILE__ ); ?>">
									<div class="rtb-dashboard-support-widgets-text">YouTube Tutorials</div>
								</a>
							</li>
							<li>
								<a href="https://wordpress.org/plugins/restaurant-reservations/#faq" target="_blank">
									<img src="<?php echo plugins_url( '../assets/img/ewd-support-icon-faqs.png', __FILE__ ); ?>">
									<div class="rtb-dashboard-support-widgets-text">Plugin FAQs</div>
								</a>
							</li>
							<li>
								<a href="http://doc.fivestarplugins.com/plugins/restaurant-reservations/" target="_blank">
									<img src="<?php echo plugins_url( '../assets/img/ewd-support-icon-documentation.png', __FILE__ ); ?>">
									<div class="rtb-dashboard-support-widgets-text">Documentation</div>
								</a>
							</li>
							<li>
								<a href="https://www.fivestarplugins.com/support-center/" target="_blank">
									<img src="<?php echo plugins_url( '../assets/img/ewd-support-icon-forum.png', __FILE__ ); ?>">
									<div class="rtb-dashboard-support-widgets-text">Get Support</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
		
				<div class="rtb-dashboard-new-widget-box ewd-widget-box-full" id="rtb-dashboard-optional-table">
					<div class="rtb-dashboard-new-widget-box-top">Bookings Summary<span id="rtb-dash-optional-table-down-caret">&nbsp;&nbsp;&#9660;</span><span id="rtb-dash-optional-table-up-caret">&nbsp;&nbsp;&#9650;</span></div>
					<div class="rtb-dashboard-new-widget-box-bottom">
						<table class='rtb-overview-table wp-list-table widefat fixed striped posts'>
							<thead>
								<tr>
									<th><?php _e("Date", 'restaurant-reservations'); ?></th>
									<th><?php _e("Party", 'restaurant-reservations'); ?></th>
									<th><?php _e("Name", 'restaurant-reservations'); ?></th>
									<th><?php _e("Status", 'restaurant-reservations'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
									require_once( RTB_PLUGIN_DIR . '/includes/Query.class.php' );
									$query = new rtbQuery( array() );
									$query->prepare_args();

									$bookings = $query->get_bookings();
		
									if (sizeOf($bookings) == 0) {echo "<tr><td colspan='4'>" . __("No bookings to display yet. Create a booking for it to be displayed here.", 'restaurant-reservations') . "</td></tr>";}
									else {
										foreach ($bookings as $booking) { 
										?>

											<tr>
												<td><?php echo $booking->date; ?></td>
												<td><?php echo $booking->party; ?></td>
												<td><?php echo $booking->name; ?></td>
												<td><?php echo $booking->post_status; ?></td>
											</tr>
										<?php }
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
		
				<?php /*<div class="rtb-dashboard-new-widget-box <?php echo ( ($hideReview != 'Yes' and $Ask_Review_Date < time()) ? 'ewd-widget-box-two-thirds' : 'ewd-widget-box-full' ); ?>">
					<div class="rtb-dashboard-new-widget-box-top">What People Are Saying</div>
					<div class="rtb-dashboard-new-widget-box-bottom">
						<ul class="rtb-dashboard-testimonials">
							<?php $randomTestimonial = rand(0,2);
							if($randomTestimonial == 0){ ?>
								<li id="rtb-dashboard-testimonial-one">
									<img src="<?php echo plugins_url( '../assets/img/dash-asset-stars.png', __FILE__ ); ?>">
									<div class="rtb-dashboard-testimonial-title">"Awesome. Just Awesome."</div>
									<div class="rtb-dashboard-testimonial-author">- @shizart</div>
									<div class="rtb-dashboard-testimonial-text">Thanks for this very well-made plugin. This works so well out of the box, I barely had to do ANYTHING to create an amazing FAQ accordion display... <a href="https://wordpress.org/support/topic/awesome-just-awesome-11/" target="_blank">read more</a></div>
								</li>
							<?php }
							if($randomTestimonial == 1){ ?>
								<li id="rtb-dashboard-testimonial-two">
									<img src="<?php echo plugins_url( '../assets/img/dash-asset-stars.png', __FILE__ ); ?>">
									<div class="rtb-dashboard-testimonial-title">"Absolutely perfect with great support"</div>
									<div class="rtb-dashboard-testimonial-author">- @isaac85</div>
									<div class="rtb-dashboard-testimonial-text">I tried several different FAQ plugins and this is by far the prettiest and easiest to use... <a href="https://wordpress.org/support/topic/absolutely-perfect-with-great-support/" target="_blank">read more</a></div>
								</li>
							<?php }
							if($randomTestimonial == 2){ ?>
								<li id="rtb-dashboard-testimonial-three">
									<img src="<?php echo plugins_url( '../assets/img/dash-asset-stars.png', __FILE__ ); ?>">
									<div class="rtb-dashboard-testimonial-title">"Perfect FAQ Plugin"</div>
									<div class="rtb-dashboard-testimonial-author">- @muti-wp</div>
									<div class="rtb-dashboard-testimonial-text">Works great! Easy to configure and to use. Thanks! <a href="https://wordpress.org/support/topic/perfect-faq-plugin/" target="_blank">read more</a></div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div> */ ?>
		
				<?php /* if($hideReview != 'Yes' and $Ask_Review_Date < time()){ ?>
					<div class="rtb-dashboard-new-widget-box ewd-widget-box-one-third">
						<div class="rtb-dashboard-new-widget-box-top">Leave a review</div>
						<div class="rtb-dashboard-new-widget-box-bottom">
							<div class="rtb-dashboard-review-ask">
								<img src="<?php echo plugins_url( '../assets/img/dash-asset-stars.png', __FILE__ ); ?>">
								<div class="rtb-dashboard-review-ask-text">If you enjoy this plugin and have a minute, please consider leaving a 5-star review. Thank you!</div>
								<a href="https://wordpress.org/plugins/ultimate-faqs/#reviews" class="rtb-dashboard-review-ask-button">LEAVE A REVIEW</a>
								<form action="admin.php?page=EWD-UFAQ-Options" method="post">
									<input type="hidden" name="hide_ufaq_review_box_hidden" value="Yes">
									<input type="submit" name="hide_ufaq_review_box_submit" class="rtb-dashboard-review-ask-dismiss" value="I've already left a review">
								</form>
							</div>
						</div>
					</div>
				<?php } */ ?>
		
				<?php if ( ! $permission or get_option("RTB_Trial_Happening") == "Yes" ) { ?>
					<div class="rtb-dashboard-new-widget-box ewd-widget-box-full" id="rtb-dashboard-guarantee-widget-box">
						<div class="rtb-dashboard-new-widget-box-top">
							<div class="rtb-dashboard-guarantee">
								<div class="rtb-dashboard-guarantee-title">14-Day 100% Money-Back Guarantee</div>
								<div class="rtb-dashboard-guarantee-text">If you're not 100% satisfied with the premium version of our plugin - no problem. You have 14 days to receive a FULL REFUND. We're certain you won't need it, though.</div>
							</div>
						</div>
					</div>
				<?php } ?>
		
			</div> <!-- left -->
		
			<div id="rtb-dashboard-content-right">
		
				<?php if ( ! $permission or get_option("RTB_Trial_Happening") == "Yes" ) { ?>
					<div class="rtb-dashboard-new-widget-box ewd-widget-box-full" id="rtb-dashboard-get-premium-widget-box">
						<div class="rtb-dashboard-new-widget-box-top">Get Premium</div>
						<?php if(get_option("RTB_Trial_Happening") == "Yes"){ 
							$trialExpireTime = get_option("RTB_Trial_Expiry_Time");
							$currentTime = time();
							$trialTimeLeft = $trialExpireTime - $currentTime;
							$trialTimeLeftDays = ( date("d", $trialTimeLeft) ) - 1;
							$trialTimeLeftHours = date("H", $trialTimeLeft);
							?>
							<div class="rtb-dashboard-new-widget-box-bottom">
								<div class="rtb-dashboard-get-premium-widget-trial-time">
									<div class="rtb-dashboard-get-premium-widget-trial-days"><?php echo $trialTimeLeftDays; ?><span>days</span></div>
									<div class="rtb-dashboard-get-premium-widget-trial-hours"><?php echo $trialTimeLeftHours; ?><span>hours</span></div>
								</div>
								<div class="rtb-dashboard-get-premium-widget-trial-time-left">LEFT IN TRIAL</div>
							</div>
						<?php } ?>
						<div class="rtb-dashboard-new-widget-box-bottom">
							<div class="rtb-dashboard-get-premium-widget-features-title"<?php echo ( get_option("RTB_Trial_Happening") == "Yes" ? "style='padding-top: 20px;'" : ""); ?>>GET FULL ACCESS WITH OUR PREMIUM VERSION AND GET:</div>
							<ul class="rtb-dashboard-get-premium-widget-features">
								<li>Multiple Layouts</li>
								<li>Custom Fields</li>
								<li>MailChimp Integration</li>
								<li>Advanced Styling Options</li>
								<li>+ More</li>
							</ul>
							<a href="https://www.fivestarplugins.com/license-payment/?Selected=RTB&Quantity=1" class="rtb-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
							<?php if (!get_option("RTB_Trial_Happening")) { ?>
								<form method="post" action="admin.php?page=rtb-dashboard">
									<input name="Key" type="hidden" value='FSP Trial'>
									<input name="RTB_Upgrade_To_Full" type="hidden" value='RTB_Upgrade_To_Full'>
									<button class="rtb-dashboard-get-premium-widget-button rtb-dashboard-new-trial-button">GET FREE 7-DAY TRIAL</button>
								</form>
							<?php } ?>
				</div>
					</div>
				<?php } ?>
		
				<!-- <div class="rtb-dashboard-new-widget-box ewd-widget-box-full">
					<div class="rtb-dashboard-new-widget-box-top">Other Plugins by Etoile</div>
					<div class="rtb-dashboard-new-widget-box-bottom">
						<ul class="rtb-dashboard-other-plugins">
							<li>
								<a href="https://wordpress.org/plugins/ultimate-product-catalogue/" target="_blank"><img src="<?php echo plugins_url( '../images/ewd-upcp-icon.png', __FILE__ ); ?>"></a>
								<div class="rtb-dashboard-other-plugins-text">
									<div class="rtb-dashboard-other-plugins-title">Product Catalog</div>
									<div class="rtb-dashboard-other-plugins-blurb">Enables you to display your business's products in a clean and efficient manner.</div>
								</div>
							</li>
							<li>
								<a href="https://wordpress.org/plugins/ultimate-reviews/" target="_blank"><img src="<?php echo plugins_url( '../images/ewd-urp-icon.png', __FILE__ ); ?>"></a>
								<div class="rtb-dashboard-other-plugins-text">
									<div class="rtb-dashboard-other-plugins-title">Ultimate Reviews</div>
									<div class="rtb-dashboard-other-plugins-blurb">Let visitors submit reviews and display them right in the tabbed page layout!</div>
								</div>
							</li>
						</ul>
					</div>
				</div> -->
		
			</div> <!-- right -->	
		
		</div> <!-- rtb-dashboard-content-area -->
		
		<?php if ( ! $permission or get_option("RTB_Trial_Happening") == "Yes" ) { ?>
			<div id="rtb-dashboard-new-footer-one">
				<div class="rtb-dashboard-new-footer-one-inside">
					<div class="rtb-dashboard-new-footer-one-left">
						<div class="rtb-dashboard-new-footer-one-title">What's Included in Our Premium Version?</div>
						<ul class="rtb-dashboard-new-footer-one-benefits">
							<li>Multiple Form Layouts</li>
							<li>Custom Form Fields</li>
							<li>Advanced Email Designer</li>
							<li>MailChimp Integration</li>
							<li>Set Table and Seat Restrictions</li>
							<li>Automatic Booking Confirmation</li>
							<li>Bookings Page for Staff</li>
							<li>Export Bookings</li>
							<li>Advanced Styling Options</li>
						</ul>
					</div>
					<div class="rtb-dashboard-new-footer-one-buttons">
						<a class="rtb-dashboard-new-upgrade-button" href="https://www.fivestarplugins.com/license-payment/?Selected=RTB&Quantity=1" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			</div> <!-- rtb-dashboard-new-footer-one -->
		<?php } ?>	
		<div id="rtb-dashboard-new-footer-two">
			<div class="rtb-dashboard-new-footer-two-inside">
				<img src="<?php echo plugins_url( '../assets/img/fivestartextlogowithstar.png', __FILE__ ); ?>" class="rtb-dashboard-new-footer-two-icon">
				<div class="rtb-dashboard-new-footer-two-blurb">
					At Five Star Plugins, we build powerful, easy-to-use WordPress plugins with a focus on the restaurant, hospitality and business industries. With a modern, responsive look and a highly-customizable feature set, Five Star Plugins can be used as out-of-the-box solutions and can also be adapted to your specific requirements.
				</div>
				<ul class="rtb-dashboard-new-footer-two-menu">
					<li>SOCIAL</li>
					<li><a href="https://www.facebook.com/EtoileWebDesign/" target="_blank">Facebook</a></li>
					<li><a href="https://twitter.com/EtoileWebDesign" target="_blank">Twitter</a></li>
					<li><a href="https://www.fivestarplugins.com/blog/" target="_blank">Blog</a></li>
				</ul>
				<ul class="rtb-dashboard-new-footer-two-menu">
					<li>SUPPORT</li>
					<li><a href="https://www.youtube.com/channel/UCZPuaoetCJB1vZOmpnMxJNw/featured" target="_blank">YouTube Tutorials</a></li>
					<li><a href="http://doc.fivestarplugins.com/plugins/restaurant-reservations/" target="_blank">Documentation</a></li>
					<li><a href="https://www.fivestarplugins.com/support-center/" target="_blank">Get Support</a></li>
					<li><a href="https://wordpress.org/plugins/restaurant-reservations/#faq" target="_blank">FAQs</a></li>
					<li><a id="rtb-dashboard-show-upgrade-box-link" href="#rtb-dashboard-upgrade-box">Ultimate Upgrade</a></li>
				</ul>
			</div>
		</div> <!-- rtb-dashboard-new-footer-two -->
		
	<?php }

	public function get_term_from_array($terms, $term_id) {
		foreach ($terms as $term) {if ($term->term_id == $term_id) {return $term;}}

		return array();
	}

	public function display_notice() {
		if ( $this->status ) {
			echo "<div class='updated'><p>" . $this->message . "</p></div>";
		}
		else {
			echo "<div class='error'><p>" . $this->message . "</p></div>";
		}
	}

	public function hide_upgrade_box() {
		update_option( 'rtb-hide-upgrade-box', true );
	}

	public function display_upgrade_box() {
		update_option( 'rtb-hide-upgrade-box', false );
	}
}
} // endif
