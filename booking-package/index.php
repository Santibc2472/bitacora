<?php
/*
Plugin Name: Booking Package SAASPROJECT
Plugin URI:  https://saasproject.net/plans/
Description: Booking Package is a high-performance booking calendar system that anyone can easily use.
Version:     1.4.19
Author:      SAASPROJECT Booking Package
Author URI:  https://saasproject.net/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: booking-package
Domain Path: /languages
*/
	
	if (!defined('ABSPATH')) {
    	exit;
	}
	
	define("BOOKING_PACKAGE_EXTENSION_URL", "https://saasproject.net/api/1.7/");
	
	define("BOOKING_PACKAGE_STRIPE_PUBLIC_KEY", "");
	
	define("BOOKING_PACKAGE_MAX_DEADLINE_TIME", 1440);
	
	class BOOKING_PACKAGE {
		
		public $db_version = "0.7.0";
		
		public $plugin_version = 0;
		
		public $table_name = null;
		
		public $plugin_name = 'booking-package';
		
		public $prefix = 'booking_package_';
		
		public $action_control = 'package_app_action';
		
		public $action_public = 'package_app_public_action';
		
		public $memberRoleName = null;
		
		public $locale = 'en';
		
		public $timezone = 'UTC';
		
		public $is_owner_site = 1;
		
		public $is_mobile = 0;
		
		public $webApp = 1;
		
		public $visitorSubscriptionForStripe = 0;
		
		public $groupOfInputField = 0;
		
		public $siteNetwork = 0;
		
		public $dubug_javascript = 0;
		
		public $optionsForHotel = 0;
		
		public $multipleRooms = 0;
		
		public $expirationDateForTax = 0;
		
		public function __construct() {
			
			$this->memberRoleName = $this->prefix.'member';
			
			global $wpdb;
			/**
			if(wp_is_mobile() === true){
				
				$this->is_mobile = 1;
				
			}
			**/
			
			$this->timezone = get_option('timezone_string', '');
			if (is_null($this->timezone) || strlen($this->timezone) == 0) {
				
				$this->timezone = 'UTC';
				
			}
			//date_default_timezone_set($this->getTimeZone());
			
			$plugin_headers = get_file_data(__FILE__, array('version' => 'Version', 'Page Name' => 'Page Name'));
			$this->plugin_version = $plugin_headers['version'];
			
			if (function_exists('register_activation_hook')) {
				
				register_activation_hook(__FILE__, array($this,'register_activation_hook'));
				
			}
			
			if (function_exists('register_deactivation_hook')) {
				
				#register_deactivation_hook(__FILE__, array($this,'deactivation'));
				register_deactivation_hook(__FILE__, array($this, 'deactivation_event'));
				
			}
			
			if (isset($_GET['key']) && isset($_GET['calendar']) && isset($_GET['month']) && isset($_GET['day']) && isset($_GET['year'])) {
				
				$expire = date('U') + (30 * 24 * 3600);
				setcookie($this->prefix.'accountKey', intval($_GET['calendar']), $expire);
				
			}
			
			add_filter( 'locale', array($this, 'plugin_localized'));
			#add_filter('pre_user_email', array($this, 'pre_user_email'));
			
			$pluginName = $this->plugin_name;
			$test = load_plugin_textdomain($pluginName, false, dirname( plugin_basename( __FILE__ ) ).'/languages');
			
			add_action('wp_dashboard_setup', array($this, 'add_dashboard_widget'));
			add_action('admin_menu', array($this, 'add_pages'));
			add_action('profile_update', array($this, 'update_user_profile'));
			add_action('personal_options_update', array($this, 'update_user_profile'));
			add_action('user_register', array($this, 'regist_user'));
			add_action('delete_user', array($this, 'delete_user'));
			add_action('wp_before_admin_bar_render', array($this, 'admin_toolbar'));
			
			add_action('admin_bar_menu', array($this, 'admin_bar_menu'), 100);
			add_action('wp_ajax_'.$this->action_control, array($this, 'wp_ajax_booking_package'));
			add_action('wp_ajax_nopriv_'.$this->action_control, array($this, 'wp_ajax_booking_package'));
			add_action('wp_ajax_'.$this->action_public, array($this, 'wp_ajax_booking_package_for_public'));
			add_action('wp_ajax_nopriv_'.$this->action_public, array($this, 'wp_ajax_booking_package_for_public'));
			add_action('widgets_init', array($this, 'register_widget'));
			add_action('load-plugins.php', array($this, 'load_plugins'));
			add_action('login_enqueue_scripts', array($this, 'login_enqueue_scripts'));
			add_filter('login_headerurl', array($this, 'login_headerurl'));
			add_filter('login_headertext', array($this, 'login_headertext'));
			
			if (is_admin() === false) {
				
				add_shortcode('booking_app', array($this, 'bookingPageForVisitors'));
				add_shortcode('booking_package', array($this, 'bookingPageForVisitors'));
				
			}
			
			add_filter('widget_text', 'do_shortcode');
			add_filter('login_errors', array($this, 'login_errors'));
			add_filter('cron_schedules', array($this, 'cron_interval'));
			add_action('retry_to_send_to_server', array($this, 'retry_to_send_to_server'));
			if (!wp_next_scheduled('retry_to_send_to_server')) {
				
				wp_schedule_event(time(), 'retry_to_send_to_server_thirty_minutes', 'retry_to_send_to_server');
				
			}
			
			if (function_exists('wp_insert_site')) {
				
				add_action('wp_insert_site', array($this, 'wp_insert_site'));
				
			} else {
				
				add_action('wpmu_new_blog', array($this, 'wpmu_new_blog'), 10, 6);
				
			}
			
			if (function_exists('wp_delete_site')) {
				
				add_action('wp_delete_site', array($this, 'wp_delete_site'));
				
			} else {
				
				add_action('delete_blog', array($this, 'delete_blog'), 10, 6);
				
			}
			
			if (isset($_GET['ical'])) {
				
				add_action('init', array($this, 'ical_feeds'));
				
			}
			
			/**
			if (isset($_GET['webhook']) || isset($_POST['webhook'])) {
				
				add_action('init', array($this, 'webhook'));
				
			}
			
			if(isset($_POST['app']) || isset($_GET['app'])){
				
				add_action('init', array($this, 'app'));
				
			}
			**/
			if(isset($_POST['mode']) && $_POST['mode'] == 'booking_package_getDownloadCSV'){
				
				add_action('admin_init', array($this, 'getDownloadCSV'));
				
			}
			
		}
		
		
		public function plugin_localized($locale){
			
			if(isset($_POST['locale'])){
				
				$this->locale = sanitize_text_field($_POST['locale']);
				return sanitize_text_field($_POST['locale']);
				
			}
			
			if(isset($_GET['locale'])){
				
				$this->locale = sanitize_text_field($_GET['locale']);
				return sanitize_text_field($_GET['locale']);
				
			}
			
			$this->locale = $locale;
			return $locale;
			
		}
		
		public function register_activation_hook() {
			
			$this->create_database();
			
		}
		
		public function create_database($activation = true){
			
			#require_once(get_home_path() . 'wp-admin/includes/upgrade.php');
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Database.php');
			
			add_option($this->prefix."javascriptSyntaxErrorNotification", 1);
			$database = new booking_package_database($this->prefix, $this->db_version);
			$database->create();
			if ($activation === true) {
				
				$setting = new booking_package_setting($this->prefix, $this->plugin_name);
				$setting->activation(BOOKING_PACKAGE_EXTENSION_URL, "activation", $this->plugin_version);
				
			}
			
			$this->createFirstCalendar();
			
		}
		
		public function upgrader_process(){
			
			$key = $this->prefix."version";
			$now_version = get_option($key, 0);
			if($now_version == 0){
				
				add_option($key, $this->plugin_version);
				
			}else{
				
				if($this->plugin_version != $now_version){
					
					update_option($key, $this->plugin_version);
					require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
					$setting = new booking_package_setting($this->prefix, $this->plugin_name);
					$setting->activation(BOOKING_PACKAGE_EXTENSION_URL, "upgrader", $this->plugin_version);
					
				}
				
			}
			
		}
		
		public function update_database(){
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Database.php');
			
			$this->setHomePath();
			$this->update_memberAccount();
			$installed_ver = get_option($this->prefix."db_version");
			if($installed_ver != $this->db_version){
				
				#$this->create_database(true, false);
				$database = new booking_package_database($this->prefix, $this->db_version);
				$database->create();
				update_option($this->prefix."db_version", $this->db_version);
				if($installed_ver < $this->db_version && $this->db_version == "0.1.7"){
					
					require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
					$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
					$schedule->changeMaxAccountScheduleDay();

				}
				
			}
			
		}
		
		public function update_memberAccount(){
			
			$memberRoleName = $this->memberRoleName;
			if(is_null(get_role($memberRoleName))){
				
				$roleArray = array('read' => true, 'level_0' => true, 'booking_package' => true);
				$object = add_role($memberRoleName, 'Booking Package', $roleArray);
				
			}else{
				
				$object = get_role($memberRoleName);
				
			}
			
		}
		
		public function load_plugins() {
			
			$bool = true;
			if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
				
				include_once(ABSPATH . 'wp-admin/includes/plugin.php');
				include_once(ABSPATH . 'wp-includes/ms-functions.php');
				if (is_plugin_active_for_network('booking-package/index.php') === true) {
					
					$bool = false;
					
				}
			
			}
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			if ($bool === true) {
				
				$setting = new booking_package_setting($this->prefix, $this->plugin_name);
	            $isExtensionsValid = $setting->extensionFunction(false);
				if ($isExtensionsValid === true) {
					
					$dictionary = array(
						'You currently have a valid subscription. Do you want to deactivate the Booking Package?' => __('You currently have a valid subscription. Do you want to deactivate the Booking Package?', $this->plugin_name),
					);
					$localize_script = array(
						'url' => admin_url('admin-ajax.php'), 
						'action' => $this->action_control, 
						'nonce' => wp_create_nonce($this->action_control."_ajax"), 
						'prefix' => $this->prefix,
						'year' => date('Y'), 
						'month' => date('m'), 
						'day' => date('d'), 
						'isExtensionsValid' => $isExtensionsValid,
						'debug' => $this->dubug_javascript,
						'pluginName' => $this->plugin_name,
						'general_setting_url' => admin_url('admin.php?page=booking-package_setting_page&tab=subscriptionLink'), 
					);
					
					$p_v = "?p_v=".$this->plugin_version;
					wp_enqueue_style( 'Control.css', plugin_dir_url( __FILE__ ) . 'css/Control.css', array(), $this->plugin_version);
					wp_enqueue_style( 'Control_for_madia_css', plugin_dir_url( __FILE__ ) . 'css/Control_for_madia.css', array(), $this->plugin_version);
					$fontFaceStyle = $this->getFontFaceStyle();
		            wp_add_inline_style("Control.css", $fontFaceStyle);
					
					wp_enqueue_script( 'i18n_js', plugin_dir_url( __FILE__ ).'js/i18n.js'.$p_v);
					wp_enqueue_script('Delete_Plugin_js', plugin_dir_url( __FILE__ ) . 'js/Delete_plugin.js', array(), $this->plugin_version);
					wp_localize_script('Delete_Plugin_js', $this->prefix.'dictionary', $dictionary);
					wp_localize_script('Delete_Plugin_js', 'delete_plugin_data', $localize_script);
					
				}
				
			}
			
		}
		
		public function update_user_profile($user_id){
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
			/**
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			$isExtensionsValid = $setting->extensionFunction();
			$memberSetting = $setting->getMemberSetting($isExtensionsValid);
			if(user_can($user_id, $this->prefix.'member') === true || (user_can($user_id, 'subscriber') === true && intval($memberSetting['accept_subscribers_as_users']['value']) == 1)){
				
				$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
            	$schedule->update_email($user_id);
				
			}
            **/
            $schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
            $schedule->update_email($user_id);

		}
		
		public function regist_user($user_id){
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			$isExtensionsValid = $setting->extensionFunction();
			$memberSetting = $setting->getMemberSetting($isExtensionsValid);
			$find = false;
			if (user_can($user_id, 'subscriber') === true && intval($memberSetting['accept_subscribers_as_users']['value']) == 1) {
				
				$find = true;

			} else if (user_can($user_id, 'contributor') === true && intval($memberSetting['accept_contributors_as_users']['value']) == 1) {
				
				$find = true;

			}/** else if (user_can($user_id, 'author') === true && intval($memberSetting['accept_authors_as_users']['value']) == 1) {
				
				$find = true;

			}**/
			
			if ($find === true) {
				
				$user = get_user_by('id', $user_id);
				$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
				$schedule->find_users($user_id, 1, true);
				
			}
			
		}
		
		
		
		public function delete_user($user_id){
			
			#echo plugin_dir_path( __FILE__ );
			require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/CreditCard.php');
            $schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
            $schedule->deleteForPluginUser($user_id);

		}
		
		public function login_enqueue_scripts() {
			
			if (isset($_GET['plugin']) && $_GET['plugin'] == 'booking-package') {
				
				require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
				$setting = new booking_package_setting($this->prefix, $this->plugin_name);
				$setting->getCss("front_end.css", plugin_dir_path( __FILE__ ));
				$front_end_url = $setting->getCssUrl("front_end.css");
	            wp_enqueue_style( 'front_end_url', $front_end_url['dirname'], array(), $front_end_url['v']);
	            
	            $isExtensionsValid = $setting->extensionFunction(false);
				if ($isExtensionsValid === true) {
					
					$setting->getJavaScript("front_end.js", plugin_dir_path( __FILE__ ));
					$front_end_javascript_url = $setting->getJavaScriptUrl("front_end.js");
					wp_enqueue_script('front_end_javascript_url', $front_end_javascript_url['dirname'], array(), $front_end_javascript_url['v']);
					
				}
				
			}
			
		}
		
		public function login_headerurl() {
			
			if (isset($_GET['plugin']) && $_GET['plugin'] == 'booking-package') {
				
				return home_url();
				
			}
			
		}
		
		public function login_headertext() {
			
			if (isset($_GET['plugin']) && $_GET['plugin'] == 'booking-package') {
				
				return get_bloginfo('name');
				
			}
			
		}
		
		public function login_errors($error) {
			
			if (isset($_POST['redirect_to']) && isset($_POST['pluginName']) && $_POST['pluginName'] == 'booking-package') {
				
				global $errors;
				$err_codes = $errors->get_error_codes();
				if (in_array('invalid_email', $err_codes)) {
					
					$error = __('E-mail or password you entered is incorrect.', $this->plugin_name);
					
				} else if (in_array('invalid_username', $err_codes)) {
					
					$error = __('Username or password you entered is incorrect.', $this->plugin_name);
					
				} else if (in_array('incorrect_password', $err_codes)) {
					
					$error = __('Username or password you entered is incorrect.', $this->plugin_name);
					
				} else {
					
					$error = __('Unknown error.', $this->plugin_name);
					
				}
				
				$query = "?".$this->prefix."login_error=".$error;
	        	$redirect_to = $_POST['redirect_to'];
	        	$parse = parse_url($redirect_to);
	        	if (isset($parse['query'])) {
	        		
	        		$query = $parse['query']."&".$this->prefix."login_error=".$error;
	        		$redirect_to = $parse['scheme']."://".$parse['host'].$parse['path']."?".$query;
	        		
	        	} else {
	        		
	        		$redirect_to .= $query;
	        		
	        	}
	        	
	        	if (function_exists('urldecode')) {
	        		
	        		$redirect_to = urldecode($redirect_to);
	        		
	        	}
	        	
				header('Location: '.$redirect_to);
				die();
				
			}
			
			return $error;
		}
		
		public function admin_toolbar(){
			
			global $wp_admin_bar;
			#var_dump($wp_admin_bar);
			#print "test";
			
		}
		
		public function admin_bar_menu($wp_admin_bar){
			
			#var_dump($wp_admin_bar);
			$roleName = $this->prefix.'member';
			if (current_user_can($roleName) === false && current_user_can('subscriber') === false && current_user_can('contributor') === false && current_user_can('author') === false) {
				
				wp_enqueue_style( 'Control.css', plugin_dir_url( __FILE__ ).'css/Control.css', array(), $this->plugin_version);
				$title = '<span class="top_toolbar_icon"></span><span>'.__("Booking Package", $this->plugin_name).'</span>';
				$plugin_top_bar = $this->plugin_name.'_top_bar';
				$args = array(
								"id" => $plugin_top_bar,
								"meta" => array(), 
								'title' => $title,
								'href' => admin_url("admin.php?page=".$this->plugin_name."/index.php")
							);
							
				$wp_admin_bar->add_node($args);
				$args = array(
								"id" => $plugin_top_bar."_report",
								"parent" => $plugin_top_bar, 
								"meta" => array(), 
								'title' => __('Report & Booking', $this->plugin_name),
								'href' => admin_url("admin.php?page=".$this->plugin_name."/index.php")
							);
							
				$wp_admin_bar->add_node($args);
				
				$args = array(
								"id" => $plugin_top_bar."_members",
								"parent" => $plugin_top_bar, 
								"meta" => array(), 
								'title' => __('Users', $this->plugin_name),
								'href' => admin_url("admin.php?page=".$this->plugin_name."_members_page")
							);
				$wp_admin_bar->add_node($args);
				
				$args = array(
								"id" => $plugin_top_bar."_schedule",
								"parent" => $plugin_top_bar, 
								"meta" => array(), 
								'title' => __('Calendar Setting', $this->plugin_name),
								'href' => admin_url("admin.php?page=".$this->plugin_name."_schedule_page")
							);
				$wp_admin_bar->add_node($args);
				
				$args = array(
								"id" => $plugin_top_bar."_setting",
								"parent" => $plugin_top_bar, 
								"meta" => array(), 
								'title' => __('General Setting', $this->plugin_name),
								'href' => admin_url("admin.php?page=".$this->plugin_name."_setting_page")
							);
				$wp_admin_bar->add_node($args);
				
			}
			
			
		}
		
		public function register_widget(){
			
			register_widget('booking_package_widget');
			
		}
		
		public function add_pages() {
			
			require_once(plugin_dir_path( __FILE__ ) . 'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ) . 'lib/Schedule.php');
			/**
			if (function_exists('get_sites') && class_exists('WP_Site_Query') && defined('SITE_ID_CURRENT_SITE')) {
				
				switch_to_blog(SITE_ID_CURRENT_SITE);
				$upload_dir = wp_upload_dir();
				$filePath = $upload_dir['basedir'] . '/booking-package/siteNetwork.php';
				if (!file_exists($filePath)) {
					
					$source = file_get_contents(plugin_dir_path( __FILE__ ) . 'lib/siteNetwork.php');
					file_put_contents($filePath, $source);
					
				}
				
				require_once($filePath);
				$siteNetwork = new Booking_package_siteNetwork();
				$this->siteNetwork = $siteNetwork->getSiteNetwork();
				restore_current_blog();
				
			}
			**/
			$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			$response = $schedule->get_user();
			if ($response['status'] == 1 && intval($response['user']['user_toolbar']) != 1) {
				
				$url = site_url();
				header('Location:' . $url);
				return null;
				
			}
			
			$plugin_name = $this->plugin_name.'_admin';
			
			add_menu_page($plugin_name, __('Booking Package', $this->plugin_name), 'manage_categories', __FILE__, array($this,'adomin'), 'dashicons-calendar-alt', 26);
			add_submenu_page(__FILE__, $plugin_name, __('Report & Booking', $this->plugin_name),  'manage_categories', __FILE__, array($this,'adomin'));
			add_submenu_page(__FILE__, $plugin_name, __('Users', $this->plugin_name),  'manage_categories', $this->plugin_name.'_members_page', array($this,'members_page'));
			$schedule_page = add_submenu_page(__FILE__, $plugin_name, __('Calendar Setting', $this->plugin_name),  'manage_categories', $this->plugin_name.'_schedule_page', array($this,'schedule_page'));
			add_submenu_page(__FILE__, $plugin_name, __('General Setting', $this->plugin_name),  'manage_categories', $this->plugin_name.'_setting_page', array($this,'setting_page'));
			if ($this->siteNetwork == 1) {
				
				if(function_exists('get_sites') && class_exists('WP_Site_Query')){
					
					include_once(ABSPATH.'wp-admin/includes/plugin.php');
					$id = get_current_blog_id();
					if (ms_site_check() === true && is_plugin_active_for_network('booking-package/index.php') === true && intval($id) != intval(SITE_ID_CURRENT_SITE)) {
						
						$this->is_owner_site = 0;
						add_submenu_page(__FILE__, $plugin_name, __('Subscription', $this->plugin_name),  'manage_network', $this->plugin_name.'_subscription_page', array($this,'subscription_page'));
						
					}
					
				}
				
			}
			#add_submenu_page(__FILE__, $plugin_name, __('Subscription', $this->plugin_name),  'manage_categories', $this->plugin_name.'_subscription_page', array($this,'subscription_page'));
			#$this->is_owner_site = 0;
			
			add_action('load-'.$schedule_page, array($this, 'help_schedule_page'));
			
		}
		
		public function add_dashboard_widget(){
			
			#var_dump(wp_get_current_user());
			#$userId = get_currentuserinfo();
			if(current_user_can("administrator") === true || current_user_can("editor") === true){
				
				wp_add_dashboard_widget($this->plugin_name, 'Booking Package', array($this, 'dashboard_widget_function'));
			
				global $wp_meta_boxes;
				$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
				$example_widget_backup = array($this->plugin_name => $normal_dashboard[$this->plugin_name]);
				unset($normal_dashboard[$this->plugin_name]);
				$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);
				$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
				
			}
			
		}
		
		public function dashboard_widget_function(){
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
			$pluginName = $this->plugin_name;
			$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
			$calendarAccountList = $schedule->getCalendarAccountListData("`key`,`name`,`type`,`status`");
			$newCalendarAccountList = array();
			for($i = 0; $i < count($calendarAccountList); $i++){
				
				$newCalendarAccountList[$calendarAccountList[$i]['key']] = $calendarAccountList[$i];
				
			}
			
			$calendarAccountList = $newCalendarAccountList;
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			$list = $setting->getList();
			$emailMessageList = $setting->getEmailMessage(array('enable'));
			$dateFormat = get_option($this->prefix."dateFormat", "0");
			$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
			
			$list['General'][$this->prefix . 'clock']['value'] = $this->changeTimeFormat($list['General'][$this->prefix . 'clock']['value']);
			
			$dictionary = $this->getDictionary("adomin", $this->plugin_name);
			$localize_script = array(
				'url' => admin_url('admin-ajax.php'), 
				'action' => $this->action_control, 
				'nonce' => wp_create_nonce($this->action_control."_ajax"), 
				'prefix' => $this->prefix,
				'courseBool' => 0, 
				'courseName' => "", 
				'year' => date('Y'), 
				'month' => date('m'), 
				'day' => date('d'), 
				'locale' => get_locale(),
				'courseList' => array(), 
				'currency' => 'usd',
				'dateFormat' => $dateFormat,
				'positionOfWeek' => $positionOfWeek,
				'emailEnable' => $emailMessageList,
				'bookingBool' => 0,
				'calendarAccountList' => $calendarAccountList,
				'error_url' => BOOKING_PACKAGE_EXTENSION_URL,
				'debug' => $this->dubug_javascript,
				'clock' => $list['General']['booking_package_clock']['value'],
			);
			
			$p_v = "?p_v=".$this->plugin_version;
			wp_enqueue_style( 'Control.css', plugin_dir_url( __FILE__ ).'css/Control.css', array(), $this->plugin_version);
			wp_enqueue_style( 'Control_for_madia_css', plugin_dir_url( __FILE__ ).'css/Control_for_madia.css', array(), $this->plugin_version);
			wp_enqueue_script( 'Error_js', plugin_dir_url( __FILE__ ).'js/Error.js'.$p_v);
			wp_enqueue_script( 'i18n_js', plugin_dir_url( __FILE__ ).'js/i18n.js'.$p_v);
			wp_enqueue_script( 'Confirm_js', plugin_dir_url( __FILE__ ).'js/Confirm.js'.$p_v);
			wp_enqueue_script( 'XMLHttp_js', plugin_dir_url( __FILE__ ).'js/XMLHttp.js'.$p_v);
			wp_enqueue_script( 'Calendar_js', plugin_dir_url( __FILE__ ).'js/Calendar.js'.$p_v);
			wp_enqueue_script( 'Reservation_manage_js', plugin_dir_url( __FILE__ ).'js/Reservation_manage.js'.$p_v);
			wp_localize_script('Reservation_manage_js', 'schedule_data', $localize_script);
			wp_localize_script('Reservation_manage_js', $this->prefix.'dictionary', $dictionary);
			
			print "<div id='booking_pacage_dashboard_widget'>";
			
			$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
			$unixTime = date('U');
			$today = $schedule->dateFormat($dateFormat, date('w'), $unixTime, null, null);
			$lists = $schedule->getReservationUsersData(date('n', $unixTime), date('j', $unixTime), date('Y', $unixTime));
			$this->visitorsList($today, $unixTime, $calendarAccountList, $lists, $schedule);
			
			$unixTime += 1440 * 60;
			$nextDay = $schedule->dateFormat($dateFormat, date('w', $unixTime), $unixTime, null, null);
			$lists = $schedule->getReservationUsersData(date('n', $unixTime), date('j', $unixTime), date('Y', $unixTime));
			$this->visitorsList($nextDay, $unixTime, $calendarAccountList, $lists, $schedule);
			
			print "</div>";
			
			?>
			<div id="blockPanel" class="edit_modal_backdrop hidden_panel"></div>
			<div id="dialogPanel" class="hidden_panel">
				<div class="blockPanel"></div>
				<div class="confirmPanel">
					<div class="subject"><?php _e("Title", $pluginName); ?></div>
					<div class="body"><?php _e("Message", $pluginName); ?></div>
					<div class="buttonPanel">
						<button id="dialogButtonYes" type="button" class="yesButton button button-primary"><?php _e("Yes", $pluginName); ?></button>
						<button id="dialogButtonNo" type="button" class="noButton button button-primary"><?php _e("No", $pluginName); ?></button>
					</div>
				</div>
			</div>
			<!--
			<div id="loadingPanel" class="loading_modal_backdrop hidden_panel"><img src="<?php print plugin_dir_url( __FILE__ ); ?>images/loading_0.gif"></div>
			-->
			<div id="loadingPanel" class="hidden_panel">
				<div class="loader">
					<svg viewBox="0 0 64 64" width="64" height="64">
						<circle id="spinner" cx="32" cy="32" r="28" fill="none"></circle>
					</svg>
				</div>
			</div>
			<?php
		}
		
		public function visitorsList($date, $unixTime, $calendarAccountList, $lists, $schedule){
			
			$dateFormat = get_option($this->prefix."dateFormat", "0");
			$clock = get_option($this->prefix."clock", '24hours');
			$clock = $this->changeTimeFormat($clock);
			$url = admin_url("admin.php?page=".$this->plugin_name."/index.php");
			print "<div class='title'>".$date."</div>";
			$i = 0;
			foreach ((array) $lists as $key => $value) {
				
				if(isset($calendarAccountList[$key])){
					
					$i++;
					print "<div class='calendarName'>".$calendarAccountList[$key]['name']."</div>";
					print "<ul class=''>";
					for($i = 0; $i < count($value); $i++){
						
						$this->showVisitorsList($value[$i], $url, $calendarAccountList[$key]['type'], $schedule, $dateFormat, $clock);
						
					}
					
					print "</ul>";
					
				}
				
			}
			
			if($i == 0){
				
				print "<div class='calendarName'>".__('No visitors', $this->plugin_name)."</div>";
				
			}
			
		}
		
		public function showVisitorsList($visitor, $url, $calendarType, $schedule, $dateFormat, $clock = '24hours'){
			
			$date = null;
			$visitor['date'] = array('month' => date('n', $visitor['scheduleUnixTime']), 'year' => date('Y', $visitor['scheduleUnixTime']));
			if($calendarType == 'day'){
				
				$date = date('H:i', $visitor['scheduleUnixTime']) . ' ' . $visitor['courseName'];
				if ($clock == '12a.m.p.m') {
					
					$hour = intval(date('G', $visitor['scheduleUnixTime']));
					$print_am_pm = 'a.m.';
					if ($hour >= 12) {
						
						$print_am_pm = 'p.m.';
					
					}
					
					$date = sprintf(__('%s:%s ' . $print_am_pm, $this->plugin_name), date('h', $visitor['scheduleUnixTime']), date('i', $visitor['scheduleUnixTime'])) . ' ' . $visitor['courseName'];

				} else if ($clock == '12ampm') {
					
					$hour = intval(date('G', $visitor['scheduleUnixTime']));
					$print_am_pm = 'am';
					if ($hour >= 12) {
						
						$print_am_pm = 'pm';
					
					}
					
					$date = sprintf(__('%s:%s ' . $print_am_pm, $this->plugin_name), date('h', $visitor['scheduleUnixTime']), date('i', $visitor['scheduleUnixTime'])) . ' ' . $visitor['courseName'];

				} else if ($clock == '12AMPM') {
					
					$hour = intval(date('G', $visitor['scheduleUnixTime']));
					$print_am_pm = 'AM';
					if ($hour >= 12) {
						
						$print_am_pm = 'PM';
					
					}
					
					$date = sprintf(__('%s:%s ' . $print_am_pm, $this->plugin_name), date('h', $visitor['scheduleUnixTime']), date('i', $visitor['scheduleUnixTime'])) . ' ' . $visitor['courseName'];

				}
				
			}else if($calendarType == 'hotel'){
				
				$checkIn = $visitor['accommodationDetails']['checkIn'];
				$checkOut = $visitor['accommodationDetails']['checkOut'];
				#$date = $schedule->dateFormat($dateFormat, date('w', $checkIn), $checkIn, null, false, true)." - ";
				#$date .= $schedule->dateFormat($dateFormat, date('w', $checkOut), $checkOut, null, false, true);
				$date = sprintf(__('Until %s', $this->plugin_name), $schedule->dateFormat($dateFormat, date('w', $checkOut), $checkOut, null, false, true));
			}
			
			$url .= "&key=".intval($visitor['key'])."&calendar=".intval($visitor['accountKey'])."&month=".intval(date('n', $visitor['scheduleUnixTime']))."&day=".intval(date('j', $visitor['scheduleUnixTime']))."&year=".intval(date('Y', $visitor['scheduleUnixTime']));
			$praivateData = $visitor['praivateData'];
			$name = array();
			for($i = 0; $i < count($praivateData); $i++){
				
				if(isset($praivateData[$i]['isName']) && $praivateData[$i]['isName'] == 'true'){
					
					array_push($name, $praivateData[$i]['value']);
					
				}
				
			}
			
			$name = strtoupper(implode(' ', $name));
			?>
			
			<li class=''>
				<div class='date'><?php print $date; ?></div>
				<!--
				<div onClick='changeStatusForDashboard(this, <?php print json_encode($visitor); ?>)' class='status <?php print $visitor['status']; ?>'><?php print __(strtoupper($visitor['status']), $this->plugin_name); ?></div>
				
				<div style="cursor: text;" class='status <?php print $visitor['status']; ?>'><?php print __(strtoupper($visitor['status']), $this->plugin_name); ?></div>
				-->
				<div onClick='changeStatusForDashboard(this, <?php print $visitor['key']; ?>, <?php print $visitor['accountKey']; ?>, "<?php print $visitor['status']; ?>", <?php print $visitor['date']['month']; ?>, 1, <?php print $visitor['date']['year']; ?>)' class='status <?php print $visitor['status']; ?>'><?php print __(strtoupper($visitor['status']), $this->plugin_name); ?></div>
				<div class='name'><a href='<?php print $url; ?>'><?php print $name; ?></a></div>
			</li>
			
			<?php
		}
		
		
		
		public function bookingPageForVisitors($atts){
			
			$load_start_time = microtime(true);
			$atts = extract(shortcode_atts(array('id' => 1, 'locale' => null), $atts, "booking_package"));
			$accountKey = $id;
			$this->upgrader_process();
			$pluginName = $this->plugin_name;
			
			if (isset($locale) && !empty($locale)) {
				
				#var_dump($locale);
				
			}
			
            $p_v = "?p_v=".$this->plugin_version;
            wp_enqueue_style( 'booking_app_js_css', plugin_dir_url( __FILE__ ).'css/Booking_app.css', array(), $this->plugin_version);
            #wp_enqueue_style('https://fonts.googleapis.com/icon?family=Material+Icons');
			$fontFaceStyle = $this->getFontFaceStyle();
            wp_add_inline_style("booking_app_js_css", $fontFaceStyle);
            
            $this->update_database();
            require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
            require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
            require_once(plugin_dir_path( __FILE__ ).'lib/CreditCard.php');
            require_once(plugin_dir_path( __FILE__ ).'lib/Html.php');
			
            $setting = new booking_package_setting($this->prefix, $this->plugin_name);
            $schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
            $isExtensionsValid = $setting->extensionFunction(false);
            $calendarAccount = $schedule->getCalendarAccount($accountKey, $isExtensionsValid);
            if ($calendarAccount === false) {
            	
            	echo '<div class="calendarNotFound">';
            	_e('Booking calendar was not found.', $this->plugin_name);
            	echo '</div>';
            	return null;
            	
            }
            
			$deleteKeys = array("googleCalendarID", "idForGoogleWebhook", "expirationForGoogleWebhook", "ical", "icalToken", "email_from", "email_from_title", "email_to", "email_to_title");
			for ($i = 0; $i < count($deleteKeys); $i++) {
				
				if (!empty($deleteKeys[$i]) && isset($calendarAccount[$deleteKeys[$i]])) {
					
					unset($calendarAccount[$deleteKeys[$i]]);
					
				}
				
			}
			
			date_default_timezone_set($calendarAccount['timezone']);
			if (empty($calendarAccount['courseTitle'])) {
				
				$calendarAccount['courseTitle'] = __('Service', $pluginName);
				
			}
			
            $htmlElement = new booking_package_HTMLElement($this->prefix, $this->plugin_name);
            
			$list = $setting->getList();
			
			$setting->getCss("front_end.css", plugin_dir_path( __FILE__ ));
			$front_end_url = $setting->getCssUrl("front_end.css");
            wp_enqueue_style( 'front_end_url', $front_end_url['dirname'], array(), $front_end_url['v']);
			
			if ($isExtensionsValid === true) {
				
				$setting->getJavaScript("front_end.js", plugin_dir_path( __FILE__ ));
				$front_end_javascript_url = $setting->getJavaScriptUrl("front_end.js");
				wp_enqueue_script('front_end_javascript_url', $front_end_javascript_url['dirname'], array(), $front_end_javascript_url['v']);
				
			} else {
				
				$calendarAccount['hasMultipleServices'] = 0;
				$calendarAccount['maximumNights'] = 0;
				$calendarAccount['minimumNights'] = 0;
				
			}
			
			#$memberSetting = array_merge($setting->getMemberSettingValues(), array('current_member_id' => 0, 'login' => 0));
			$member_login_error = 0;
			$member_form = '';
			$wq_login_form = '';
			$wp_register = '';
			$userId = 0;
			if(isset($_GET['k']) && isset($_GET['u']) && isset($_GET['mode']) && $_GET['mode'] == 'activation'){
				
				$key = sanitize_text_field($_GET['k']);
				$user_login = sanitize_text_field($_GET['u']);
				$memberSetting['activation'] = $schedule->setActivationUser($key, $user_login, 1);
				
			}
			
			$userLogin = false;
			$user = $schedule->get_user();
			if (intval($user['status']) == 1) {
				
				$userLogin = true;
				$memberSetting = $user['user'];
				
			} else {
				
				$memberSetting = $user['user'];
				if (isset($user['user']['message'])) {
					
					$member_login_error = $user['user']['message'];
					
				}
				
			}
			
			$cancellationOfBooking = 0;
			if (isset($_GET['bookingID']) && isset($_GET['bookingToken'])) {
				
				$bookingDetailsResponse = $schedule->getBookingDetailsOnVisitor($_GET['bookingID'], $_GET['bookingToken']);
				if ($bookingDetailsResponse['status'] == 'success') {
					
					$myBookingDetails = $bookingDetailsResponse['details'];
					$myBookingDetails['courseTitle'] = $calendarAccount['courseTitle'];
					unset($myBookingDetails['iCalUIDforGoogleCalendar']);
					unset($myBookingDetails['iCalIDforGoogleCalendar']);
					unset($myBookingDetails['resultOfGoogleCalendar']);
					unset($myBookingDetails['resultModeOfGoogleCalendar']);
					unset($myBookingDetails['payToken']);
					
					$verifyCancellation = $schedule->verifyCancellation($myBookingDetails, $isExtensionsValid, $user['status']);
					if ($verifyCancellation['cancel'] == true) {
						
						$cancellationOfBooking = 1;
						
					}
					/**
					if ($user['status'] == 0) {
						
						$myBookingDetails['praivateData'] = array();
						
					}
					**/
					$myBookingDetails['praivateData'] = array();
					
				}
				
			}
			
			
			#$memberSetting['subscription_list'] = array();
			
			$permalink = get_permalink();
			$login_url = wp_login_url($permalink);
			$member_form = $this->member_form($memberSetting, $member_login_error);
			
			ob_start();
			wp_login_form(array('form_id' => 'booking-package-loginform', 'redirect' => $permalink));
			$wq_login_form = ob_get_contents();
			ob_get_clean();
			
			$formData = $setting->getForm($accountKey, true);
			$guestsList = $setting->getGuestsList($accountKey, true);
			$courseList = $setting->getCourseList($accountKey);
			$target_users = 'users';
			if (isset($user['status']) && intval($user['status']) == 1) {
				
				$target_users = 'visitors';
				
			}
			#var_dump($schedule->get_user_id());
			#var_dump($target_users);
			#var_dump($formData);
			//foreach ((array) $formData as $key => $filed) {
			for ($i = 0; $i < count($formData); $i++) {
				
				if (isset($formData[$i]['targetCustomers'])) {
					
					if ($target_users == 'users' && $formData[$i]['targetCustomers'] == 'users') {
						
						$formData[$i]['active'] = '';
						
					} else if ($target_users == 'visitors' && $formData[$i]['targetCustomers'] == 'visitors') {
						
						$formData[$i]['active'] = '';
						
					}
					
				}
				
			}
			
			$countServices = 0;
			foreach ((array) $courseList as $key => $service) {
				
				if ($service['target'] == $target_users) {
					
					unset($courseList[$key]);
					
				}
				
				if ($service['active'] == 'true') {
					
					$countServices++;
					
				}
				
			}
			
			if ($countServices == 0) {
				
				$calendarAccount['flowOfBooking'] = "calendar";
				
			}
			
			$schedule->deleteOldDaysInSchedules();
			$schedule->insertAccountSchedule(date('m'), date('d'), date('Y'), $accountKey);
			date_default_timezone_set($calendarAccount['timezone']);
			
			if ($calendarAccount['status'] == 'close') {
				
				return '<div id="calendarStatus">'.__('We do not accept reservations for this calendar.', $this->plugin_name).'</div>';
				
			}
			
			$dateFormat = get_option($this->prefix."dateFormat", "0");
			$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
			$courseBool = "false";
			if (intval($calendarAccount["courseBool"]) == 1) {
				
				$courseBool = "true";
				if ($countServices == 0 || $calendarAccount['flowOfBooking'] == 'services') {
					
					$courseBool = "false";
					
				}
				
			} else {
				
				$calendarAccount['flowOfBooking'] = "calendar";
				
			}
			
			$locale = get_locale();
			$dictionary = $this->getDictionary("bookingPageForVisitors", $this->plugin_name);
			
			$localize_script = $this->localizeScript("visitor");
			$localize_script['courseBool'] = $courseBool;
			$localize_script['courseName'] = $calendarAccount["courseTitle"];
			$localize_script['hasMultipleServices'] = $calendarAccount['hasMultipleServices'];
			$localize_script['accountKey'] = $accountKey;
			$localize_script['calendarAccount'] = $calendarAccount;
			$localize_script['courseList'] = $courseList;
			$localize_script['guestsList'] = $guestsList;
			$localize_script['formData'] = $formData;
			$localize_script['enableFixCalendar'] = intval($calendarAccount['enableFixCalendar']);
			$localize_script['memberSetting'] = $memberSetting;
			$localize_script['cancellationOfBooking'] = $cancellationOfBooking;
			$localize_script['isExtensionsValid'] = $isExtensionsValid;
			if (intval($calendarAccount['enableFixCalendar']) == 1) {
				
				$localize_script['month'] = intval($calendarAccount['monthForFixCalendar']) + 1;
				$localize_script['year'] = intval($calendarAccount['yearForFixCalendar']);
				
			}
			
			if (isset($myBookingDetails)) {
				
				$localize_script['myBookingDetails'] = $myBookingDetails;
				
			}
			
			if ($isExtensionsValid === true) {
				
				$localize_script['taxes'] = $setting->getTaxes($accountKey);
				$userSubscriptions = $setting->upgradePlan('get');
				if (is_string($userSubscriptions['customer_id_for_subscriptions'])) {
					
					$localize_script['site_subscriptions'] = substr($userSubscriptions['customer_id_for_subscriptions'], -5);
					
				}
				
			} else {
				
				$localize_script['taxes'] = array();
				
			}
			
			$postPages = array(
				'servicesPostPage' => array('key' => 'servicesPage', 'page' => null), 
				'calendarPostPage' => array('key' => 'calenarPage', 'page' => null), 
				'schedulesPostPage' => array('key' => 'schedulesPage', 'page' => null), 
				'visitorDetailsPostPage' => array('key' => 'visitorDetailsPage', 'page' => null), 
				'thanksPostPage' => array('key' => 'thanksPage', 'page' => null),
			);
			foreach ((array) $postPages as $key => &$value) {
				
				if (!is_null($calendarAccount[$value['key']])) {
					
					$page = get_pages(array('include' => intval($calendarAccount[$value['key']])));
					if (!empty($page)) {
						
						$value['page'] = $page[0]->post_content;
						
					}
					
				}
				
			}
			
			$localize_script['redirectPage'] = null;
			if ($calendarAccount['redirectMode'] == 'page' && !empty($calendarAccount['redirectPage'])) {
				
				$page = get_pages(array('include' => intval($calendarAccount['redirectPage'])));
				if (!empty($page)) {
					
					$localize_script['redirectPage'] = get_page_link($calendarAccount['redirectPage']);
					
				}
				
			} else if($calendarAccount['redirectMode'] == 'url' && !empty($calendarAccount['redirectURL'])) {
				
				$localize_script['redirectPage'] = $calendarAccount['redirectURL'];
				
			}
			
			$accountList = $schedule->getCalendarAccountListData("`key`, `name`, `expressionsCheck`, `type`, `courseTitle`, `includeChildrenInRoom`, `numberOfPeopleInRoom`");
			$localize_script['calendarAccountList'] = $accountList;
			
			/**
			if (intval(get_option($this->prefix."stripe_active", 0)) == 1) {
				
				$stripe_public_key = get_option($this->prefix."stripe_public_key", null);
				if (!is_null($stripe_public_key)) {
					
					$localize_script['stripe_active'] = 1;
					$localize_script['stripe_public_key'] = $stripe_public_key;
					wp_enqueue_script('stripe_checkout_v3_js', 'https://js.stripe.com/v3/');
					
				} else {
					
					$localize_script['stripe_active'] = 0;
					
				}
				
			} else {
				
				$localize_script['stripe_active'] = 0;
				
			}
			
			if(intval(get_option($this->prefix."paypal_active", 0)) == 1){
				
				$paypal_public_key = get_option($this->prefix."paypal_client_id", null);
				if(!is_null($paypal_public_key)){
					
					$localize_script['paypal_active'] = 1;
					$localize_script['paypal_mode'] = intval(get_option($this->prefix."paypal_live", 0));
					$localize_script['paypal_client_id'] = $paypal_public_key;
					wp_enqueue_script('paypal_checkout_v3_js', 'https://www.paypalobjects.com/api/checkout.js');
					
				}else{
					
					$localize_script['paypal_active'] = 0;
					
				}
				
			}else{
				
				$localize_script['paypal_active'] = 0;
				
			}
			**/
			
			$paymentMethod = explode(",", $calendarAccount['paymentMethod']);
			if ((count($paymentMethod) == 1 && strlen($paymentMethod[0]) == 0) || $isExtensionsValid === false) {
				
				$paymentMethod = array('locally');
				
			}
			
			$new_paymentMethod = array();
			for ($i = 0; $i < count($paymentMethod); $i++) {
				
				#var_dump($paymentMethod[$i]);
				if ($paymentMethod[$i] == 'stripe') {
					
					$stripe_public_key = get_option($this->prefix."stripe_public_key", null);
					if (!empty($stripe_public_key)) {
						
						array_push($new_paymentMethod, $paymentMethod[$i]);
						$localize_script['stripe_active'] = 1;
						$localize_script['stripe_public_key'] = $stripe_public_key;
						wp_enqueue_script('stripe_checkout_v3_js', 'https://js.stripe.com/v3/');
						
					} else {
						
						$localize_script['stripe_active'] = 0;
						
					}
					
				} else if ($paymentMethod[$i] == 'paypal') {
					
					$paypal_public_key = get_option($this->prefix."paypal_client_id", null);
					if (!empty($paypal_public_key)) {
						
						array_push($new_paymentMethod, $paymentMethod[$i]);
						$localize_script['paypal_active'] = 1;
						$localize_script['paypal_mode'] = intval(get_option($this->prefix."paypal_live", 0));
						$localize_script['paypal_client_id'] = $paypal_public_key;
						#wp_enqueue_script('paypal_checkout_v3_js', 'https://www.paypalobjects.com/api/checkout.js');
						wp_enqueue_script('paypal_checkout_v4_js', 'https://www.paypal.com/sdk/js?client-id=' . $paypal_public_key . '&currency=' .  strtoupper($localize_script['currency']), array(), null);
						
					} else {
						
						$localize_script['paypal_active'] = 0;
						
					}
					
				} else if ($paymentMethod[$i] == 'locally') {
					
					array_push($new_paymentMethod, $paymentMethod[$i]);
					
				}
				
			}
			
			if (count($new_paymentMethod) == 0) {
				
				$new_paymentMethod = array('locally');
				
			}
			
			$localize_script['paymentMethod'] = $new_paymentMethod;
			
			if (!empty($localize_script['googleAnalytics'])) {
				
				wp_enqueue_script($this->prefix . 'googleAnalytics', 'https://www.googletagmanager.com/gtag/js?id=' . $localize_script['googleAnalytics'], array(), $this->plugin_version);
				
			} else {
				
				unset($localize_script['googleAnalytics']);
				
			}
			
			wp_enqueue_script('Error_js', plugin_dir_url( __FILE__ ).'js/Error.js', array(), $this->plugin_version);
			wp_enqueue_script('i18n_js', plugin_dir_url( __FILE__ ).'js/i18n.js', array(), $this->plugin_version);
			wp_enqueue_script('XMLHttp_js', plugin_dir_url( __FILE__ ).'js/XMLHttp.js', array(), $this->plugin_version);
			wp_enqueue_script('Input_js', plugin_dir_url( __FILE__ ).'js/Input.js', array(), $this->plugin_version);
			wp_enqueue_script('Calendar_js', plugin_dir_url( __FILE__ ).'js/Calendar.js', array(), $this->plugin_version);
			wp_enqueue_script('Hotel_js', plugin_dir_url( __FILE__ ).'js/Hotel.js', array(), $this->plugin_version);
			wp_enqueue_script('Member_js', plugin_dir_url( __FILE__ ).'js/Member.js', array(), $this->plugin_version);
			wp_enqueue_script('Reservation_manage_js', plugin_dir_url( __FILE__ ).'js/Reservation_manage.js', array(), $this->plugin_version);
			wp_enqueue_script('booking_app_js', plugin_dir_url( __FILE__ ).'js/Booking_app.js', array(), $this->plugin_version);
			wp_localize_script('booking_app_js', $this->prefix.'dictionary', $dictionary);
			wp_localize_script('booking_app_js', 'reservation_info', $localize_script);
			
			$howdy = "";
			if (isset($memberSetting['user_login'])) {
				
				$howdy = sprintf(__('Hello, %s', $pluginName), $memberSetting['user_login']);
				
			}
			
			$html = '<div id="booking-package-locale-' . $this->locale . '">';
			$html .= '<div id="booking-package-id-' . $accountKey . '">';
			#$html .= $wp_register;
			$html .= '<div id="booking-package-memberActionPanel" class="hidden_panel">';
			if (isset($_GET[$this->prefix.'login_error'])) {
				
				$html .= "<div id='" . $this->prefix . "login_error' class='login_error'>" . $_GET[$this->prefix.'login_error'] . "</div>";
				
			}
			$html .= '<div class="userTopButtonPanel">';
			$html .= '<label class="displayName">' . $howdy . '</label>';
			$html .= '<a id="booking-package-register" class="register">' . __("Create account", $pluginName) . '</a>';
			$html .= '<a id="booking-package-login" class="login">' . __("Sign in", $pluginName) . '</a>';
			$html .= '<a id="booking-package-logout" class="logout hidden_panel">' . __("Sign out", $pluginName) . '</a>';
			$html .= '<a id="booking-package-edit" class="edit">' . __("Edit My Profile", $pluginName) . '</a>';
			$html .= '<a id="booking-package-bookedHistory" class="edit">' . __("Booking history", $pluginName) . '</a>';
			$html .= '<a id="booking-package-subscribed" class="edit">' . __("Subscribed items", $pluginName) . '</a>';
			$html .= '</div>';
			$html .= $wq_login_form.$member_form . '</div>';
			$html .= $this->subscription_form($localize_script['calendarAccount'], $memberSetting);
			$html .= $htmlElement->myBookingHistory_panel();
			$html .= $htmlElement->myBookingDetails_panel();
			$html .= $htmlElement->cancelBookingDetailsForVisitor_panel();
			$html .= '<div id="booking-package" class="booking-package">';
			
			$html .= '	<div id="' . $this->prefix . 'navigationPage" class="navigationPage">';
			$html .= '		<div id="' . $this->prefix . 'schedulesPostPage" class="hidden_panel">' . $postPages['schedulesPostPage']['page'] . '</div>';
			$html .= '		<div id="' . $this->prefix . 'calendarPostPage" class="hidden_panel">' . $postPages['calendarPostPage']['page'] . '</div>';
			$html .= '		<div id="' . $this->prefix . 'servicesPostPage" class="hidden_panel">' . $postPages['servicesPostPage']['page'] . '</div>';
			$html .= '		<div id="' . $this->prefix . 'visitorDetailsPostPage" class="hidden_panel">' . $postPages['visitorDetailsPostPage']['page'] . '</div>';
			$html .= '		<div id="' . $this->prefix . 'thanksPostPage" class="hidden_panel">' . $postPages['thanksPostPage']['page'] . '</div>';
			$html .= '	</div>';
			$html .= '<div id="booking-package_servicePage" class="hidden_panel"><div class="title borderColor">' . sprintf(__("Please select %s", $pluginName), $calendarAccount["courseTitle"]) . '</div><div class="list borderColor"></div></div>';
			$html .= '<div id="booking-package_serviceDetails" class="hidden_panel"><div class="title borderColor">' . sprintf(__("Your %s details", $pluginName), $calendarAccount["courseTitle"]) . '</div><div class="list borderColor"></div></div>';
			#$html .= '<div id="bookingBlockPanel" class="hidden_panel"><img src="'.plugin_dir_url( __FILE__ ).'images/loading_0.gif"></img></div>';
			$html .= '<div id=""></div>';
			
			
			
			$html .= '	<div id="booking-package_calendarPage" class=""></div>';
			$html .= '	<div id="booking-package_durationStay" class="hidden_panel"></div>';
			$html .= '	<div id="booking-package_schedulePage" class="hidden_panel">';
			$html .= '		<div id="topPanel"></div>';
			$html .= '		<div id="daysListPanel"></div>';
			$html .= '		<div id="courseMainPanel"></div>';
			$html .= '		<div id="optionsMainPanel"></div>';
			$html .= '		<div id="scheduleMainPanel"></div>';
			$html .= '		<div id="blockPanel"></div>';
			$html .= '		<div id="bottomPanel">';
			$html .= '			<button id="returnToCalendarButton">' . __('Return', $pluginName) . '</button>';
			$html .= '			<button id="returnToDayListButton" class="hidden_panel">' . __('Return', $pluginName) . '</button>';
			$html .= '			<button id="returnDayButton" class="hidden_panel"></button>';
			$html .= '			<button id="nextDayButtton" class="hidden_panel"></button>';
			$html .= '			<button id="nextButton" class="right_button hidden_panel">' . __('Next', $pluginName) . '</button>';
			$html .= '		</div>';
			$html .= '	</div>';
			#$html .= '	<div id="booking-package_thanksPanel" class="hidden_panel"></div>';
			$html .= '	<div id="booking-package_inputFormPanel" class="hidden_panel"></div>';
			
			$html .= '</div>';
			$html .= '	<div id="bookingBlockPanel" class="hidden_panel">';
			$html .= '		<div id="bookingBlockPanel" class="">';
			$html .= '			<div class="loader" class="hidden_panel">';
			$html .= '				<svg viewBox="0 0 64 64" width="64" height="64">';
			$html .= '					<circle id="spinner" cx="32" cy="32" r="28" fill="none"></circle>';
			$html .= '				</svg>';
			$html .= '			</div>';
			$html .= '		</div>';
			$html .= '	</div>';
			$html .= '</div>';
			$html .= '</div>';
			
			$style = $this->getStyle($list);
			$html .= $style;
			$load_end_time = microtime(true) - $load_start_time;
			$html .= '<!-- Load time: ' . $load_end_time . ' -->';
			
			return $html;
			
		}
		
		public function subscription_form($calendarAccount, $subscription_form){
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Html.php');
			$htmlElement = new booking_package_HTMLElement($this->prefix, $this->plugin_name);
			$html = $htmlElement->subscription_form($calendarAccount, $subscription_form);
			return $html;
			
		}
		
		public function member_form($user = null, $member_login_error = 0) {
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Html.php');
			$htmlElement = new booking_package_HTMLElement($this->prefix, $this->plugin_name);
			$htmlElement->setVisitorSubscriptionForStripe($this->visitorSubscriptionForStripe);
			$member_form = $htmlElement->member_form($user, $member_login_error);
			return $member_form;
			
		}
		
		public function adomin() {
			
			$load_start_time = microtime(true);
			global $wpdb;
            
			$this->update_database();
			$this->upgrader_process();
			#var_dump(get_current_blog_id());
			require_once(plugin_dir_path( __FILE__ ) . 'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ) . 'lib/Webhook.php');
            require_once(plugin_dir_path( __FILE__ ) . 'lib/Schedule.php');
            
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			if (isset($_GET['mode']) && $_GET['mode'] == 'upgradePlan') {
				
				$response = $setting->upgradePlan($_GET['type']);
				$response = $setting->extensionFunction(false);
				
			}
			
			
			$timeMin = date('U') - (7 * 24 * 60 * 60);
            
            $webhook = new booking_package_webhook($this->prefix, $this->plugin_name);
            
            $schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
            $schedule->deleteOldDaysInSchedules();
            $isExtensionsValid = $setting->extensionFunction();
            $dictionary = $this->getDictionary("adomin", $this->plugin_name);
            $localize_script = $this->localizeScript('adomin');
            $localize_script['isExtensionsValid'] = 0;
            if ($isExtensionsValid === true) {
            	
            	$localize_script['isExtensionsValid'] = 1;
            	
            }
            $p_v = "?p_v=".$this->plugin_version;
			wp_enqueue_style( 'Control.css', plugin_dir_url( __FILE__ ) . 'css/Control.css', array(), $this->plugin_version);
			wp_enqueue_style( 'Control_for_madia_css', plugin_dir_url( __FILE__ ) . 'css/Control_for_madia.css', array(), $this->plugin_version);
			$fontFaceStyle = $this->getFontFaceStyle();
            wp_add_inline_style("Control.css", $fontFaceStyle);
            wp_enqueue_script('Error_js', plugin_dir_url( __FILE__ ) . 'js/Error.js', array(), $this->plugin_version);
			wp_enqueue_script('i18n_js', plugin_dir_url( __FILE__ ) . 'js/i18n.js', array(), $this->plugin_version);
			wp_enqueue_script('XMLHttp_js', plugin_dir_url( __FILE__ ) . 'js/XMLHttp.js', array(), $this->plugin_version);
			wp_enqueue_script('Confirm_js', plugin_dir_url( __FILE__ ) . 'js/Confirm.js', array(), $this->plugin_version);
			wp_enqueue_script('Input_js', plugin_dir_url( __FILE__ ) . 'js/Input.js', array(), $this->plugin_version);
			wp_enqueue_script('Calendar_js', plugin_dir_url( __FILE__ ) . 'js/Calendar.js', array(), $this->plugin_version);
			wp_enqueue_script('Hotel_js', plugin_dir_url( __FILE__ ) . 'js/Hotel.js', array(), $this->plugin_version);
			wp_enqueue_script('Reservation_manage_js', plugin_dir_url( __FILE__ ) . 'js/Reservation_manage.js', array(), $this->plugin_version);
			
			wp_localize_script('Reservation_manage_js', $this->prefix.'dictionary', $dictionary);
			wp_localize_script('Reservation_manage_js', 'schedule_data', $localize_script);
			wp_enqueue_script('Reservation_manage_js');
			
			
			$updated_style = "display: none;";
			$control_panel_button_style = "display: none;";
			$user = wp_get_current_user();
			if (!empty($_POST) && $user->allcaps['manage_options'] === true) {
				
				if (check_admin_referer('booking_package_action', 'booking_package_nonce_field')) {
					
					
					
				}
				
			}
			
			$active = get_option("booking_package_active", 0);
			$booking_package_id = get_option("booking_package_id", "");
			$booking_package_path = get_option("booking_package_path", "");
			$booking_package_script_path = get_option("booking_package_script_path", "");
			$booking_package_serial = get_option("booking_package_serial", "");
			
			if (!empty($booking_package_script_path)) {
				
				$control_panel_button_style = "";
				
			}
			
			$pluginName = $this->plugin_name;
			$update_class = "";
			?>
			<div class="wrap">
				<div class="top_bar">
					<!--
					<h1 class="wp-heading-inline top_title_h1"><?php _e("Report & Booking", $pluginName); ?></h1>
					-->
					<?php
					$this->upgradeButton($isExtensionsValid);
					?>
				</div>
				<div class="<?php print $update_class; ?>settings-error notice is-dismissible" id="res" style="<?php print $updated_style; ?>"></div>
				
				<div id="select_package" class="welcome-panel">
					<div id="calendarPage"></div>
				</div>
				
				<div id="editPanel" class="edit_modal hidden_panel">
					<button type="button" id="media_modal_close" class="media_modal_close">
						<span class="">
							<span class="material-icons">close</span>
						</span>
					</button>
					<div class="edit_modal_content">
						<div id="menu_panel" class="media_frame_menu">
							<div id="media_menu" class="media_menu"></div>
						</div>
						<div id="media_title" class="media_frame_title"><h1 id="edit_title"></h1></div>
						<div id="media_router" class="media_frame_router">
							<div class="reservation_table_row">
								<div id="reservation_users" class="media_menu_item active"><?php _e("Customers", $pluginName); ?><!-- <?php _e("List of visitors", $pluginName); ?> --></div>
								<div id="add_reservation" class="media_menu_item"><?php _e("Booking", $pluginName); ?></div>
							</div>
						</div>
						<div id="media_frame_reservation_content"></div>
						<div id="frame_toolbar" class="media_frame_toolbar">
							<div class="media_toolbar">
								<div id="buttonPanel" class="media_toolbar_primary" style="float: initial;">
									
									<div id="leftButtonPanel"></div>
									<div id="rightButtonPanel"></div>
									
								</div>
							</div>
						</div>
						
					</div>
					
				</div>
				
				<div id="blockPanel" class="edit_modal_backdrop hidden_panel"></div>
				
				<div id="dialogPanel" class="hidden_panel">
					<div class="blockPanel"></div>
					<div class="confirmPanel">
						<div class="subject"><?php _e("Title", $pluginName); ?></div>
						<div class="body"><?php _e("Message", $pluginName); ?></div>
						<div class="buttonPanel">
							<button id="dialogButtonYes" type="button" class="yesButton button button-primary"><?php _e("Yes", $pluginName); ?></button>
							<button id="dialogButtonNo" type="button" class="noButton button button-primary"><?php _e("No", $pluginName); ?></button>
						</div>
					</div>
				</div>
				
				<div id="selectOptionsPanel" class="hidden_panel">
					<div class="blockPanel"></div>
					<div class="confirmPanel">
						<div class="subject"><?php _e("Title", $pluginName); ?></div>
						<div class="body"><?php _e("Message", $pluginName); ?></div>
						<div class="buttonPanel">
							<button type="button" class="decisionButton button media-button button-primary button-large media-button-insert"><?php _e("Decision", $pluginName); ?></button>
							<!--
							<button id="dialogButtonYes" type="button" class="yesButton button button-primary"><?php _e("Yes", $pluginName); ?></button>
							<button id="dialogButtonNo" type="button" class="noButton button button-primary"><?php _e("No", $pluginName); ?></button>
							-->
						</div>
					</div>
				</div>
				
			<!-- /.wrap -->
			</div>	
			<!--
			<div id="loadingPanel" class="loading_modal_backdrop hidden_panel"><img src="<?php print plugin_dir_url( __FILE__ ); ?>images/loading_0.gif"></div>
			-->
			<div id="loadingPanel">
				<div class="loader">
					<svg viewBox="0 0 64 64" width="64" height="64">
						<circle id="spinner" cx="32" cy="32" r="28" fill="none"></circle>
					</svg>
				</div>
			</div>
			
			<div id="lookForUserPanel" class="hidden_panel">
				
				<div>
					<div class="titlePanel">
		                <div class="title">
		                	<!-- Choose a schedule -->
							<?php _e('Looking for users', $pluginName); ?>
		                </div>
		                <div id="lookForUserPanel_return_button" class="material-icons closeButton" style="font-family: 'Material Icons' !important">close</div>
		            </div>
		            <div class="inputPanel">
		            	<!--
		                <div id="selectionSchedule_hours" class="selectBlock">
		                	<div data-key="hours" class="items">Hours: <span>0</span></div>
		                	<div data-key="hours" class="selectPanel openAnimation">
		                		
		                		<span class="selectItem selectedItem" data-key="hours" data-value="0">00</span><span class="selectItem" data-key="hours" data-value="1">01</span><span class="selectItem" data-key="hours" data-value="2">02</span><span class="selectItem" data-key="hours" data-value="3">03</span><span class="selectItem" data-key="hours" data-value="4">04</span><span class="selectItem" data-key="hours" data-value="5">05</span><span class="selectItem" data-key="hours" data-value="6">06</span><span class="selectItem" data-key="hours" data-value="7">07</span><span class="selectItem" data-key="hours" data-value="8">08</span><span class="selectItem" data-key="hours" data-value="9">09</span><span class="selectItem" data-key="hours" data-value="10">10</span><span class="selectItem" data-key="hours" data-value="11">11</span><span class="selectItem" data-key="hours" data-value="12">12</span><span class="selectItem" data-key="hours" data-value="13">13</span><span class="selectItem" data-key="hours" data-value="14">14</span><span class="selectItem" data-key="hours" data-value="15">15</span><span class="selectItem" data-key="hours" data-value="16">16</span><span class="selectItem" data-key="hours" data-value="17">17</span><span class="selectItem" data-key="hours" data-value="18">18</span><span class="selectItem" data-key="hours" data-value="19">19</span><span class="selectItem" data-key="hours" data-value="20">20</span><span class="selectItem" data-key="hours" data-value="21">21</span><span class="selectItem" data-key="hours" data-value="22">22</span><span class="selectItem" data-key="hours" data-value="23">23</span>			                		
		                	</div>
		                </div>
		                <div id="selectionSchedule_minutes" class="selectBlock">
		                	<div data-key="minutes" class="items">Minutes: <span>0</span></div>
		                	<div data-key="minutes" class="selectPanel closed">
		                		
		                		<span class="selectItem selectedItem" data-key="minutes" data-value="0">00</span><span class="selectItem" data-key="minutes" data-value="1">01</span><span class="selectItem" data-key="minutes" data-value="2">02</span><span class="selectItem" data-key="minutes" data-value="3">03</span><span class="selectItem" data-key="minutes" data-value="4">04</span><span class="selectItem" data-key="minutes" data-value="5">05</span><span class="selectItem" data-key="minutes" data-value="6">06</span><span class="selectItem" data-key="minutes" data-value="7">07</span><span class="selectItem" data-key="minutes" data-value="8">08</span><span class="selectItem" data-key="minutes" data-value="9">09</span><span class="selectItem" data-key="minutes" data-value="10">10</span><span class="selectItem" data-key="minutes" data-value="11">11</span><span class="selectItem" data-key="minutes" data-value="12">12</span><span class="selectItem" data-key="minutes" data-value="13">13</span><span class="selectItem" data-key="minutes" data-value="14">14</span><span class="selectItem" data-key="minutes" data-value="15">15</span><span class="selectItem" data-key="minutes" data-value="16">16</span><span class="selectItem" data-key="minutes" data-value="17">17</span><span class="selectItem" data-key="minutes" data-value="18">18</span><span class="selectItem" data-key="minutes" data-value="19">19</span><span class="selectItem" data-key="minutes" data-value="20">20</span><span class="selectItem" data-key="minutes" data-value="21">21</span><span class="selectItem" data-key="minutes" data-value="22">22</span><span class="selectItem" data-key="minutes" data-value="23">23</span><span class="selectItem" data-key="minutes" data-value="24">24</span><span class="selectItem" data-key="minutes" data-value="25">25</span><span class="selectItem" data-key="minutes" data-value="26">26</span><span class="selectItem" data-key="minutes" data-value="27">27</span><span class="selectItem" data-key="minutes" data-value="28">28</span><span class="selectItem" data-key="minutes" data-value="29">29</span><span class="selectItem" data-key="minutes" data-value="30">30</span><span class="selectItem" data-key="minutes" data-value="31">31</span><span class="selectItem" data-key="minutes" data-value="32">32</span><span class="selectItem" data-key="minutes" data-value="33">33</span><span class="selectItem" data-key="minutes" data-value="34">34</span><span class="selectItem" data-key="minutes" data-value="35">35</span><span class="selectItem" data-key="minutes" data-value="36">36</span><span class="selectItem" data-key="minutes" data-value="37">37</span><span class="selectItem" data-key="minutes" data-value="38">38</span><span class="selectItem" data-key="minutes" data-value="39">39</span><span class="selectItem" data-key="minutes" data-value="40">40</span><span class="selectItem" data-key="minutes" data-value="41">41</span><span class="selectItem" data-key="minutes" data-value="42">42</span><span class="selectItem" data-key="minutes" data-value="43">43</span><span class="selectItem" data-key="minutes" data-value="44">44</span><span class="selectItem" data-key="minutes" data-value="45">45</span><span class="selectItem" data-key="minutes" data-value="46">46</span><span class="selectItem" data-key="minutes" data-value="47">47</span><span class="selectItem" data-key="minutes" data-value="48">48</span><span class="selectItem" data-key="minutes" data-value="49">49</span><span class="selectItem" data-key="minutes" data-value="50">50</span><span class="selectItem" data-key="minutes" data-value="51">51</span><span class="selectItem" data-key="minutes" data-value="52">52</span><span class="selectItem" data-key="minutes" data-value="53">53</span><span class="selectItem" data-key="minutes" data-value="54">54</span><span class="selectItem" data-key="minutes" data-value="55">55</span><span class="selectItem" data-key="minutes" data-value="56">56</span><span class="selectItem" data-key="minutes" data-value="57">57</span><span class="selectItem" data-key="minutes" data-value="58">58</span><span class="selectItem" data-key="minutes" data-value="59">59</span>			                		
		                	</div>
		                </div>
		                <div id="selectionSchedule_deadline" class="selectBlock">
		                	<div data-key="deadline" class="items">Deadline time: <span>0</span></div>
		                	<div data-key="deadline" class="selectPanel closed">
		                		
		                		<span class="selectItem selectedItem" data-key="deadline" data-value="0">00</span><span class="selectItem" data-key="deadline" data-value="30">30</span><span class="selectItem" data-key="deadline" data-value="60">60</span><span class="selectItem" data-key="deadline" data-value="90">90</span><span class="selectItem" data-key="deadline" data-value="120">120</span><span class="selectItem" data-key="deadline" data-value="150">150</span><span class="selectItem" data-key="deadline" data-value="180">180</span><span class="selectItem" data-key="deadline" data-value="210">210</span><span class="selectItem" data-key="deadline" data-value="240">240</span><span class="selectItem" data-key="deadline" data-value="270">270</span><span class="selectItem" data-key="deadline" data-value="300">300</span><span class="selectItem" data-key="deadline" data-value="330">330</span><span class="selectItem" data-key="deadline" data-value="360">360</span><span class="selectItem" data-key="deadline" data-value="390">390</span><span class="selectItem" data-key="deadline" data-value="420">420</span><span class="selectItem" data-key="deadline" data-value="450">450</span><span class="selectItem" data-key="deadline" data-value="480">480</span><span class="selectItem" data-key="deadline" data-value="510">510</span><span class="selectItem" data-key="deadline" data-value="540">540</span><span class="selectItem" data-key="deadline" data-value="570">570</span><span class="selectItem" data-key="deadline" data-value="600">600</span><span class="selectItem" data-key="deadline" data-value="630">630</span><span class="selectItem" data-key="deadline" data-value="660">660</span><span class="selectItem" data-key="deadline" data-value="690">690</span><span class="selectItem" data-key="deadline" data-value="720">720</span><span class="selectItem" data-key="deadline" data-value="750">750</span><span class="selectItem" data-key="deadline" data-value="780">780</span><span class="selectItem" data-key="deadline" data-value="810">810</span><span class="selectItem" data-key="deadline" data-value="840">840</span><span class="selectItem" data-key="deadline" data-value="870">870</span><span class="selectItem" data-key="deadline" data-value="900">900</span><span class="selectItem" data-key="deadline" data-value="930">930</span><span class="selectItem" data-key="deadline" data-value="960">960</span><span class="selectItem" data-key="deadline" data-value="990">990</span><span class="selectItem" data-key="deadline" data-value="1020">1020</span><span class="selectItem" data-key="deadline" data-value="1050">1050</span><span class="selectItem" data-key="deadline" data-value="1080">1080</span><span class="selectItem" data-key="deadline" data-value="1110">1110</span><span class="selectItem" data-key="deadline" data-value="1140">1140</span><span class="selectItem" data-key="deadline" data-value="1170">1170</span><span class="selectItem" data-key="deadline" data-value="1200">1200</span><span class="selectItem" data-key="deadline" data-value="1230">1230</span><span class="selectItem" data-key="deadline" data-value="1260">1260</span><span class="selectItem" data-key="deadline" data-value="1290">1290</span><span class="selectItem" data-key="deadline" data-value="1320">1320</span><span class="selectItem" data-key="deadline" data-value="1350">1350</span><span class="selectItem" data-key="deadline" data-value="1380">1380</span><span class="selectItem" data-key="deadline" data-value="1410">1410</span><span class="selectItem" data-key="deadline" data-value="1440">1440</span>			                		
		                	</div>
		                </div>
		                <div id="selectionSchedule_capacitys" class="selectBlock">
		                	<div data-key="capacitys" class="items">Capacitys: <span>0</span></div>
		                	<div data-key="capacitys" class="selectPanel closed">
		                		
		                		<span class="selectItem selectedItem" data-key="capacitys" data-value="0">00</span><span class="selectItem" data-key="capacitys" data-value="1">01</span><span class="selectItem" data-key="capacitys" data-value="2">02</span><span class="selectItem" data-key="capacitys" data-value="3">03</span><span class="selectItem" data-key="capacitys" data-value="4">04</span><span class="selectItem" data-key="capacitys" data-value="5">05</span><span class="selectItem" data-key="capacitys" data-value="6">06</span><span class="selectItem" data-key="capacitys" data-value="7">07</span><span class="selectItem" data-key="capacitys" data-value="8">08</span><span class="selectItem" data-key="capacitys" data-value="9">09</span><span class="selectItem" data-key="capacitys" data-value="10">10</span><span class="selectItem" data-key="capacitys" data-value="11">11</span><span class="selectItem" data-key="capacitys" data-value="12">12</span><span class="selectItem" data-key="capacitys" data-value="13">13</span><span class="selectItem" data-key="capacitys" data-value="14">14</span><span class="selectItem" data-key="capacitys" data-value="15">15</span><span class="selectItem" data-key="capacitys" data-value="16">16</span><span class="selectItem" data-key="capacitys" data-value="17">17</span><span class="selectItem" data-key="capacitys" data-value="18">18</span><span class="selectItem" data-key="capacitys" data-value="19">19</span><span class="selectItem" data-key="capacitys" data-value="20">20</span><span class="selectItem" data-key="capacitys" data-value="21">21</span><span class="selectItem" data-key="capacitys" data-value="22">22</span><span class="selectItem" data-key="capacitys" data-value="23">23</span><span class="selectItem" data-key="capacitys" data-value="24">24</span><span class="selectItem" data-key="capacitys" data-value="25">25</span><span class="selectItem" data-key="capacitys" data-value="26">26</span><span class="selectItem" data-key="capacitys" data-value="27">27</span><span class="selectItem" data-key="capacitys" data-value="28">28</span><span class="selectItem" data-key="capacitys" data-value="29">29</span><span class="selectItem" data-key="capacitys" data-value="30">30</span><span class="selectItem" data-key="capacitys" data-value="31">31</span><span class="selectItem" data-key="capacitys" data-value="32">32</span><span class="selectItem" data-key="capacitys" data-value="33">33</span><span class="selectItem" data-key="capacitys" data-value="34">34</span><span class="selectItem" data-key="capacitys" data-value="35">35</span><span class="selectItem" data-key="capacitys" data-value="36">36</span><span class="selectItem" data-key="capacitys" data-value="37">37</span><span class="selectItem" data-key="capacitys" data-value="38">38</span><span class="selectItem" data-key="capacitys" data-value="39">39</span><span class="selectItem" data-key="capacitys" data-value="40">40</span><span class="selectItem" data-key="capacitys" data-value="41">41</span><span class="selectItem" data-key="capacitys" data-value="42">42</span><span class="selectItem" data-key="capacitys" data-value="43">43</span><span class="selectItem" data-key="capacitys" data-value="44">44</span><span class="selectItem" data-key="capacitys" data-value="45">45</span><span class="selectItem" data-key="capacitys" data-value="46">46</span><span class="selectItem" data-key="capacitys" data-value="47">47</span><span class="selectItem" data-key="capacitys" data-value="48">48</span><span class="selectItem" data-key="capacitys" data-value="49">49</span><span class="selectItem" data-key="capacitys" data-value="50">50</span><span class="selectItem" data-key="capacitys" data-value="51">51</span><span class="selectItem" data-key="capacitys" data-value="52">52</span><span class="selectItem" data-key="capacitys" data-value="53">53</span><span class="selectItem" data-key="capacitys" data-value="54">54</span><span class="selectItem" data-key="capacitys" data-value="55">55</span><span class="selectItem" data-key="capacitys" data-value="56">56</span><span class="selectItem" data-key="capacitys" data-value="57">57</span><span class="selectItem" data-key="capacitys" data-value="58">58</span><span class="selectItem" data-key="capacitys" data-value="59">59</span><span class="selectItem" data-key="capacitys" data-value="60">60</span><span class="selectItem" data-key="capacitys" data-value="61">61</span><span class="selectItem" data-key="capacitys" data-value="62">62</span><span class="selectItem" data-key="capacitys" data-value="63">63</span><span class="selectItem" data-key="capacitys" data-value="64">64</span><span class="selectItem" data-key="capacitys" data-value="65">65</span><span class="selectItem" data-key="capacitys" data-value="66">66</span><span class="selectItem" data-key="capacitys" data-value="67">67</span><span class="selectItem" data-key="capacitys" data-value="68">68</span><span class="selectItem" data-key="capacitys" data-value="69">69</span><span class="selectItem" data-key="capacitys" data-value="70">70</span><span class="selectItem" data-key="capacitys" data-value="71">71</span><span class="selectItem" data-key="capacitys" data-value="72">72</span><span class="selectItem" data-key="capacitys" data-value="73">73</span><span class="selectItem" data-key="capacitys" data-value="74">74</span><span class="selectItem" data-key="capacitys" data-value="75">75</span><span class="selectItem" data-key="capacitys" data-value="76">76</span><span class="selectItem" data-key="capacitys" data-value="77">77</span><span class="selectItem" data-key="capacitys" data-value="78">78</span><span class="selectItem" data-key="capacitys" data-value="79">79</span><span class="selectItem" data-key="capacitys" data-value="80">80</span><span class="selectItem" data-key="capacitys" data-value="81">81</span><span class="selectItem" data-key="capacitys" data-value="82">82</span><span class="selectItem" data-key="capacitys" data-value="83">83</span><span class="selectItem" data-key="capacitys" data-value="84">84</span><span class="selectItem" data-key="capacitys" data-value="85">85</span><span class="selectItem" data-key="capacitys" data-value="86">86</span><span class="selectItem" data-key="capacitys" data-value="87">87</span><span class="selectItem" data-key="capacitys" data-value="88">88</span><span class="selectItem" data-key="capacitys" data-value="89">89</span><span class="selectItem" data-key="capacitys" data-value="90">90</span><span class="selectItem" data-key="capacitys" data-value="91">91</span><span class="selectItem" data-key="capacitys" data-value="92">92</span><span class="selectItem" data-key="capacitys" data-value="93">93</span><span class="selectItem" data-key="capacitys" data-value="94">94</span><span class="selectItem" data-key="capacitys" data-value="95">95</span><span class="selectItem" data-key="capacitys" data-value="96">96</span><span class="selectItem" data-key="capacitys" data-value="97">97</span><span class="selectItem" data-key="capacitys" data-value="98">98</span><span class="selectItem" data-key="capacitys" data-value="99">99</span>			                		
		                	</div>
		                </div>
		                <div id="selectionSchedule_remainders" class="selectBlock">
		                	<div data-key="remainders" class="items">Remainders: <span>0</span></div>
		                	<div data-key="remainders" class="selectPanel closed">
		                		
		                		<span class="selectItem selectedItem" data-key="remainders" data-value="0">00</span><span class="selectItem" data-key="remainders" data-value="1">01</span><span class="selectItem" data-key="remainders" data-value="2">02</span><span class="selectItem" data-key="remainders" data-value="3">03</span><span class="selectItem" data-key="remainders" data-value="4">04</span><span class="selectItem" data-key="remainders" data-value="5">05</span><span class="selectItem" data-key="remainders" data-value="6">06</span><span class="selectItem" data-key="remainders" data-value="7">07</span><span class="selectItem" data-key="remainders" data-value="8">08</span><span class="selectItem" data-key="remainders" data-value="9">09</span><span class="selectItem" data-key="remainders" data-value="10">10</span><span class="selectItem" data-key="remainders" data-value="11">11</span><span class="selectItem" data-key="remainders" data-value="12">12</span><span class="selectItem" data-key="remainders" data-value="13">13</span><span class="selectItem" data-key="remainders" data-value="14">14</span><span class="selectItem" data-key="remainders" data-value="15">15</span><span class="selectItem" data-key="remainders" data-value="16">16</span><span class="selectItem" data-key="remainders" data-value="17">17</span><span class="selectItem" data-key="remainders" data-value="18">18</span><span class="selectItem" data-key="remainders" data-value="19">19</span><span class="selectItem" data-key="remainders" data-value="20">20</span><span class="selectItem" data-key="remainders" data-value="21">21</span><span class="selectItem" data-key="remainders" data-value="22">22</span><span class="selectItem" data-key="remainders" data-value="23">23</span><span class="selectItem" data-key="remainders" data-value="24">24</span><span class="selectItem" data-key="remainders" data-value="25">25</span><span class="selectItem" data-key="remainders" data-value="26">26</span><span class="selectItem" data-key="remainders" data-value="27">27</span><span class="selectItem" data-key="remainders" data-value="28">28</span><span class="selectItem" data-key="remainders" data-value="29">29</span><span class="selectItem" data-key="remainders" data-value="30">30</span><span class="selectItem" data-key="remainders" data-value="31">31</span><span class="selectItem" data-key="remainders" data-value="32">32</span><span class="selectItem" data-key="remainders" data-value="33">33</span><span class="selectItem" data-key="remainders" data-value="34">34</span><span class="selectItem" data-key="remainders" data-value="35">35</span><span class="selectItem" data-key="remainders" data-value="36">36</span><span class="selectItem" data-key="remainders" data-value="37">37</span><span class="selectItem" data-key="remainders" data-value="38">38</span><span class="selectItem" data-key="remainders" data-value="39">39</span><span class="selectItem" data-key="remainders" data-value="40">40</span><span class="selectItem" data-key="remainders" data-value="41">41</span><span class="selectItem" data-key="remainders" data-value="42">42</span><span class="selectItem" data-key="remainders" data-value="43">43</span><span class="selectItem" data-key="remainders" data-value="44">44</span><span class="selectItem" data-key="remainders" data-value="45">45</span><span class="selectItem" data-key="remainders" data-value="46">46</span><span class="selectItem" data-key="remainders" data-value="47">47</span><span class="selectItem" data-key="remainders" data-value="48">48</span><span class="selectItem" data-key="remainders" data-value="49">49</span><span class="selectItem" data-key="remainders" data-value="50">50</span><span class="selectItem" data-key="remainders" data-value="51">51</span><span class="selectItem" data-key="remainders" data-value="52">52</span><span class="selectItem" data-key="remainders" data-value="53">53</span><span class="selectItem" data-key="remainders" data-value="54">54</span><span class="selectItem" data-key="remainders" data-value="55">55</span><span class="selectItem" data-key="remainders" data-value="56">56</span><span class="selectItem" data-key="remainders" data-value="57">57</span><span class="selectItem" data-key="remainders" data-value="58">58</span><span class="selectItem" data-key="remainders" data-value="59">59</span><span class="selectItem" data-key="remainders" data-value="60">60</span><span class="selectItem" data-key="remainders" data-value="61">61</span><span class="selectItem" data-key="remainders" data-value="62">62</span><span class="selectItem" data-key="remainders" data-value="63">63</span><span class="selectItem" data-key="remainders" data-value="64">64</span><span class="selectItem" data-key="remainders" data-value="65">65</span><span class="selectItem" data-key="remainders" data-value="66">66</span><span class="selectItem" data-key="remainders" data-value="67">67</span><span class="selectItem" data-key="remainders" data-value="68">68</span><span class="selectItem" data-key="remainders" data-value="69">69</span><span class="selectItem" data-key="remainders" data-value="70">70</span><span class="selectItem" data-key="remainders" data-value="71">71</span><span class="selectItem" data-key="remainders" data-value="72">72</span><span class="selectItem" data-key="remainders" data-value="73">73</span><span class="selectItem" data-key="remainders" data-value="74">74</span><span class="selectItem" data-key="remainders" data-value="75">75</span><span class="selectItem" data-key="remainders" data-value="76">76</span><span class="selectItem" data-key="remainders" data-value="77">77</span><span class="selectItem" data-key="remainders" data-value="78">78</span><span class="selectItem" data-key="remainders" data-value="79">79</span><span class="selectItem" data-key="remainders" data-value="80">80</span><span class="selectItem" data-key="remainders" data-value="81">81</span><span class="selectItem" data-key="remainders" data-value="82">82</span><span class="selectItem" data-key="remainders" data-value="83">83</span><span class="selectItem" data-key="remainders" data-value="84">84</span><span class="selectItem" data-key="remainders" data-value="85">85</span><span class="selectItem" data-key="remainders" data-value="86">86</span><span class="selectItem" data-key="remainders" data-value="87">87</span><span class="selectItem" data-key="remainders" data-value="88">88</span><span class="selectItem" data-key="remainders" data-value="89">89</span><span class="selectItem" data-key="remainders" data-value="90">90</span><span class="selectItem" data-key="remainders" data-value="91">91</span><span class="selectItem" data-key="remainders" data-value="92">92</span><span class="selectItem" data-key="remainders" data-value="93">93</span><span class="selectItem" data-key="remainders" data-value="94">94</span><span class="selectItem" data-key="remainders" data-value="95">95</span><span class="selectItem" data-key="remainders" data-value="96">96</span><span class="selectItem" data-key="remainders" data-value="97">97</span><span class="selectItem" data-key="remainders" data-value="98">98</span><span class="selectItem" data-key="remainders" data-value="99">99</span>			                		
		                	</div>
		                </div>
		                -->
					</div>
					<div class="buttonPanel">
						<input id='search_users_text' class='serch_users_text' type='text'>
						<button id='search_user_button' class='w3tc-button-save button-primary serch_user_button'><?php _e('Search', $pluginName); ?></button>
						<!--
						<button id="selectionScheduleResetButton" class="media-button button-primary button-large media-button-insert deleteButton" style="margin-right: 1em;">Reset</button>
		                <button id="selectionScheduleButton" class="media-button button-primary button-large media-button-insert">Apply</button>
		            	-->
		            </div>
				</div>
				
			</div>
			<div id="load_blockPanel" style="z-index: 16000;" class="edit_modal_backdrop hidden_panel"></div>
			
			<?php
			$load_end_time = microtime(true) - $load_start_time;
			echo '<!-- Load time: ' . $load_end_time . ' -->';
			
		}
		
		public function members_page(){
			
			$load_start_time = microtime(true);
            date_default_timezone_set($this->getTimeZone());
			$this->update_database();
			$this->upgrader_process();
			require_once(plugin_dir_path( __FILE__ ) . 'lib/Setting.php');
            require_once(plugin_dir_path( __FILE__ ) . 'lib/Schedule.php');
            require_once(plugin_dir_path( __FILE__ ) . 'lib/CreditCard.php');
            
			$p_v = "?p_v=".$this->plugin_version;
			$pluginName = $this->plugin_name;
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
            $schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
            $limit = get_option($this->prefix."read_member_limit", 10);
            #$limit = 1;
            $users = $schedule->get_users('users', 0, $limit, null);
			$localize_script = $this->localizeScript("member");
			$localize_script['action'] = $this->action_control;
			$localize_script['nonce'] = wp_create_nonce($this->action_control."_ajax");
			$localize_script['limit'] = $limit;
			
			$isExtensionsValid = $setting->extensionFunction(false);
			if ($isExtensionsValid == true) {
				
				$localize_script['isExtensionsValid'] = 1;
				
			} else {
				
				$users = array();
				$localize_script['isExtensionsValid'] = 0;
				
			}
			
			$accountList = $schedule->getCalendarAccountListData("`key`, `name`, `expressionsCheck`, `type`, `courseTitle`, `includeChildrenInRoom`, `numberOfPeopleInRoom`");
			$localize_script['calendarAccountList'] = $accountList;
			$emailEnableList = array();
			foreach ((array) $accountList as $key => $value) {
				
				$emailEnableList[intval($value['key'])] = $setting->getEmailMessageList($key);
				
			}
			$localize_script['emailEnableList'] = $emailEnableList;
			#$emailEnableList = $setting->getEmailMessageList($_POST['accountKey']);
			
			$memberSetting = $setting->getMemberSetting($isExtensionsValid);
			$swich_authority_by_hidden = "";
			if (intval($memberSetting['accept_subscribers_as_users']['value']) == 0 && intval($memberSetting['accept_contributors_as_users']['value']) == 0) {
				
				$swich_authority_by_hidden = " hidden_panel";
				
			}
			
			$dictionary = $this->getDictionary("setting_page", $this->plugin_name);
			wp_enqueue_script('i18n_js', plugin_dir_url( __FILE__ ).'js/i18n.js'.$p_v);
			wp_enqueue_script('XMLHttp_js', plugin_dir_url( __FILE__ ).'js/XMLHttp.js'.$p_v);
			wp_enqueue_script('Error_js', plugin_dir_url( __FILE__ ).'js/Error.js'.$p_v);
			wp_enqueue_script('Calendar_js', plugin_dir_url( __FILE__ ).'js/Calendar.js'.$p_v);
			wp_enqueue_script('Hotel_js', plugin_dir_url( __FILE__ ).'js/Hotel.js'.$p_v);
			wp_enqueue_script('Confirm_js', plugin_dir_url( __FILE__ ).'js/Confirm.js'.$p_v);
			wp_enqueue_script('Reservation_manage', plugin_dir_url( __FILE__ ).'js/Reservation_manage.js'.$p_v);
			wp_enqueue_script('Member_js', plugin_dir_url( __FILE__ ).'js/Member_manage.js'.$p_v);
			wp_localize_script('Member_js', 'setting_data', $localize_script);
			wp_localize_script('Member_js', $this->prefix.'dictionary', $dictionary);
			
			wp_enqueue_style('Control.css', plugin_dir_url( __FILE__ ).'css/Control.css', array(), $this->plugin_version);
			wp_enqueue_style('Control_for_madia_css', plugin_dir_url( __FILE__ ).'css/Control_for_madia.css', array(), $this->plugin_version);
            wp_add_inline_style("Control.css", $this->getFontFaceStyle());
			
			?>
			<div class="wrap">
				
				<div id="member_list">
					
					<div class="actionButtonPanel">
						
						<div class="actionButtonPanelLeft">
							<input type="text" id="search_users_text" class="serch_users_text" placeholder="Keywords" />
							<button id="search_user_button" type="button" class="w3tc-button-save button-primary serch_user_button"><?php _e("Search", $pluginName); ?></button>
							<button id="clear_user_button" type="button" class="w3tc-button-save button-primary clear_user_button"><?php _e("Clear", $pluginName); ?></button>
						</div>
						<div class="actionButtonPanelRight">
							<button id="add_member" type="button" class="w3tc-button-save button-primary" style="margin-right: 10px;"><?php _e("Add user", $pluginName); ?></button>
							<?php
							$this->upgradeButton($isExtensionsValid);
							?>
						</div>
					</div>
					
					<table id="member_list_table" class="wp-list-table widefat fixed striped">
						<tbody id="member_list_tbody">
						<?php
							print "<tr><td>ID</td><td>" . __("Username", $pluginName) . "</td><td>" . __("Email", $pluginName) . "</td><td>" . __("Registered", $pluginName) . "</td></tr>\n";
							$users_data = array();
							foreach ((array) $users as $key => $user) {
								
								#var_dump($user);
								$priority_high = "";
								if (intval($user->status) == 0) {
									
									$priority_high = '<span class="material-icons priority_high">priority_high</span>';
									
								}
								$users_data['user_id_' . $user->ID] = $user;
								print "<tr id='user_id_" . $user->ID . "' class='tr_user'><td><span class='userId'>" . $user->ID . "</span>".$priority_high."</td><td>" . $user->user_login . "</td><td>" . $user->user_email . "</td><td>" . $user->user_registered . "</td></tr>\n";
								
							}
							
						?>
						</tbody>
					</table>
					<div class="page_action_panel">
						<select id="swich_authority" class="select_limit<?php echo $swich_authority_by_hidden; ?>">
							<option value="user"><?php echo __("Booking Package", $pluginName); ?></option>
							<?php
								if (intval($memberSetting['accept_subscribers_as_users']['value']) == 1) {
								
									print '<option value="subscriber">' . __("Subscriber", $pluginName) . '</option>';
								
								}
								
								if (intval($memberSetting['accept_contributors_as_users']['value']) == 1) {
								
									print '<option value="contributor">' . __("Contributor", $pluginName) . '</option>';
								
								}
								
							?>
						</select>
						
						<select id="member_limit" class="select_limit">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
							<option value="50">50</option>
						</select>
						<button id="before_page" class="material-icons page_button w3tc-button-save button-primary">navigate_before</button>
						<button id="next_page" class="material-icons page_button w3tc-button-save button-primary">navigate_next</button>
						
					</div>
					
				</div>
				
				<div id="editPanel" class="edit_modal hidden_panel">
					<button type="button" id="media_modal_close" class="media_modal_close">
						<span class="">
							<span class="material-icons">close</span>
						</span>
					</button>
					<div class="edit_modal_content">
						<div id="menu_panel" class="media_frame_menu hidden_panel">
							<div id="media_menu" class="media_menu"></div>
						</div>
						<div id="media_title" class="media_left_zero"><h1 id="edit_title"></h1></div>
						<div id="media_router" class="media_left_zero">
							<div class="reservation_table_row">
								<div id="booked_list" class="media_menu_item active"><?php _e("Booking history", $pluginName); ?></div>
								<div id="edit_user" class="media_menu_item"><?php _e("User", $pluginName); ?></div>
							</div>
						</div>
						<div id="media_frame_reservation_content" class="media_left_zero">
							<div id="reservation_usersPanel" class="hidden_panel"></div>
							<div id="user_detail_panel" class="hidden_panel">
								<table class="wp-list-table widefat fixed">
									<tbody>
										<tr>
											<th><?php _e("Username", $pluginName); ?></th>
											<td><div id="user_edit_login"></div></td>
										</tr>
										<tr>
											<th><?php _e("Email", $pluginName); ?></th>
											<td><input type="text" name="user_edit_email" id="user_edit_email" class="input"></td>
										</tr>
										<tr>
											<th><?php _e("Status", $pluginName); ?></th>
											<td>
												<label>
													<input type="checkbox" name="user_edit_status" id="user_edit_status" class="" value="1">
													<?php _e("Approved", $pluginName); ?>
												</label>
											</td>
										</tr>
										<tr>
											<th><?php _e("Password", $pluginName); ?></th>
											<td>
												<div>
													<button id="user_edit_change_password_button" class="w3tc-button-save button-primary"><?php _e("Change password", $pluginName); ?></button>
                    								<input type="password" name="user_edit_pass" id="user_edit_pass" class="input hidden_panel">
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							
						</div>
						<div id="frame_toolbar" class="media_frame_toolbar media_left_zero">
							<div class="media_toolbar">
								<div id="buttonPanel" class="media_toolbar_primary" style="float: initial;">
									
									<div id="leftButtonPanel">
										<button id="beforButton" class="material-icons button media-button button-primary button-large media-button-insert">navigate_before</button>
										<button id="nextButton" class="material-icons button media-button button-primary button-large media-button-insert">navigate_next</button>
										<div id"positionOfBookedList"></div>
									</div>
									<div id="rightButtonPanel">
										<button id="edit_user_button" class="w3tc-button-save button-primary"><?php _e("Update Profile", $pluginName); ?></button>
                						<button id="edit_user_delete_button"  class="w3tc-button-save button-primary"><?php _e("Delete", $pluginName); ?></button>
									</div>
									
								</div>
							</div>
						</div>
						
					</div>
					
				</div>
				
			</div>
			
			<div id="dialogPanel" class="hidden_panel">
				<div class="blockPanel"></div>
				<div class="confirmPanel">
					<div class="subject"><?php _e("Title", $pluginName); ?></div>
					<div class="body"><?php _e("Message", $pluginName); ?></div>
					<div class="buttonPanel">
						<button id="dialogButtonYes" type="button" class="yesButton button button-primary"><?php _e("Yes", $pluginName); ?></button>
						<button id="dialogButtonNo" type="button" class="noButton button button-primary"><?php _e("No", $pluginName); ?></button>
					</div>
				</div>
			</div>
			
			<div id="blockPanel" class="edit_modal_backdrop hidden_panel">
				<?php
					print $this->member_form();
				?>
			</div>
			
			<div id="loadingPanel">
				<div class="loader">
					<svg viewBox="0 0 64 64" width="64" height="64">
						<circle id="spinner" cx="32" cy="32" r="28" fill="none"></circle>
					</svg>
				</div>
			</div>
		
			<?php
			wp_localize_script('Member_js', 'users_data', $users_data);
			#$member_form = $this->member_form();
			#print $member_form;
			$load_end_time = microtime(true) - $load_start_time;
			echo '<!-- Load time: ' . $load_end_time . ' -->';
			
		}
		
		public function schedule_page(){
			
			$load_start_time = microtime(true);
			date_default_timezone_set($this->getTimeZone());
			
			$this->update_database();
			$this->upgrader_process();
			require_once(plugin_dir_path( __FILE__ ) . 'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ) . 'lib/Schedule.php');
			
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
			$schedule->deleteOldDaysInSchedules();
			$dictionary = $this->getDictionary("schedule_page", $this->plugin_name);
			$localize_script = $this->localizeScript('schedule_page');
			$isExtensionsValid = $setting->extensionFunction(true);
			if ($isExtensionsValid == true) {
				
				$localize_script['isExtensionsValid'] = 1;
				
			} else {
				
				$localize_script['isExtensionsValid'] = 0;
				
			}
			
			if ($this->visitorSubscriptionForStripe == 0) {
				
				
				
			}
			
			$p_v = "?p_v=".$this->plugin_version;
			wp_print_scripts(array('jquery-ui-sortable'.$p_v));
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_style('Control.css', plugin_dir_url( __FILE__ ).'css/Control.css', array(), $this->plugin_version);
			wp_enqueue_style('Control_for_madia_css', plugin_dir_url( __FILE__ ).'css/Control_for_madia.css', array(), $this->plugin_version);
			$fontFaceStyle = $this->getFontFaceStyle();
            wp_add_inline_style("Control.css", $fontFaceStyle);
            wp_enqueue_script('Error_js', plugin_dir_url( __FILE__ ).'js/Error.js', array(), $this->plugin_version);
			wp_enqueue_script('i18n_js', plugin_dir_url( __FILE__ ).'js/i18n.js', array(), $this->plugin_version);
			wp_enqueue_script('XMLHttp_js', plugin_dir_url( __FILE__ ).'js/XMLHttp.js', array(), $this->plugin_version);
			wp_enqueue_script('Confirm_js', plugin_dir_url( __FILE__ ).'js/Confirm.js', array(), $this->plugin_version);
			wp_enqueue_script('Calendar_js', plugin_dir_url( __FILE__ ).'js/Calendar.js', array(), $this->plugin_version);
			wp_enqueue_script('input_js', plugin_dir_url( __FILE__ ).'js/Input.js', array(), $this->plugin_version);
			wp_enqueue_script('schedule_pange', plugin_dir_url( __FILE__ ).'js/Schedule.js', array('jquery', 'wp-color-picker'), $this->plugin_version);
			wp_localize_script('schedule_pange', $this->prefix.'dictionary', $dictionary);
			wp_localize_script('schedule_pange', 'schedule_data', $localize_script);
			
			$pluginName = $this->plugin_name;
			
			?>
			
			<div id="select_package" style='display: none;'>
				
				<div class="wrap">
					
					<div class="top_bar">
						<!--
						<h1 class="wp-heading-inline top_title_h1"><?php _e("Schedule setting", $pluginName); ?></h1>
						-->
						
					</div>
					<div id="serviceDisabled" class="hidden_panel"><?php _e("Service is disabled. ", $pluginName); echo " "; _e("Please change the setting on the \"Setting\" tab.", $pluginName); ?></div>
					<!-- <div id="select_package" class="welcome-panel"><div>  -->
					<!-- <div id="select_package"></div> -->
					
					<div id="calendarAccountList">
						<div class="actionButtonPanel">
							<button id="add_new_calendar" type="button" class="w3tc-button-save button-primary" style="margin-right: 10px;"><?php _e("Add new calendar", $pluginName); ?></button>
							<button id="create_clone" type="button" class="w3tc-button-save button-primary" style="margin-right: 10px;"><?php _e("Create a clone", $pluginName); ?></button>
							<?php
								$this->upgradeButton($isExtensionsValid);
							?>
						</div>
						<table id="calendar_list_table" class="wp-list-table widefat fixed striped"></table>
						
					</div>
					<div id="tabFrame" class="hidden_panel">
						<div class="actionButtonPanel">
							<button id="return_to_calendar_list" type="button" class="w3tc-button-save button-primary" style="margin-right: 10px;"><?php _e("Return to Calendar list", $pluginName); ?></button>
							
						</div>
						
						<div style="overflow-x: auto;">
							<div class="menuList">
								<div id="calendarLink" class="menuItem active"><?php _e("Schedules", $pluginName); ?></div>
								<div id="formLink" class="menuItem hidden_panel"><?php _e("Form fields", $pluginName); ?></div>
								<div id="courseLink" class="menuItem hidden_panel"><?php _e("Services", $pluginName); ?></div>
								<div id="guestsLink" class="menuItem hidden_panel"><?php _e("Guests", $pluginName); ?></div>
								<div id="subscriptionsLink" class="menuItem hidden_panel"><?php _e('Subscriptions', $pluginName); ?></div>
								<div id="optionsForHotelLink" class="menuItem hidden_panel"><?php _e('Options', $pluginName); ?></div>
								<div id="taxLink" class="menuItem hidden_panel"><?php _e('Surcharge | Tax', $pluginName); ?></div>
								<div id="emailLink" class="menuItem hidden_panel"><?php _e("Emails", $pluginName); ?></div>
								<div id="syncLink" class="menuItem hidden_panel"><?php _e("Sync", $pluginName); ?></div>
								<div id="settingLink" class="menuItem hidden_panel"><?php _e("Setting", $pluginName); ?></div>
							</div>
						</div>
						<div id="contentPanel" class="content">
							<div id="schedulePage"></div>
							<div id="formPanel" class="hidden_panel"></div>
							<div id="coursePanel" class="hidden_panel"></div>
							<div id="guestsPanel" class="hidden_panel"></div>
							<div id="subscriptionsPanel" class="hidden_panel"></div>
							<div id="optionsForHotelPanel" class="hidden_panel"></div>
							<div id="taxPanel" class="hidden_panel"></div>
							<div id="emailPanel" class="hidden_panel">
								<div id="mailSettingPanel">
									<div id="mailSettingButtonPanel"></div>
									<div id="content_area"></div>
								</div>
							</div>
							<div id="syncPanel" class="hidden_panel"></div>
							<div id="settingPanel" class="hidden_panel"></div>
						</div>
					
					</div>
						
					<div id="calendarName" class="hidden_panel"></div>
					
				</div>
				
				<div id="editPanelForSchedule" class="edit_modal hidden_panel">
					<button type="button" id="media_modal_close_for_schedule" class="media_modal_close">
						<span class="media_modal_icon">
							<span class="screen_reader_text">Close</span>
						</span>
					</button>
					<div class="edit_modal_content">
						<div id="menu_panel_for_schedule" class="media_frame_menu">
							<div id="media_menu_for_schedule" class="media_menu"></div>
						</div>
						<div id="media_title_for_schedule" class="media_frame_title">
							<h1 id="edit_title_for_schedule"></h1>
						</div>
						<div id="media_router_for_schedule" class="media_frame_router">
							<table class="tableNameList">
								
								<tr>
									<th>No</th>
									<td class="timeTd"><?php _e("Time", $pluginName); ?></td>
									<td id="deadlineTime" class="td_width_100_px"><?php _e("Deadline time", $pluginName); ?></td>
									<td><?php _e("Title", $pluginName); ?></td>
									<td class="td_width_50_px"><?php _e("Capacity", $pluginName); ?></td>
									<td id="remainder" class="td_width_100_px hidden_panel"><?php _e("Remainder", $pluginName); ?></td>
									<td id="stop" class="td_width_50_px"><div class="deletePanel"><?php _e("Stop", $pluginName); ?></div></td>
									<td id="allScheduleDelete" class="td_width_50_px"><div class="deletePanel"><?php _e("Delete", $pluginName); ?></div></td>
								</tr>
								
							</table>
							
						</div>
						<div id="media_frame_content_for_schedule"></div>
						
						<div id="edit_schedule_for_hotel" class="media_left_zero hidden_panel">
							
							<table id="scheduleEditTable" class="table_option wp-list-table widefat fixed striped">
								<tr class="">
									<td class="">Date</td>
									<td class="">State</td>
									<td class="">Price</td>
									<td class="">Number of rooms available</td>
								</tr>
								
							</table>
							
						</div>
						
						<div id="email_edit_panel" class="media_left_zero hidden_panel">
							
							<div class="mail_message_area_left">
								<div class="enablePanel">
									<div class="enableLabel"><?php _e("Enable / Disable", $pluginName); ?></div>
									<div class="enableValuePanel">
										<label><input type="checkbox" id="mailEnable"/><?php _e("Enable this email notification", $pluginName); ?></label>
									</div>
								</div>
								<div class="emailFormatPanel">
									<div class="emailFormatLabel"><?php _e("Email format", $pluginName); ?></div>
									<div class="emailFormatValuePanel">
										<label style="margin-right: 10px;"><input type="radio" id="emailFormatHtml" name="emailFormat" /> HTML</label>
										<label><input type="radio" id="emailFormatText" name="emailFormat" /> TEXT</label>
									</div>
								</div>
								
								<div class="emailFormatLabel" style="padding-bottom: 10px;"><?php _e("Email for visitor", $pluginName); ?></div>
								<div class="emailFormatPanel">
									<input type="text" id="subject" class="mail_subject">
								</div>
								<div class="text_editer_panel">
									<textarea name="emailContent" id="emailContent"></textarea>
								</div>
								
								<div class="emailFormatLabel" style="padding: 10px 0; width: inherit;"><?php _e("Email for administrators", $pluginName); ?></div>
								<div class="emailFormatPanel">
									<input type="text" id="subjectForAdmin" class="mail_subject">
								</div>
								<div class="text_editer_panel">
									<textarea name="emailContent" id="emailContentForAdmin"></textarea>
								</div>
								
							</div>
							<div id="mail_message_area_right" class="mail_message_area_right"></div>
							
						</div>
						
						<div id="frame_toolbar_for_schedule" class="media_frame_toolbar">
							<div class="media_toolbar">
								<div id="buttonPanel_for_schedule" class="media_toolbar_primary">
									
								</div>
							</div>
						</div>
						
					</div>
					
				</div>
				
				<div id="blockPanel" class="edit_modal_backdrop hidden_panel"></div>
				
				<div id="deletePublishedSchedulesPanel" class="hidden_panel">
					
					<div>
			            <div class="titlePanel">
			                <div class="title"><?php echo __("Delete schedules", $pluginName); ?></div>
			                <div id="deletePublishedSchedulesPanel_return_button" class="material-icons closeButton" style="font-family: 'Material Icons' !important">close</div>
			            </div>
			            
			            <div class="inputPanel" style="border-width: 0; margin-bottom: 0;">
			                <table>
			                	<tr>
			                		<th><label><?php echo __("Period", $pluginName); ?></label></th>
			                		<td>
			                			<label>
					                    	<input id="period_all" name="period" type="radio" value="period_all"><?php echo __("All", $pluginName); ?>
					                    </label>
					                    <label>
					                    	<input id="period_after" name="period" type="radio" value="period_after" checked="checked"><?php echo __("After the specified date", $pluginName); ?>
					                    </label>
					                    <label>
					                    	<input id="period_within" name="period" type="radio" value="period_within"><?php echo __("Within the specified date", $pluginName); ?>
					                    </label>
			                		</td>
			                	</tr>
			                	<tr>
			                		<th><label><?php echo __("Date", $pluginName); ?></label></th>
			                		<td>
			                			<label id="period_after_date">
			                				<span class="from">From:</span>
			                				<select id="deletePublishedSchedules_from_month">
			                					<option value="1"><?php echo __("January", $pluginName); ?></option>
			                					<option value="2"><?php echo __("February", $pluginName); ?></option>
			                					<option value="3"><?php echo __("March", $pluginName); ?></option>
			                					<option value="4"><?php echo __("April", $pluginName); ?></option>
			                					<option value="5"><?php echo __("May", $pluginName); ?></option>
			                					<option value="6"><?php echo __("June", $pluginName); ?></option>
			                					<option value="7"><?php echo __("July", $pluginName); ?></option>
			                					<option value="8"><?php echo __("August", $pluginName); ?></option>
			                					<option value="9"><?php echo __("September", $pluginName); ?></option>
			                					<option value="10"><?php echo __("October", $pluginName); ?></option>
			                					<option value="11"><?php echo __("November", $pluginName); ?></option>
			                					<option value="12"><?php echo __("December", $pluginName); ?></option>
			                				</select>
			                				<select id="deletePublishedSchedules_from_day">
			                					<?php
			                						
			                						for($i = 1; $i < 32; $i++){
			                							
			                							echo '<option value="'.$i.'">'.$i.'</option>';
			                							
			                						}
			                						
			                					?>
			                				</select>
			                				<select id="deletePublishedSchedules_from_year">
			                					<?php
			                						
			                						$year = date('Y');
			                						for($i = 0; $i < 2; $i++){
			                							
			                							echo '<option value="'.$year.'">'.$year.'</option>';
			                							$year++;
			                							
			                						}
			                						
			                					?>
			                				</select>
			                				
			                			</label>
			                			<label id="period_within_date" class="hidden_panel">
			                				<span class="to">To:</span>
			                				<select id="deletePublishedSchedules_to_month">
			                					<option value="1"><?php echo __("January", $pluginName); ?></option>
			                					<option value="2"><?php echo __("February", $pluginName); ?></option>
			                					<option value="3"><?php echo __("March", $pluginName); ?></option>
			                					<option value="4"><?php echo __("April", $pluginName); ?></option>
			                					<option value="5"><?php echo __("May", $pluginName); ?></option>
			                					<option value="6"><?php echo __("June", $pluginName); ?></option>
			                					<option value="7"><?php echo __("July", $pluginName); ?></option>
			                					<option value="8"><?php echo __("August", $pluginName); ?></option>
			                					<option value="9"><?php echo __("September", $pluginName); ?></option>
			                					<option value="10"><?php echo __("October", $pluginName); ?></option>
			                					<option value="11"><?php echo __("November", $pluginName); ?></option>
			                					<option value="12"><?php echo __("December", $pluginName); ?></option>
			                				</select>
			                				<select id="deletePublishedSchedules_to_day">
			                					<?php
			                						
			                						for($i = 1; $i < 32; $i++){
			                							
			                							echo '<option value="'.$i.'">'.$i.'</option>';
			                							
			                						}
			                						
			                					?>
			                				</select>
			                				<select id="deletePublishedSchedules_to_year">
			                					<?php
			                						
			                						$year = date('Y');
			                						for($i = 0; $i < 2; $i++){
			                							
			                							echo '<option value="'.$year.'">'.$year.'</option>';
			                							$year++;
			                							
			                						}
			                						
			                					?>
			                				</select>
			                				
			                			</label>
			                			<p id="deletePublishedSchedules_freePlan" class="hidden_panel freePlan">
			                				<?php echo __("The selection of the date can not be done with the free plan.", $pluginName); ?>
			                			</p>
			                		</td>
			                	</tr>
			                	<tr>
			                		<th><label><?php echo __("Action", $pluginName); ?></label></th>
			                		<td>
			                			<label><input id="action_delete" type="radio" name="type" value="delete" checked="checked"><?php echo __("Delete", $pluginName); ?></label>
			                			<label><input id="action_stop" type="radio" name="type" value="stop"><?php echo __("Stop", $pluginName); ?></label>
			                		</td>
			                	</tr>
			                </table>
			            </div>
			            <div class="inputPanel">
			            	<?php echo __("If a visitor made booking, the schedule will not be deleted.", $pluginName); ?>
			            </div>
			            <div class="buttonPanel">
			                <button id="deletePublishedSchedulesButton" class="media-button button-primary button-large media-button-insert deleteButton"><?php echo __("Delete", $pluginName); ?></button>
			            </div>
			        </div>
					
				</div>
				
				<div id="loadSchedulesPanel" class="hidden_panel">
					
					<div>
			            <div class="titlePanel">
			                <div class="title"><?php echo __("Set up schedules", $pluginName); ?></div>
			                <div id="loadSchedulesPanel_return_button" class="material-icons closeButton" style="font-family: 'Material Icons' !important">close</div>
			            </div>
			            
			            <div class="inputPanel" style="border-width: 0; margin-bottom: 0;">
			                <table>
			                	<tr>
			                		<th><label><?php echo __("Time", $pluginName); ?></label></th>
			                		<td>
			                			<span class="fromTo">
				                			<span class="from">From:</span>
			                				<select id="read_from_hour">
			                					<?php
			                						
			                						for ($i = 0; $i < 24; $i++) { echo '<option value="'.$i.'">'.$i.'</option>'; }
			                					
			                					?>
			                				</select>
		                				</span>
		                				<span class="fromTo">
			                				<span class="to">To:</span>
			                				<select id="read_to_hour">
			                					<?php
			                						
			                						for ($i = 0; $i < 24; $i++) { echo '<option value="'.$i.'">'.$i.'</option>'; }
			                						
			                					?>
			                				</select>
		                				</span>
			                		</td>
			                	</tr>
			                	<tr>
			                		<th><label><?php echo __("Interval", $pluginName); ?></label></th>
			                		<td>
			                			<select id="interval_min" data-interval="5">
				                			<?php
				                				
				                				for ($i = 5; $i <= 120; $i += 5) { echo '<option value="'.$i.'">' . sprintf(__('%s minutes', $this->plugin_name), $i) . '</option>'; }
				                				
				                			?>
			                			</select>
			                		</td>
			                	</tr>
			                	<tr>
			                		<th><label><?php echo __("Deadline time", $pluginName); ?></label></th>
			                		<td>
			                			<select id="load_deadline_time">
			                			<?php
			                				
			                				for ($i = 0; $i <= BOOKING_PACKAGE_MAX_DEADLINE_TIME; $i += 30) { echo '<option value="'.$i.'">' . sprintf(__('%s min ago', $this->plugin_name), $i) . '</option>'; }
			                				
			                			?>
			                			</select>
			                		</td>
			                	</tr>
			                	<tr>
			                		<th><label><?php echo __("Capacitys", $pluginName); ?></label></th>
			                		<td>
			                			<select id="load_capacity">
			                			<?php
			                				
			                				for ($i = 1; $i < 100; $i++) { echo '<option value="'.$i.'">' . $i . '</option>'; }
			                				
			                			?>
			                			</select>
			                		</td>
			                	</tr>
			                </table>
			            </div>
			            <div class="buttonPanel">
			                <button id="readSchedulesButton" class="media-button button-primary button-large media-button-insert"><?php echo __("Apply", $pluginName); ?></button>
			            </div>
			        </div>
					
				</div>
				
				
				<div id="createClonePanel" class="hidden_panel">
					
					<div>
						<div class="titlePanel">
			                <div class="title"><?php echo __("Choose a calendar", $pluginName); ?></div>
			                <div id="createClonePanel_return_button" class="material-icons closeButton" style="font-family: 'Material Icons' !important">close</div>
			            </div>
			            <div class="inputPanel" style="border-width: 0; margin-bottom: 0;">
			                <table>
			                	<tr>
			                		<th><label><?php echo __("Calendar", $pluginName); ?></label></th>
			                		<td>
			                			<select id="selectedClone">
			                				<?php
			                					
			                					
			                				?>
			                			</select>
			                		</td>
			                	</tr>
			                	<tr>
			                		<th><label><?php echo __("Target", $pluginName); ?></label></th>
			                		<td>
			                			<label><input type="checkbox" name="target" class="target" value="schedules" checked="checked"> <?php echo __("Schedules", $pluginName); ?></label>
			                			<label><input type="checkbox" name="target" class="target" value="form" checked="checked"> <?php echo __("Form fields", $pluginName); ?></label>
			                			<label><input type="checkbox" name="target" class="target" value="services" checked="checked"> <?php echo __("Services", $pluginName); ?></label>
			                			<label><input type="checkbox" name="target" class="target" value="guests" checked="checked"> <?php echo __("Guests", $pluginName); ?></label>
			                			<?php
			                				
			                				if ($this->visitorSubscriptionForStripe == 1) {
			                					
			                					?>
			                						<label><input type="checkbox" name="target" class="target" value="subscriptions" checked="checked"> <?php echo __("Subscriptions", $pluginName); ?></label>
			                					<?php
			                					
			                				}
			                				
			                			?>
			                			<label><input type="checkbox" name="target" class="target" value="taxes" checked="checked"> <?php echo __("Surcharge and Tax", $pluginName); ?></label>
			                			<label><input type="checkbox" name="target" class="target" value="emails" checked="checked"> <?php echo __("Emails", $pluginName); ?></label>
			                		</td>
			                	</tr>
			                </table>
						</div>
						<div class="buttonPanel">
			                <button id="createCloneButton" class="media-button button-primary button-large media-button-insert"><?php echo __("Create", $pluginName); ?></button>
			            </div>
					</div>
					
				</div>
				
				<div id="selectionSchedule" class="hidden_panel">
					
					<div>
						<div class="titlePanel">
			                <div class="title"><?php echo __("Choose a schedule", $pluginName); ?></div>
			                <div id="selectionSchedule_return_button" class="material-icons closeButton" style="font-family: 'Material Icons' !important">close</div>
			            </div>
			            <div class="inputPanel" style="border-width: 0; margin-bottom: 0;">
			                <div id="selectionSchedule_hours" class="selectBlock">
			                	<div data-key="hours" class="items"><?php echo __("Hours", $pluginName); ?>: <span>7</span></div>
			                	<div data-key="hours" class="selectPanel closed">
			                		
			                		<?php
			                			
			                			for ($i = 0; $i < 24; $i++) { echo '<span class="selectItem" data-key="hours" data-value="' . $i . '">' . sprintf('%02d', $i) . '</span>'; }
			                		
			                		?>
			                		
			                	</div>
			                </div>
			                <div id="selectionSchedule_minutes" class="selectBlock">
			                	<div data-key="minutes" class="items"><?php echo __("Minutes", $pluginName); ?>: <span>7</span></div>
			                	<div data-key="minutes" class="selectPanel closed">
			                		
			                		<?php
			                			
			                			for ($i = 0; $i < 60; $i++) { echo '<span class="selectItem" data-key="minutes" data-value="' . $i . '">' . sprintf('%02d', $i) . '</span>'; }
			                		
			                		?>
			                		
			                	</div>
			                </div>
			                <div id="selectionSchedule_deadline" class="selectBlock">
			                	<div data-key="deadline" class="items"><?php echo __("Deadline time", $pluginName); ?>: <span>7</span></div>
			                	<div data-key="deadline" class="selectPanel closed">
			                		
			                		<?php
			                			
			                			for ($i = 0; $i <= BOOKING_PACKAGE_MAX_DEADLINE_TIME; $i += 30) { echo '<span class="selectItem" data-key="deadline" data-value="' . $i . '">' . sprintf('%02d', $i) . '</span>'; }
			                		
			                		?>
			                		
			                	</div>
			                </div>
			                <div id="selectionSchedule_capacitys" class="selectBlock">
			                	<div data-key="capacitys" class="items"><?php echo __("Capacitys", $pluginName); ?>: <span>7</span></div>
			                	<div data-key="capacitys" class="selectPanel closed">
			                		
			                		<?php
			                			
			                			for ($i = 0; $i < 100; $i++) { echo '<span class="selectItem" data-key="capacitys" data-value="' . $i . '">' . sprintf('%02d', $i) . '</span>'; }
			                		
			                		?>
			                		
			                	</div>
			                </div>
			                <div id="selectionSchedule_remainders" class="selectBlock">
			                	<div data-key="remainders" class="items"><?php echo __("Remainders", $pluginName); ?>: <span>7</span></div>
			                	<div data-key="remainders" class="selectPanel closed">
			                		
			                		<?php
			                			
			                			for ($i = 0; $i < 100; $i++) { echo '<span class="selectItem" data-key="remainders" data-value="' . $i . '">' . sprintf('%02d', $i) . '</span>'; }
			                		
			                		?>
			                		
			                	</div>
			                </div>
						</div>
						<div class="buttonPanel">
							<button id="selectionScheduleResetButton" class="media-button button-primary button-large media-button-insert deleteButton" style="margin-right: 1em;"><?php echo __("Reset", $pluginName); ?></button>
			                <button id="selectionScheduleButton" class="media-button button-primary button-large media-button-insert"><?php echo __("Apply", $pluginName); ?></button>
			            </div>
					</div>
					
				</div>
				
				<div id="load_blockPanel" style="z-index: 16000;"></div>
				
				<div id="timeSelectPanel" class="hidden_panel">
					<div class="blockPanel"></div>
					
					<div id="selectPanelForConfirm" class="selectPanel">
						<div id="arror"></div>
						<div class="subject"><?php _e("Title", $pluginName); ?></div>
						<div id="confirm_body" class="body"></div>
						<div class="buttonPanel scheduleButtonPanel">
							<button id="dialogButtonReset" type="button" class="yesButton button button-primary" style="width: 70px; margin: 0;"><?php _e("Reset", $pluginName); ?></button>
							<button id="dialogButtonDone" type="button" class="noButton button button-primary" style="width: 70px; margin: 0;"><?php _e("Close", $pluginName); ?></button>
						</div>
					</div>
					
				</div>
				
				<div id="dialogPanel" class="hidden_panel">
					<div class="blockPanel"></div>
					<div class="confirmPanel">
						<div class="subject"><?php _e("Title", $pluginName); ?></div>
						<div class="body"><?php _e("Message", $pluginName); ?></div>
						<div class="buttonPanel">
							<button id="dialogButtonYes" type="button" class="yesButton button button-primary"><?php _e("Yes", $pluginName); ?></button>
							<button id="dialogButtonNo" type="button" class="noButton button button-primary"><?php _e("No", $pluginName); ?></button>
						</div>
					</div>
				</div>
			
			</div>	
				
			<!--
			<div id="loadingPanel" class="loading_modal_backdrop hidden_panel"><img src="<?php print plugin_dir_url( __FILE__ ); ?>images/loading_0.gif"></div>
			-->
			<div id="loadingPanel" class="">
				<div class="loader">
					<svg viewBox="0 0 64 64" width="64" height="64">
						<circle id="spinner" cx="32" cy="32" r="28" fill="none"></circle>
					</svg>
				</div>
			</div>
			
			<select id="timezone_choice" class="hidden_panel">
				<?php
					echo wp_timezone_choice($this->getTimeZone());
				?>
			</select>
			<?php
			
			#print '<div id="loadingPanel" class="loading_modal_backdrop hidden_panel"><img src="'.plugin_dir_url( __FILE__ ).'images/loading_0.gif"></div>';
			$load_end_time = microtime(true) - $load_start_time;
			echo '<!-- Load time: ' . $load_end_time . ' -->';
			
		}
		
		public function setting_page(){
			
			$load_start_time = microtime(true);
			$this->update_database();
			$this->upgrader_process();
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			
			$booking_sync = $setting->getBookingSyncList();
			
			$dictionary = $this->getDictionary("setting_page", $this->plugin_name);
			$localize_script = $this->localizeScript("setting_page");
			$p_v = "?p_v=".$this->plugin_version;
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_style( 'setting_page', plugin_dir_url( __FILE__ ).'css/Control.css', array(), $this->plugin_version);
			wp_enqueue_style( 'control_for_madia_css', plugin_dir_url( __FILE__ ).'css/Control_for_madia.css', array(), $this->plugin_version);
			$fontFaceStyle = $this->getFontFaceStyle();
            wp_add_inline_style("Control.css", $fontFaceStyle);
			
			$subscriptions = $this->getSubscriptions();
			foreach ((array) $subscriptions as $key => $value) {
				
				
				if ($key == 'expiration_date_for_subscriptions' && strlen($value) > 0) {
					
					$localize_script['expiration_date'] = date('F d, Y H:i', $value);
					
				}
				
				$localize_script[$key] = $value;
				
			}
			
			$isExtensionsValid = $setting->extensionFunction();
			if ($isExtensionsValid == true) {
				
				$localize_script['isExtensionsValid'] = 1;
				
			} else {
				
				$localize_script['isExtensionsValid'] = 0;
				
			}
			
			if (isset($_GET['tab']) === true) {
				
				$localize_script['tab'] = $_GET['tab'];
				
			}
			
			$memberSetting = $setting->getMemberSetting($isExtensionsValid);
			$localize_script['memberSetting'] = $memberSetting;
			if (strtolower($localize_script['locale']) != 'ja' && strtolower($localize_script['locale']) != 'ja_jp' && strtolower($localize_script['locale']) != 'ja-jp') {
				
				unset($localize_script['list']['General'][$this->prefix.'characterCodeOfDownloadFile']);
				
			}
			
			$front_end_css = $setting->getCss("front_end.css", plugin_dir_path( __FILE__ ));
			$front_end_javascript = "";
			$front_end_javascript = $setting->getJavaScript("front_end.js", plugin_dir_path( __FILE__ ));
			$localize_script['javascriptForUser'] = 1;
			
			wp_print_scripts( array( 'jquery-ui-sortable' ));
			wp_enqueue_script('Error_js', plugin_dir_url( __FILE__ ).'js/Error.js', array(), $this->plugin_version);
			wp_enqueue_script('i18n_js', plugin_dir_url( __FILE__ ).'js/i18n.js', array(), $this->plugin_version);
			wp_enqueue_script('XMLHttp_js', plugin_dir_url( __FILE__ ).'js/XMLHttp.js', array(), $this->plugin_version);
			wp_enqueue_script('input_js', plugin_dir_url( __FILE__ ).'js/Input.js', array(), $this->plugin_version);
			wp_enqueue_script('Confirm_js', plugin_dir_url( __FILE__ ).'js/Confirm.js', array(), $this->plugin_version);
			wp_enqueue_script('Calendar_js', plugin_dir_url( __FILE__ ).'js/Calendar.js', array(), $this->plugin_version);
			wp_enqueue_script('setting_page', plugin_dir_url( __FILE__ ).'js/setting.js', array('jquery', 'wp-color-picker'), $this->plugin_version);
			wp_localize_script('setting_page', $this->prefix.'dictionary', $dictionary);
			wp_localize_script('setting_page', 'setting_data', $localize_script);
			
			wp_enqueue_style('codemirror_css', 'https://codemirror.net/lib/codemirror.css', array(), $this->plugin_version);
			wp_enqueue_script('codemirror_js', 'https://codemirror.net/lib/codemirror.js', array(), $this->plugin_version);
			wp_enqueue_script('codemirror_css_js', 'https://codemirror.net/mode/css/css.js', array(), $this->plugin_version);
			wp_enqueue_script('codemirror_javascript_js', 'https://codemirror.net/mode/javascript/javascript.js', array(), $this->plugin_version);
			
			$pluginName = $this->plugin_name;
			
			?>
				
				<div class="wrap">
					
					<div id="tabFrame">
						<div style="overflow-x: auto;">
							<div id="menuList" class="menuList">
								<div id="settingLink" class="menuItem active hidden_panel"><?php _e("Setting", $pluginName); ?></div>
								<div id="holidayLink" class="menuItem hidden_panel"><?php _e("Regular holiday", $pluginName); ?></div>
								<div id="nationalHolidayLink" class="menuItem hidden_panel"><?php _e("National holiday", $pluginName); ?></div>
								<div id="memberLink" class="menuItem hidden_panel"><?php _e("Users", $pluginName); ?></div>
								<div id="syncLink" class="menuItem hidden_panel"><?php _e("Sync", $pluginName); ?></div>
								<div id="cssLink" class="menuItem hidden_panel">CSS</div>
								<div id="javascriptLink" class="menuItem hidden_panel">JavaScript</div>
								<div id="subscriptionLink" class="menuItem hidden_panel"><?php _e("Subscription details", $pluginName); ?></div>
							</div>
						</div>
						<div id="contentPanel" class="content">
							<div id="settingPanel" class="hidden_panel">
								<div id="setting_table"></div>
								<div><button id="save_setting" type="button" class="w3tc-button-save button-primary"><?php _e("Save all settings", $pluginName); ?></button></div>
							</div>
							<div id="holidayPanel" class="hidden_panel">
								<div class="title"><?php _e("Regular holiday", $pluginName); ?></div>
								<div id="holidaysCalendarPanel"></div>
							</div>
							<div id="nationalHolidayPanel" class="hidden_panel">
								<div class="title"><?php _e("National holiday", $pluginName); ?></div>
								<div id="nationalHolidaysCalendarPanel"></div>
							</div>
							
							<div id="memberPanel" class="hidden_panel">
								<div id="member_table">
									<div class="title"><?php _e("Users", $pluginName); ?></div>
									<table class="form-table">
										<tr valign="top">
											<th scope="row"><?php _e("User account", $pluginName); ?></th>
											<td>
												<div class="valuePanel">
													<div class="extensionsValid"><?php _e("Subscribed users only", $pluginName); ?></div>
													<label>
														<input data-value="1" id="function_for_member" type="checkbox" value="1">
														<span class="radio_title"><?php _e("Enable", $pluginName); ?></span>
													</label>
												</div>
											</td>
										</tr>
										
										<tr valign="top">
											<th scope="row"><?php _e("Reject non-user account bookings", $pluginName); ?></th>
											<td>
												<div class="valuePanel">
													<div class="extensionsValid"><?php _e("Subscribed users only", $pluginName); ?></div>
													<label>
														<input data-value="1" id="reject_non_membder" type="checkbox" value="1">
														<span class="radio_title"><?php _e("Enable", $pluginName); ?></span>
													</label>
												</div>
											</td>
										</tr>
										
										<tr valign="top">
											<th scope="row"><?php _e("User registration from visitors", $pluginName); ?></th>
											<td>
												<div class="valuePanel">
													<div class="extensionsValid"><?php _e("Subscribed users only", $pluginName); ?></div>
													<label>
														<input data-value="1" id="visitors_registration_for_member" type="checkbox" value="1">
														<span class="radio_title"><?php _e("Enable", $pluginName); ?></span>
													</label>
												</div>
											</td>
										</tr>
										
										<tr valign="top">
											<th scope="row"><?php _e("Confirm whether the user's email address exists", $pluginName); ?></th>
											<td>
												<div class="valuePanel">
													<div class="extensionsValid"><?php _e("Subscribed users only", $pluginName); ?></div>
													<label>
														<input data-value="1" id="check_email_for_member" type="checkbox" value="1">
														<span class="radio_title"><?php _e("Enable", $pluginName); ?></span>
													</label>
												</div>
											</td>
										</tr>
										
										<tr valign="top">
											<th scope="row"><?php _e("Accept subscribers as users", $pluginName); ?></th>
											<td>
												<div class="valuePanel">
													<div class="extensionsValid"><?php _e("Subscribed users only", $pluginName); ?></div>
													<label>
														<input data-value="1" id="accept_subscribers_as_users" type="checkbox" value="1">
														<span class="radio_title"><?php _e("Enable", $pluginName); ?></span>
													</label>
												</div>
											</td>
										</tr>
										
										<tr valign="top">
											<th scope="row"><?php _e("Accept contributors as users", $pluginName); ?></th>
											<td>
												<div class="valuePanel">
													<div class="extensionsValid"><?php _e("Subscribed users only", $pluginName); ?></div>
													<label>
														<input data-value="1" id="accept_contributors_as_users" type="checkbox" value="1">
														<span class="radio_title"><?php _e("Enable", $pluginName); ?></span>
													</label>
												</div>
											</td>
										</tr>
										<!--
										<tr valign="top">
											<th scope="row"><?php _e("Accept authors as users", $pluginName); ?></th>
											<td>
												<div class="valuePanel">
													<div class="extensionsValid"><?php _e("Subscribed users only", $pluginName); ?></div>
													<label>
														<input data-value="1" id="accept_authors_as_users" type="checkbox" value="1">
														<span class="radio_title"><?php _e("Enable", $pluginName); ?></span>
													</label>
												</div>
											</td>
										</tr>
										-->
										<tr valign="top">
											<th scope="row"><?php _e("Toolbar", $pluginName); ?></th>
											<td>
												<div class="valuePanel">
													<div class="extensionsValid"><?php _e("Subscribed users only", $pluginName); ?></div>
													<label>
														<input data-value="1" id="user_toolbar" type="checkbox" value="1">
														<span class="radio_title"><?php _e("Enable", $pluginName); ?></span>
													</label>
												</div>
											</td>
										</tr>
										
										<tr valign="top">
											<th scope="row"><?php _e("Subject of email sent when confirming email address", $pluginName); ?></th>
											<td>
												<div class="valuePanel">
													<input type="text" id="subject_email_for_member" class="regular-text">
												</div>
											</td>
										</tr>
										
										<tr valign="top">
											<th scope="row"><?php _e("Body of email sent when confirming email address", $pluginName); ?></th>
											<td>
												<div class="valuePanel">
													<textarea id="body_email_for_member" class="regular-text"></textarea>
													<p>
													<?php
														_e("Please write the shortcode of [activation_url] in the text.", $pluginName);
														_e("The activation URL appears in [activation_url].", $pluginName);
													?>
													</p>
												</div>
											</td>
										</tr>
										
									</table>
									
									<div>
										<button id="save_member_setting_button" type="button" class="w3tc-button-save button-primary"><?php _e("Save all settings", $pluginName); ?></button>
									</div>
									
								</div>
								
								
							</div>
							
							<div id="syncPanel" class="hidden_panel">
								<div id="bookingSync_table"></div>
								<div><button id="save_bookingSync" type="button" class="w3tc-button-save button-primary"><?php _e("Save all settings", $pluginName); ?></button></div>
							</div>
							<div id="cssPanel" class="hidden_panel">
								
								<div class="title">CSS</div>
								<div style="padding-bottom: 1em;"><?php _e("Change the front-end page design by defining CSS.", $pluginName); ?></div>
								<textarea id="css" rows="50"><?php print $front_end_css; ?></textarea>
								<div><button id="save_css" type="button" class="w3tc-button-save button-primary" style="margin-top: 1em;"><?php _e("Save", $pluginName); ?></button></div>
								
							</div>
							
							<div id="javascriptPanel" class="hidden_panel">
								
								<div class="title">JavaScript</div>
								<textarea id="javascript_booking_package" rows="50"><?php print $front_end_javascript; ?></textarea>
								<div><button id="save_javascript" type="button" class="w3tc-button-save button-primary" style="margin-top: 1em;"><?php _e("Save", $pluginName); ?></button></div>
								
							</div>
							<div id="subscriptionPanel" class="hidden_panel"></div>
							
						</div>
					</div>
					
				</div>
				
				
				<div id="editPanel" class="edit_modal hidden_panel">
					<button type="button" id="media_modal_close" class="media_modal_close">
						<span class="">
							<span class="material-icons">close</span>
						</span>
					</button>
					<div class="edit_modal_content">
						<div id="media_title" class="media_left_zero"><h1 id="edit_title"></h1></div>
						<div id="media_router" class="media_left_zero">
							<div class="table_row">
								
							</div>
						</div>
						<div id="media_frame_content" class="media_left_zero content_top_48">
							
							<!--
							<div class="mail_message_area_left">
								
								<div class="enablePanel">
									<div class="enableLabel"><?php _e("Enable / Disable", $pluginName); ?></div>
									<div class="enableValuePanel">
										<label><input type="checkbox" id="mailEnable"/><?php _e("Enable this email notification", $pluginName); ?></label>
									</div>
								</div>
								<div class="emailFormatPanel">
									<div class="emailFormatLabel"><?php _e("Email format", $pluginName); ?></div>
									<div class="emailFormatValuePanel">
										<label style="margin-right: 10px;"><input type="radio" id="emailFormatHtml" name="emailFormat" /> HTML</label>
										<label><input type="radio" id="emailFormatText" name="emailFormat" /> TEXT</label>
									</div>
								</div>
								<div>
									<input type="text" id="subject" class="mail_subject">
								</div>
								<?php 
									
									foreach ((array) $emailMessageList as $key => $mailMessage) {
										
										$value = stripslashes($mailMessage['content']);
										print '<div id="'.$key.'_panel" class="text_editer_panel">';
										wp_editor($value, $key, array('media_buttons' => FALSE, 'textarea_rows' => 15)); 
										print '</div>';
										
									}	
								?>
							</div>
							<div id="mail_message_area_right" class="mail_message_area_right">
								
							</div>
							-->
						</div>
						<div id="frame_toolbar" class="media_frame_toolbar media_left_zero">
							<div class="media_toolbar">
								<div class="media_toolbar_primary">
									<button id="mail_message_save_button" type="button" class="button media-button button-primary button-large media-button-insert"><?php _e("Save", $pluginName); ?></button>
								</div>
							</div>
						</div>
						
					</div>
					
				</div>
				
				<div id="blockPanel" class="edit_modal_backdrop hidden_panel"></div>
				
				<div id="dialogPanel" class="hidden_panel">
					<div class="blockPanel"></div>
					<div class="confirmPanel">
						<div class="subject"><?php _e("Title", $pluginName); ?></div>
						<div class="body"><?php _e("Message", $pluginName); ?></div>
						<div class="buttonPanel">
							<button id="dialogButtonYes" type="button" class="yesButton button button-primary"><?php _e("Yes", $pluginName); ?></button>
							<button id="dialogButtonNo" type="button" class="noButton button button-primary"><?php _e("No", $pluginName); ?></button>
						</div>
					</div>
				</div>
				
				<div id="google_calendar_api" class="hidden_panel">
					
					<div>
						<!--
						<?php #_e("With the Google Calendar API, you can share customer information with both \"Booking Package\" and \"Google Calendar\".", $pluginName); ?>
						<?php #_e("When you create or edit a new event in Google Calendar, it will also be sent to the booking package.", $pluginName); ?><br>
						<?php #_e('For details on how to set up please read that <a id="googleCalendarLink" href="https://saasproject.net/googleCalendar/" target="_blank">how to set up sync for Booking Package and Google Calendar</a>. ', $pluginName); ?>
						-->
					</div>
					
				</div>
				<!--
				<div id="loadingPanel" class="loading_modal_backdrop hidden_panel"><img src="<?php print plugin_dir_url( __FILE__ ); ?>images/loading_0.gif"></div>
				-->
				<div id="loadingPanel" class="">
					<div class="loader">
						<svg viewBox="0 0 64 64" width="64" height="64">
							<circle id="spinner" cx="32" cy="32" r="28" fill="none"></circle>
						</svg>
					</div>
				</div>
				<select id="timezone_choice" class="hidden_panel">
					<?php
						echo wp_timezone_choice($this->getTimeZone());
					?>
				</select>
			<?php
			$load_end_time = microtime(true) - $load_start_time;
			echo '<!-- Load time: ' . $load_end_time . ' -->';
			
		}
		
		public function subscription_page() {
			
			$this->update_database();
			$this->upgrader_process();
			$pluginName = $this->plugin_name;
			#require_once(plugin_dir_path( __FILE__ ) . 'lib/Setting.php');
			#require_once(plugin_dir_path( __FILE__ ) . 'lib/Schedule.php');
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			$dictionary = $this->getDictionary("subscription_page", $this->plugin_name);
			$localize_script = $this->localizeScript("subscription_page");
			$subscriptions = $this->getSubscriptions();
			$subscriptions['expiration_date'] = 0;
			$localize_script['subscriptions'] = $subscriptions;
			foreach ((array) $subscriptions as $key => $value) {
				
				if ($key == 'expiration_date_for_subscriptions' && intval($value) != 0) {
					
					$subscriptions['expiration_date'] = date('F d, Y H:i', $value);
					
				}
				
			}
			
			$isExtensionsValid = $setting->extensionFunction();
			if ($isExtensionsValid == true) {
				
				$localize_script['isExtensionsValid'] = 1;
				
			} else {
				
				$localize_script['isExtensionsValid'] = 0;
				
			}
			/**
			$userId = get_current_user_id();
			$is_super_admin = is_super_admin($userId);
			$localize_script['is_super_admin'] = 0;
			if ($is_super_admin === true) {
				
				$localize_script['is_super_admin'] = 1;
				if(function_exists('get_sites') && class_exists('WP_Site_Query') && $isExtensionsValid === false){
					
					switch_to_blog(SITE_ID_CURRENT_SITE);
					$super_subscriptions = $this->getSubscriptions();
					$localize_script['super_customer_id'] = $super_subscriptions['customer_id_for_subscriptions'];
					$localize_script['super_email'] = $super_subscriptions['customer_email_for_subscriptions'];
					restore_current_blog();
					
				}
				
			}
			**/
			$localize_script['is_super_admin'] = 1;
			if (function_exists('get_sites') && class_exists('WP_Site_Query') && $isExtensionsValid === false) {
				
				$id = SITE_ID_CURRENT_SITE;
				$sites = get_sites();
				foreach ((array) $sites as $site) {
					
					if (is_main_site($site->id) === true) {
						
						$id = $site->id;
						break;
						
					}
					
				}
				#var_dump($id);
				
				switch_to_blog(SITE_ID_CURRENT_SITE);
				$super_subscriptions = $this->getSubscriptions();
				$localize_script['super_customer_id'] = $super_subscriptions['customer_id_for_subscriptions'];
				$localize_script['super_email'] = $super_subscriptions['customer_email_for_subscriptions'];
				restore_current_blog();
				
			}
			
			$p_v = "?p_v=".$this->plugin_version;
			wp_enqueue_style('control_css', plugin_dir_url( __FILE__ ).'css/Control.css', array(), $this->plugin_version);
			wp_enqueue_style('control_for_madia_css', plugin_dir_url( __FILE__ ).'css/Control_for_madia.css', array(), $this->plugin_version);
			wp_enqueue_script('Error_js', plugin_dir_url( __FILE__ ).'js/Error.js'.$p_v);
			wp_enqueue_script('i18n_js', plugin_dir_url( __FILE__ ).'js/i18n.js'.$p_v);
			wp_enqueue_script('XMLHttp_js', plugin_dir_url( __FILE__ ).'js/XMLHttp.js'.$p_v);
			wp_enqueue_script('Confirm_js', plugin_dir_url( __FILE__ ).'js/Confirm.js'.$p_v);
			wp_enqueue_script('Calendar_js', plugin_dir_url( __FILE__ ).'js/Calendar.js'.$p_v);
			wp_enqueue_script('Subscription_manage', plugin_dir_url( __FILE__ ).'js/Subscription_manage.js'.$p_v);
			wp_localize_script('Subscription_manage', $this->prefix.'dictionary', $dictionary);
			wp_localize_script('Subscription_manage', 'subscription_data', $localize_script);
			
			?>
				<div id="subscription_page" class="wrap">
					<div class="title"><?php _e("Subscription", $pluginName); ?></div>
					<table id="subscriptionDetailsTable" class="emails_table table_option wp-list-table widefat fixed striped">
						<tr>
							<th><?php _e("ID", $pluginName); ?></th>
							<td><?php print $subscriptions['customer_id_for_subscriptions']; ?></td>
						</tr>
						<tr>
							<th><?php _e("Subscriptions ID", $pluginName); ?></th>
							<td><?php print $subscriptions['id_for_subscriptions']; ?></td>
						</tr>
						<tr>
							<th><?php _e("Expiration date", $pluginName); ?></th>
							<td><?php print $subscriptions['expiration_date']; ?></td>
						</tr>
					</table>
					
					<table id="subscriptionInputTable" class="emails_table table_option wp-list-table widefat fixed striped hidden_panel">
						<tr>
							<th><?php _e("ID", $pluginName); ?></th>
							<td><div id="customer_id"></div></td>
						</tr>
						<tr>
							<th><?php _e("Customers email", $pluginName); ?></th>
							<td><div id="email"></div></td>
						</tr>
					</table>
					
					<div style="padding: 10px 0;">
						<!--
						<button id="addSubscription" class="media-button button-primary button-large media-button-insert hidden_panel" value=""><?php _e('Add a new subscription', $pluginName); ?></button>
						-->
						<button id="cancelSubscription" class="media-button button-primary button-large media-button-insert hidden_panel" value=""><?php _e('Cancel this subscription', $pluginName); ?></button>
						<button id="sendSubscription" class="media-button button-primary button-large media-button-insert hidden_panel" value=""><?php _e('Payment a new subscription', $pluginName); ?></button>
					</div>
					
				</div>
				<div id="loadingPanel" class="hidden_panel">
					<div class="loader">
						<svg viewBox="0 0 64 64" width="64" height="64">
							<circle id="spinner" cx="32" cy="32" r="28" fill="none"></circle>
						</svg>
					</div>
				</div>
			<?php
			
		}
		
		public function update_data($key, $value) {
			
			if (get_option($key) === false) {
							
				add_option($key, $value);
					
			} else {
				
				update_option($key, $value);
				
			}
			
		}
		
		public function wp_ajax_booking_package_for_public(){
			
			if (isset($_POST['nonce']) && check_ajax_referer($this->action_public."_ajax", 'nonce', false)) {
				
            	require_once(plugin_dir_path( __FILE__ ) . 'lib/Setting.php');
				require_once(plugin_dir_path( __FILE__ ) . 'lib/Schedule.php');
				require_once(plugin_dir_path( __FILE__ ) . 'lib/CreditCard.php');
				#require_once(plugin_dir_path( __FILE__ ) . 'lib/paypal/Braintree.php');
				$setting = new booking_package_setting($this->prefix, $this->plugin_name);
				$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
				
				date_default_timezone_set($this->getTimeZone());
				if (isset($_POST['accountKey'])) {
					
					$calendarAccount = $schedule->getCalendarAccount($_POST['accountKey']);
					if (isset($calendarAccount['timezone']) && $calendarAccount['timezone'] != 'none') {
						
						if (date_default_timezone_set($calendarAccount['timezone'])) {
							
							$this->timezone = $calendarAccount['timezone'];
							
						}
						
					}
					
				}
				
            	$response = array('status' => 'error', 'mode' => $_POST['mode']);
            	
            	if ($_POST['mode'] == $this->prefix.'getReservationData') {
            		
					$response = $schedule->getReservationData($_POST['month'], $_POST['day'], $_POST['year'], false, true);
            		
            	}
            	
            	if ($_POST['mode'] == 'getReservationData') {
            		
					$response = $schedule->getReservationData($_POST['month'], $_POST['day'], $_POST['year'], false, true);
            		
            	}
            	
            	if ($_POST['mode'] == 'intentForStripe') {
            		
            		$response = $schedule->intentForStripe();
            		
            	}
            	
            	if ($_POST['mode'] == 'sendBooking') {
            		
					$response = $schedule->sendBooking();
            		
            	}
            	
            	if ($_POST['mode'] == 'scriptError') {
					
					$response = $schedule->scriptError($_POST);
					
				}
				
				if ($_POST['mode'] == 'createUser') {
					
					$response = $schedule->createUser(0, $_POST['accountKey']);
					
				}
				
				if ($_POST['mode'] == 'user_login_for_frontend') {
					
					$response = $schedule->user_login_for_frontend($_POST['user_login'], $_POST['user_password'], $_POST['remember']);
					
				}
				
				if ($_POST['mode'] == 'logout') {
					
					$response = $schedule->logout();
					
				}
				
				if ($_POST['mode'] == 'updateUser') {
					
					$response = $schedule->updateUser(0, $_POST['accountKey']);
					
				}
				
				if ($_POST['mode'] == 'createCustomer') {
					
					$response = $schedule->createCustomer();
					
				}
				
				if ($_POST['mode'] == 'deleteSubscription') {
					
					$response = $schedule->deleteSubscription($_POST['product']);
					
				}
				
				if ($_POST['mode'] == 'deleteUser') {
					
					$response = $schedule->deleteUser(0);
					
				}
				
				if ($_POST['mode'] == 'cancelBookingData' && isset($_POST['key']) && isset($_POST['token'])) {
					
					$response = $schedule->cancelBookingData(intval($_POST['key']), $_POST['token'], 'canceled');
					
				}
				
				if ($_POST['mode'] == 'getUsersBookedList') {
					
					$user = $schedule->get_user();
					if (intval($user['status']) == 1 && intval($user['user']['current_member_id']) == intval($_POST['user_id'])) {
						
						$response = $schedule->getUsersBookedList($_POST['user_id'], $_POST['offset'], true);
						$response['reload'] = 0;
						
					} else {
						
						$response = array('status' => 'error', 'reload' => 1);
						
					}
					
				}
				
				if ($_POST['mode'] == 'cancelUserBooking') {
					
					$user = $schedule->get_user();
					if (intval($user['status']) == 1 && intval($user['user']['current_member_id']) == intval($_POST['user_id'])) {
						
						$response = $schedule->updateStatus($_POST['key'], $_POST['token'], 'canceled');
						$response['reload'] = 0;
						
					} else {
						
						$response = array('status' => 'error', 'reload' => 1);
						
					}
					
				}
				
				if ($this->getPhpVersion() <= 5.4) {
					
					print json_encode($response);
					
				} else {
					
					print json_encode($response, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
					
				}
            	
				
				$this->jsonAndPhpError($response);
				
			} else {
				
				#print json_encode(array('status' => 'error', 'mode' => $_POST['mode'], "message" => __("The nonce has been invalidated. Please reload the page.", $this->plugin_name)));
				print json_encode(array('status' => 'error', 'mode' => $_POST['mode'], "message" => "The nonce has been invalidated. Please reload the page."));
				
			}
			
			die();
			
		}
		
		public function wp_ajax_booking_package(){
			
			if (isset($_POST['nonce']) && check_ajax_referer($this->action_control."_ajax", 'nonce')) {
				
				$response = $this->choeseMode();
				if ($this->getPhpVersion() <= 5.4) {
					
					print json_encode($response);
					
				} else {
					
					print json_encode($response, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
					
				}
				$this->jsonAndPhpError($response);
				
			}
			
			die();
			
		}
		
		public function choeseMode(){
			
			$response = array('status' => 'error', 'mode' => $_POST['mode']);
			
			require_once(plugin_dir_path( __FILE__ ) . 'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ) . 'lib/Schedule.php');
			require_once(plugin_dir_path( __FILE__ ) . 'lib/CreditCard.php');
			
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
			date_default_timezone_set($this->getTimeZone());
        	if (isset($_POST['accountKey'])) {
        		
        		$calendarAccount = $schedule->getCalendarAccount($_POST['accountKey']);
        		if (isset($calendarAccount['timezone']) && $calendarAccount['timezone'] != 'none') {
        			
        			if (date_default_timezone_set($calendarAccount['timezone'])) {
        				
        				$this->timezone = $calendarAccount['timezone'];
        				
        			}
        			
        		}
        		
        	}
        	
        	if ($_POST['mode'] == 'getUsersBookedList') {
        		
        		$response = $schedule->getUsersBookedList($_POST['user_id'], $_POST['offset'], false);
        		
        	}
			
			if ($_POST['mode'] == 'createUser') {
				
				$response = $schedule->createUser(1, null);
				
			}
			
			if ($_POST['mode'] == 'updateUser') {
				
				$response = $schedule->updateUser(1, null);
				
			}
			
			if ($_POST['mode'] == 'getMembers') {
				
				$response = $schedule->get_users($_POST['authority'] ,$_POST['offset'], $_POST['number']);
				
			}
			
			if ($_POST['mode'] == 'deleteUser') {
				
				$response = $schedule->deleteUser(1);
				
			}
			
			if ($_POST['mode'] == 'getRegularHolidays') {
				
				$startOfWeek = get_option('start_of_week', 0);
				$response = $schedule->getRegularHolidays($_POST['month'], $_POST['year'], $_POST['accountKey'], $startOfWeek);
				
			}
			
			if ($_POST['mode'] == 'updateRegularHolidays') {
				
				$response = $schedule->updateRegularHolidays();
				
			}
			
			if ($_POST['mode'] == 'setting') {
				
				$response = $setting->update($_POST);
				$response['status'] = 'success';
				
			}
			
			if ($_POST['mode'] == 'updateMemberSetting') {
				
				$response = $setting->updateMemberSetting();
				
			}
			
			if ($_POST['mode'] == 'refreshToken') {
				
				if (isset($_POST['accountKey'])) {
					
					$response = $schedule->refreshIcalToken($_POST['accountKey']);
					
				} else {
					
					$response = $setting->refreshToken($_POST['key']);
					
				}
				
			}
			
			if ($_POST['mode'] == 'getIcalToken') {
				
				$response = $schedule->getIcalToken($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'updateIcalToken') {
				
				$response = $schedule->updateIcalToken($_POST['accountKey']);
				
			}
				
			if ($_POST['mode'] == 'getCourseList') {
				
				$response = $setting->getCourseList($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == $this->prefix.'addCourse') {
				
				$response = $setting->addCourse($_POST);
				
			}
			
			if ($_POST['mode'] == $this->prefix.'updateCourse') {
				
				$response = $setting->updateCourse($_POST);
				
			}
			
			if ($_POST['mode'] == 'getGuestsList') {
				
				$response = $setting->getGuestsList($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'updateGuests') {
				
				$response = $setting->updateGuests($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'addGuests') {
				
				$response = $setting->addGuests($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'deleteGuestsItem') {
				
				$response = $setting->deleteGuestsItem($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'changeGuestsRank') {
				
				$response = $setting->changeGuestsRank($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'getOptionsForHotel') {
				
				$response = $setting->getOptionsForHotel($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'addOptionsForHotel') {
				
				$response = $setting->addOptionsForHotel($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'updateOptionsForHotel') {
				
				$response = $setting->updateOptionsForHotel($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'deleteOptionsForHotel') {
				
				$response = $setting->deleteOptionsForHotel($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'changeOptionsForHotelRank') {
				
				$response = $setting->changeOptionsForHotelRank($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'copyCourse') {
				
				$response = $setting->copyCourse($_POST);
				
			}
			
			if ($_POST['mode'] == 'deleteCourse') {
				
				$response = $setting->deleteCourse($_POST);
				
			}
			
			if ($_POST['mode'] == 'changeCourseRank') {
				
				$response = $setting->changeCourseRank($_POST);
				
			}
			
			if ($_POST['mode'] == 'getForm') {
				
				$response = $setting->getForm($_POST['accountKey'], false);
				
			}
			
			if ($_POST['mode'] == 'addForm') {
				
				$response = $setting->addForm($_POST);
				
			}
			
			if ($_POST['mode'] == 'updateForm') {
				
				$response = $setting->updateForm($_POST);
				
			}
			
			if ($_POST['mode'] == 'deleteFormItem') {
				
				$response = $setting->deleteFormItem($_POST);
				
			}
			
			if ($_POST['mode'] == 'changeFormRank') {
				
				$response = $setting->changeFormRank($_POST);
				
			}
			
			if ($_POST['mode'] == 'updataEmailMessageForCalendarAccount') {
				
				$response = $setting->updataEmailMessageForCalendarAccount();
				
			}
			
			if ($_POST['mode'] == 'updataEmailMessage') {
				
				$response = $setting->updataEmailMessage($_POST['key'], $_POST['subject'], $_POST['content'], $_POST['enable'], $_POST['format']);
				
			}
			
			if ($_POST['mode'] == 'upgradePlan') {
				
				$response = $setting->upgradePlan($_POST['type']);
				
			}
			
			if ($_POST['mode'] == 'getEmailMessageList' && isset($_POST['accountKey'])) {
				
				$response = $setting->getEmailMessageList($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'scriptError') {
				
				$response = $schedule->scriptError($_POST);
				
			}
			
			if ($_POST['mode'] == 'getTemplateSchedule') {
				
				$response = $schedule->getTemplateSchedule($_POST['weekKey']);
				
			}
			
			if ($_POST['mode'] == 'getRangeOfSchedule') {
				
				$response = $schedule->getRangeOfSchedule($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'updateRangeOfSchedule') {
				
				$response = $schedule->updateRangeOfSchedule($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'getPublicSchedule') {
				
				$response = $schedule->getPublicSchedule();
				
			}
			
			if ($_POST['mode'] == 'deletePublishedSchedules') {
				
				$response = $schedule->deletePublishedSchedules(intval($_POST['accountKey']));
				
			}
			
			if ($_POST['mode'] == 'getCalendarAccountListData') {
				
				$response = $schedule->getCalendarAccountListData();
				
			}
			
			if ($_POST['mode'] == 'addCalendarAccount') {
				
				$response = $schedule->addCalendarAccount();
				
			}
			
			if ($_POST['mode'] == 'updateCalendarAccount') {
				
				$response = $schedule->updateCalendarAccount();
				
			}
			
			if ($_POST['mode'] == 'deleteCalendarAccount') {
				
				$response = $schedule->deleteCalendarAccount();
				
			}
			
			if ($_POST['mode'] == 'createCloneCalendar') {
				
				$response = $schedule->createCloneCalendar();
				
			}
			
			if ($_POST['mode'] == 'getAccountScheduleData') {
				
				if (isset($_POST['createSchedules']) && intval($_POST['createSchedules']) == 1) {
					
					$schedule->insertAccountSchedule(date('n'), date('j'), date('Y'), $_POST['accountKey']);
					
				}
				$response = $schedule->getAccountScheduleData();
				
			}
			
			if ($_POST['mode'] == 'updateAccountTemplateSchedule') {
				
				$list = $schedule->updateAccountTemplateSchedule();
				#$response['templateSchedules'] = $list;
				$response['status'] = 'success';
				$response['list'] = $list;
				
			}
			
			if ($_POST['mode'] == 'updateAccountSchedule') {
				
				$list = $schedule->updateAccountSchedule();
				$response['status'] = 'success';
				
			}
			
			if ($_POST['mode'] == $this->prefix.'getReservationData') {
				
				if (isset($_POST['accountKey'])) {
					
					if (isset($_POST['createSchedules']) && intval($_POST['createSchedules']) == 1) {
						
						$schedule->insertAccountSchedule(date('n'), date('j'), date('Y'), $_POST['accountKey']);
						
					}
					$expire = date('U') + (30 * 24 * 3600);
					setcookie($this->prefix.'accountKey', $_POST['accountKey'], $expire);
					$response = $schedule->getReservationData($_POST['month'], $_POST['day'], $_POST['year']);
					$response['formData'] = $setting->getForm($_POST['accountKey'], true);
					$response['courseList'] = $setting->getCourseList($_POST['accountKey']);
					$response['guestsList'] = $setting->getGuestsList($_POST['accountKey'], true);
					$response['taxes'] = $setting->getTaxes($_POST['accountKey']);
					$response['account'] = $schedule->getCalendarAccount($_POST['accountKey']);
					$emailEnableList = $setting->getEmailMessageList($_POST['accountKey']);
					$response['emailEnableList'] = $emailEnableList['emailMessageList'];
					
				} else {
					
					$response = $schedule->getReservationData($_POST['month'], $_POST['day'], $_POST['year']);
					
				}
				
			}
			
			if ($_POST['mode'] == 'getDownloadCSV') {
				
				$response = $schedule->getDownloadCSV();
				
			}
			
			if ($_POST['mode'] == 'sendBooking') {
				
				$response = $schedule->sendBooking(true);
				$response['guestsList'] = $setting->getGuestsList($_POST['accountKey'], true);
				$response['account'] = $schedule->getCalendarAccount($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'deleteBookingData') {
				
				$bookingDetailsOnVisitor = $schedule->getBookingDetailsOnVisitor($_POST['key'], $_POST['token']);
				if ($bookingDetailsOnVisitor['status'] == 'error') {
					
					$response = $bookingDetailsOnVisitor;
					
				} else {
					
					$myBookingDetails = $bookingDetailsOnVisitor['details'];
					$response = $schedule->deleteBookingData($_POST['key'], $myBookingDetails['accountKey'], false, true, $_POST['sendEmail']);
					$response['guestsList'] = $setting->getGuestsList($_POST['accountKey'], true);
					$response['account'] = $schedule->getCalendarAccount($_POST['accountKey']);
					
				}
	    		
			}
			
			if ($_POST['mode'] == 'updateBooking') {
				
				$response = $schedule->updateBooking(true);
				$response['guestsList'] = $setting->getGuestsList($_POST['accountKey'], true);
				$response['account'] = $schedule->getCalendarAccount($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'updateStatus') {
				
				$response = $schedule->updateStatus($_POST['key'], $_POST['token'], $_POST['newStatus']);
				if (intval($_POST['reload']) == 1) {
					$response['guestsList'] = $setting->getGuestsList($_POST['accountKey'], true);
					$response['account'] = $schedule->getCalendarAccount($_POST['accountKey']);
				}
					
			}
			
			if ($_POST['mode'] == 'lookingForSubscription') {
				
				$response = $setting->lookingForSubscription();
				
			}
			
			if ($_POST['mode'] == 'payNewSubscriptions') {
				
				$response = $setting->payNewSubscriptions();
				
			}
			
			if ($_POST['mode'] == 'deleteSubscription') {
				
				$response = $schedule->deleteSubscription($_POST['product'], $_POST['userId']);
				
			}
			
			if ($_POST['mode'] == 'getSubscriptions') {
				
				$response = $setting->getSubscriptions();
				
			}
			
			if ($_POST['mode'] == 'addSubscriptions') {
				
				$response = $setting->addSubscriptions();
				
			}
			
			if ($_POST['mode'] == 'updateSubscriptions') {
				
				$response = $setting->updateSubscriptions();
				
			}
			
			if ($_POST['mode'] == 'changeSubscriptionsRank') {
				
				$response = $setting->changeSubscriptionsRank();
				
			}
			
			if ($_POST['mode'] == 'getTaxes') {
				
				$response = $setting->getTaxes($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'addTaxes') {
				
				$response = $setting->addTaxes($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'updateTaxes') {
				
				$response = $setting->updateTaxes($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'deleteTaxes') {
				
				$response = $setting->deleteTaxes($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'changeTaxesRank') {
				
				$response = $setting->changeTaxesRank($_POST['accountKey']);
				
			}
			
			if ($_POST['mode'] == 'updateCss') {
				
				$response = $setting->updateCss('front_end.css');
				
			}
			
			if ($_POST['mode'] == 'updateJavaScript') {
				
				$response = $setting->updateJavaScript('front_end.js');
				
			}
			
			#print json_encode($response);
			return $response;
			
		}
		
		
		
		public function getDownloadCSV(){
			
			if (!current_user_can('manage_options') && !current_user_can('edit_pages') && (!defined('DOING_AJAX') || !DOING_AJAX)) {
				
				wp_die(__('You are not allowed to access this part of the site'));
				
			} else {
				
				$nonce = $_POST['nonce'];
				if (!wp_verify_nonce( $nonce, $this->action_control."_download")) {
					
					die( 'Security check' ); 
					
				} else {
					
					global $wpdb;
					$characterCodeOfDownloadFile = get_option($this->prefix."characterCodeOfDownloadFile", "UTF-8");
					header("Content-Type: application/octet-stream");
					header("Content-Disposition: attachment; filename=\"List.csv\"");
					require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
					$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
					$data = $schedule->getDownloadCSV();
					$str = $data['csv'];
					if($characterCodeOfDownloadFile != 'UTF-8' && function_exists('mb_convert_encoding')){
						
						$str = mb_convert_encoding($data['csv'], $characterCodeOfDownloadFile, 'UTF-8');
						
					}
					
					echo $str;
					
				}
				die();
				
			}
			
		}
		
		
		public function getSubscriptions(){
			
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			$subscriptions = $setting->upgradePlan('get');
			unset($subscriptions["status"]);
			/**
			var_dump($subscriptions);
			foreach((array) $subscriptions as $key => $value){
				
				$subscriptions[$key] = 0;
				
			}
			**/
			return $subscriptions;
			
		}
		
		public function upgradeButton($isExtensionsValid = false){
			
			if($isExtensionsValid === true){
				
				return $isExtensionsValid;
				
			}
			
			if ($this->is_owner_site == 0) {
				
				return false;
				
			}
			
			$uri = plugin_dir_url( __FILE__ );
			$parse_url = parse_url($uri);
			$locale = get_locale();
			$dictionary = $this->getDictionary("Upgrade_js", $this->plugin_name);
			
			$timezone = $this->timezone;
			$upgradeDetail = array("extension_url" => BOOKING_PACKAGE_EXTENSION_URL, "timeZone" => $timezone, "local" => get_locale(), "site" => get_site_url(), "stripe_public_key" => BOOKING_PACKAGE_STRIPE_PUBLIC_KEY, "locale" => $locale, "plugin_v" => $this->plugin_version);
			
			$subscriptions = $this->getSubscriptions();
			foreach ((array) $subscriptions as $key => $value) {
				
				$upgradeDetail[$key] = $value;
				
			}
			
			$upgradeDetail['secure'] = 0;
			if($parse_url['scheme'] == 'https'){
				
				$upgradeDetail['secure'] = 1;
				
			}
			#$pluginUrl = $_SERVER['HTTP_X_FORWARDED_PROTO'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$pluginUrl = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
			#$upgradeDetail['pluginUrl'] = $pluginUrl;
			$upgradeDetail['pluginUrl'] = site_url();
			$pluginName = $this->plugin_name;
			
			echo '<form action="https://saasproject.net/upgrade/" method="post" style="float: right;">';
			$posts = array("extension_url", "local", "timeZone", "site", "pluginUrl", "plugin_v");
			for($i = 0; $i < count($posts); $i++){
				
				$key = $posts[$i];
				if (isset($upgradeDetail[$key])) {
					
					echo '<input type="hidden" name="'.$key.'" value="'.$upgradeDetail[$key].'">';
					
				}
				
			}
			
			echo '<input type="hidden" name="getUpgradeUrl" value="'.BOOKING_PACKAGE_EXTENSION_URL.'">';
			echo '<input id="upgradeSubmit" type="submit" class="media-button button-primary button-large media-button-insert" value="'.__('Get subscription', $pluginName).'">';
			echo '</form>';
			
			?>
			<div id="upgradePanel" class="edit_modal hidden_panel">
				<button type="button" id="upgrade_media_modal_close" class="media_modal_close">
					<span class="media_modal_icon"><span class="material-icons">close</span></span>
				</button>
				<div class="edit_modal_content">
					<div id="upgrade_menu_panel" class="media_frame_menu">
						<div id="upgrade_media_menu" class="media_menu"></div>
					</div>
					<div id="upgrade_media_title" class="media_frame_title"><h1 id="upgrade_edit_title"><?php _e('Upgrade', $pluginName); ?></h1></div>
					<div id="upgrade_media_router" class="media_frame_router">
						<div id="upgrade_content_panel">
							
						</div>
					</div>
					<div id="upgrade_frame_toolbar" class="media_frame_toolbar">
						<div class="media_toolbar">
							<div id="upgrade_buttonPanel" class="media_toolbar_primary" style="float: initial;">
								<div id="upgrade_leftButtonPanel"></div>
								<div id="upgrade_rightButtonPanel"></div>
							</div>
						</div>
					</div>
					
				</div>
				
			</div>
			
			<div id="upgrade_blockPanel" class="edit_modal_backdrop hidden_panel"></div>
			
			<?php
			
		}
		
		public function ical_feeds(){
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Ical.php');
			
			$id = 'all';
			if(isset($_GET['id'])) {
				
				$id = $_GET['id'];
				
			}
			
			$ical = new booking_package_iCal($this->prefix, $this->plugin_name);
			$ical->isValid($_GET['ical'], $id);
			
			die();
			
		}
		
		public function webhook(){
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Webhook.php');
			
			$target = sanitize_text_field($_GET["weebhook"]);
			$HTTP_X_GOOG_CHANNEL_ID = sanitize_text_field($_SERVER['HTTP_X_GOOG_CHANNEL_ID']);
			$HTTP_X_GOOG_CHANNEL_TOKEN = sanitize_text_field($_SERVER['HTTP_X_GOOG_CHANNEL_TOKEN']);
			
			$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
			$googleCalendarDeteils = $schedule->lookingForGoogleCalendarId($HTTP_X_GOOG_CHANNEL_ID);
			
			#lookingForGoogleCalendarId
			#if(get_option($this->prefix."id_for_google_webhook") == $HTTP_X_GOOG_CHANNEL_ID && get_option($this->prefix."token_for_google_webhook") == $HTTP_X_GOOG_CHANNEL_ID){
			
			if($googleCalendarDeteils['idForGoogleWebhook'] == $HTTP_X_GOOG_CHANNEL_ID){
				
				$webhook = new booking_package_webhook($this->prefix, $this->plugin_name);
				$webhook->catchWebhook($target, $HTTP_X_GOOG_CHANNEL_ID, $_POST);
				exit;
				
			}
			
		}
		
		public function localizeScript($mode){
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Webhook.php');
            require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
            
            if (isset($_GET['debug']) && intval($_GET['debug']) == 1) {
            	
            	$this->dubug_javascript = 1;
            	
            }
            
            $schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
            $setting = new booking_package_setting($this->prefix, $this->plugin_name);
            $locale = get_locale();
            $javascriptSyntaxErrorNotification = get_option($this->prefix."javascriptSyntaxErrorNotification", 1);
            
            $javascriptFileslist = array();
            $dir = plugin_dir_path( __FILE__ ).'js/';
			if($handle = opendir($dir)){
				
				while(($file = readdir($handle)) !== false){
					
					if(filetype($path = $dir.$file) == "file"){
						
						array_push($javascriptFileslist, $file);
						
					}
					
				}
				
			}
            
            $startOfWeek = get_option('start_of_week', 0);
            
            $localize_script = array();
			if ($mode == 'adomin') {
				
				$dashboardRequest = array('status' => 0);
				if (isset($_GET['key']) && isset($_GET['calendar']) && isset($_GET['month']) && isset($_GET['day']) && isset($_GET['year'])) {
					
					$dashboardRequest = array(
						'status' => 1, 
						'key' => intval($_GET['key']), 
						'calendar' => intval($_GET['calendar']), 
						'month' => intval($_GET['month']), 
						'day' => intval($_GET['day']), 
						'year' => intval($_GET['year'])
					);
					
				}
				
				
				$list = $setting->getList();
				$courseList = $setting->getCourseList();
				$emailMessageList = $setting->getEmailMessage(array('enable'));
				//$formData = $setting->getForm();
				
				$courseBool = get_option($this->prefix."courseBool", "false");
				$courseName = get_option($this->prefix."courseName", "false");
				$dateFormat = get_option($this->prefix."dateFormat", "0");
				$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
				
				$list['General'][$this->prefix . 'clock']['value'] = $this->changeTimeFormat($list['General'][$this->prefix . 'clock']['value']);
				
				$localize_script = array(
					'url' => admin_url('admin-ajax.php'), 
					'action' => $this->action_control, 
					'nonce' => wp_create_nonce($this->action_control."_ajax"), 
					'nonce_download' => wp_create_nonce($this->action_control."_download"), 
					'prefix' => $this->prefix,
					'courseBool' => $courseBool, 
					'courseName' => $courseName, 
					'year' => date('Y'), 
					'month' => date('m'), 
					'day' => date('d'), 
					'locale' => $locale,
					'courseList' => $courseList, 
					'country' => $list['General']['booking_package_country']['value'],
					'currency' => $list['General']['booking_package_currency']['value'],
					'clock' => $list['General']['booking_package_clock']['value'],
					'dateFormat' => $dateFormat,
					'positionOfWeek' => $positionOfWeek,
					'formData' => array(),
					'calendarAccountList' => $schedule->getCalendarAccountListData(),
					'is_mobile' => $this->is_mobile,
					'dashboardRequest' => $dashboardRequest,
					'bookingBool' => 1,
					'emailEnable' => $emailMessageList,
					'javascriptSyntaxErrorNotification' => $javascriptSyntaxErrorNotification,
					'javascriptFileslist' => $javascriptFileslist,
					'visitorSubscriptionForStripe' => $this->visitorSubscriptionForStripe,
					'startOfWeek' => $startOfWeek,
					'debug' => $this->dubug_javascript,
				);
				
				
			} else if ($mode == 'schedule_page') {
				
				$courseData = $setting->getCourseData();
				$subscriptionsData = $setting->getSubscriptionsData();
				$formInputType = $setting->getFormInputType();
				$emailMessageList = $setting->getEmailMessage();
				
				if ($this->groupOfInputField == 0) {
					
					unset($formInputType['groupId']);
					
				}
				
				$schedule->deleteOldDaysInSchedules();
				$timestamp = $schedule->getTimestamp();
				
				$dateFormat = get_option($this->prefix."dateFormat", "0");
				$courseBool = get_option($this->prefix."courseBool", "false");
				$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
				
				$elementForCalendarAccount = $setting->getElementForCalendarAccount();
				
				if ($this->visitorSubscriptionForStripe == 0) {
					
					unset($elementForCalendarAccount['subscriptionIdForStripe']);
					unset($elementForCalendarAccount['subscriptionIdForPayPal']);
					unset($elementForCalendarAccount['termsOfServiceForSubscription']);
					#unset($elementForCalendarAccount['enableTermsOfServiceForSubscription']);
					unset($elementForCalendarAccount['privacyPolicyForSubscription']);
					#unset($elementForCalendarAccount['enablePrivacyPolicyForSubscription']);
					
					
				}
				
				if ($this->multipleRooms == 0) {
					
					unset($elementForCalendarAccount['multipleRooms']);
					
				}
				
				
				$thanksPages = array('0' => __('Select', $this->plugin_name));
				$pages = get_pages(array('meta_key' => 'booking-package', 'meta_value' => 'front-end'));
				foreach ((array) $pages as $key => $value) {
					
					$thanksPages[$value->ID] = $value->post_title;
					
				}
				$elementForCalendarAccount['servicesPage']['valueList'] = $thanksPages;
				$elementForCalendarAccount['calenarPage']['valueList'] = $thanksPages;
				$elementForCalendarAccount['schedulesPage']['valueList'] = $thanksPages;
				$elementForCalendarAccount['visitorDetailsPage']['valueList'] = $thanksPages;
				$elementForCalendarAccount['thanksPage']['valueList'] = $thanksPages;
				//$elementForCalendarAccount['redirectPage']['valueList'] = $thanksPages;
				$redirectPages = array();
				foreach ((array) $thanksPages as $key => $value) {
					
					$redirectPages[$key] = array('key' => $key, 'name' => $value);
					
				}
				$elementForCalendarAccount['redirect_Page']['valueList'][1]['valueList'] = $redirectPages;
				$list = array();
				$localize_script = array(
					'url' => admin_url('admin-ajax.php'), 
					'action' => $this->action_control, 
					'nonce' => wp_create_nonce($this->action_control."_ajax"), 
					'prefix' => $this->prefix,
					'courseBool' => $courseBool, 
					'year' => date('Y'), 
					'month' => date('m'), 
					'locale' => $locale, 
					'dateFormat' => $dateFormat, 
					'positionOfWeek' => $positionOfWeek,
					'list' => $list, 
					'formInputType' => $formInputType, 
					'courseData' => $courseData,
					'subscriptionsData' => $subscriptionsData,
					'taxesData' => $setting->getTaxesData(),
					'optionsForHotel' => $this->optionsForHotel,
					'optionsForHotelData' => $setting->getOptionsForHotelData(),
					'elementForCalendarAccount' => $elementForCalendarAccount, 
					'guestsInputType' => $setting->guestsInputType(),
					'is_mobile' => $this->is_mobile,
					'javascriptSyntaxErrorNotification' => $javascriptSyntaxErrorNotification,
					'javascriptFileslist' => $javascriptFileslist,
					'visitorSubscriptionForStripe' => $this->visitorSubscriptionForStripe,
					'timestamp' => $timestamp,
					'startOfWeek' => $startOfWeek,
					'currency' => get_option($this->prefix."currency", "usd"),
					'timezone' => get_option($this->prefix . "timezone", "UTC"),
					'debug' => $this->dubug_javascript,
				);
				
			} else if ($mode == 'setting_page') {
				
				$list = $setting->getList();
				$booking_sync = $setting->getBookingSyncList();
				$member_setting = $setting->getMemberSetting(true);
				$emailMessageList = $setting->getEmailMessage();
				$dateFormat = get_option($this->prefix."dateFormat", "0");
				$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
				#$courseList = $setting->getCourseList();
				#$courseData = $setting->getCourseData();
				#$formInputType = $setting->getFormInputType();
				$countries = json_decode(file_get_contents(plugin_dir_path( __FILE__ ).'lib/Countries_with_Regional_Codes.json'), true);
				$list['General'][$this->prefix.'country']['valueList'] = $countries;
				ksort($list["General"][$this->prefix . "currency"]["valueList"]);
				if (isset($booking_sync['Google_Calendar'])) {
					
					$booking_sync['Google_Calendar']['parse_url'] = parse_url(get_home_url());
					
				}
				
				$timezone = get_option($this->prefix . "timezone", null);
				if (is_null($timezone)) {
					
					$timezone = get_option('timezone_string', 'UTC');
					$list['General'][$this->prefix . 'timezone']['value'] = $timezone;
					
				} else {
					
					$list['General'][$this->prefix . 'timezone']['value'] = $timezone;
					
				}
				
				$list['General'][$this->prefix . 'clock']['value'] = $this->changeTimeFormat($list['General'][$this->prefix . 'clock']['value']);
				
				$booking_sync['iCal']['booking_package_ical_token']['home'] = get_home_url();
				if (is_null($booking_sync['iCal']['booking_package_ical_token']['value']) === true || strlen($booking_sync['iCal']['booking_package_ical_token']['value']) == 0) {
					
					$tokenResponse = $setting->refreshToken("booking_package_ical_token");
					$booking_sync['iCal']['booking_package_ical_token']['value'] = $tokenResponse['token'];
					
				}
				
				$localize_script = array(
					'url' => admin_url('admin-ajax.php'), 
					'action' => $this->action_control, 
					'nonce' => wp_create_nonce($this->action_control."_ajax"), 
					'prefix' => $this->prefix,
					'locale' => $locale,
					'list' => $list, 
					'bookingSyncList' => $booking_sync, 
					'memberSetting' => $member_setting,
					"extension_url" => BOOKING_PACKAGE_EXTENSION_URL, 
					'dateFormat' => $dateFormat, 
					'positionOfWeek' => $positionOfWeek,
					/**
					'courseData' => $courseData, 
					'courseList' => $courseList, 
					'formInputType' => $formInputType, 
					'formData' => $formData, 
					'emailMessageList' => $emailMessageList,
					**/
					'is_mobile' => $this->is_mobile,
					'javascriptSyntaxErrorNotification' => $javascriptSyntaxErrorNotification,
					'javascriptFileslist' => $javascriptFileslist,
					'visitorSubscriptionForStripe' => $this->visitorSubscriptionForStripe,
					'regularHolidays' => $schedule->getRegularHolidays(date('m'), date('Y'), 'share', $startOfWeek),
					'nationalHolidays' => $schedule->getRegularHolidays(date('m'), date('Y'), 'national', $startOfWeek),
					'startOfWeek' => $startOfWeek,
					'is_owner_site' => $this->is_owner_site,
					'debug' => $this->dubug_javascript,
				);
				
			} else if ($mode == 'visitor') {
				
				$list = $setting->getList();
				$courseList = $setting->getCourseList();
				$emailMessageList = $setting->getEmailMessage(array('enable'));
				//$formData = $setting->getForm();
				
				$courseBool = get_option($this->prefix."courseBool", "false");
				$courseName = get_option($this->prefix."courseName", "false");
				$dateFormat = get_option($this->prefix."dateFormat", "0");
				$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
				$list['General'][$this->prefix . 'clock']['value'] = $this->changeTimeFormat($list['General'][$this->prefix . 'clock']['value']);
				
				$localize_script = array(
					'url' => admin_url('admin-ajax.php'), 
					#'url' => plugin_dir_url( __FILE__ ).'ajax.php',
					'action' => $this->action_public, 
					'nonce' => wp_create_nonce($this->action_public."_ajax"), 
					'prefix' => $this->prefix,
					'courseBool' => $courseBool, 
					'year' => date('Y'), 
					'month' => date('m'), 
					'day' => date('d'), 
					'courseList' => $courseList, 
					'country' => $list['General']['booking_package_country']['value'],
					'currency' => $list['General']['booking_package_currency']['value'],
					'clock' => $list['General']['booking_package_clock']['value'],
					'headingPosition' => $list['Design']['booking_package_headingPosition']['value'],
					'googleAnalytics' => $list['General']['booking_package_googleAnalytics']['value'],
					'dateFormat' => $dateFormat,
					'positionOfWeek' => $positionOfWeek,
					'formData' => array(),
					'locale' => $locale,
					'is_mobile' => $this->is_mobile,
					'javascriptSyntaxErrorNotification' => $javascriptSyntaxErrorNotification,
					'javascriptFileslist' => $javascriptFileslist,
					'visitorSubscriptionForStripe' => $this->visitorSubscriptionForStripe,
					'startOfWeek' => $startOfWeek,
					'bookedList' => 'userBookingDetails',
					'permalink' => get_permalink(),
					'debug' => $this->dubug_javascript,
					'plugin_v' => $this->plugin_version,
				);
				
			} else if ($mode == 'member') {
				
				$dateFormat = get_option($this->prefix."dateFormat", "0");
				$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
				$list = $setting->getList();
				$localize_script = array(
					'url' => admin_url('admin-ajax.php'), 
					#'url' => plugin_dir_url( __FILE__ ).'ajax.php',
					'action' => $this->action_public, 
					'nonce' => wp_create_nonce($this->action_public."_ajax"), 
					'prefix' => $this->prefix,
					'javascriptSyntaxErrorNotification' => $javascriptSyntaxErrorNotification,
					'javascriptFileslist' => $javascriptFileslist,
					'visitorSubscriptionForStripe' => $this->visitorSubscriptionForStripe,
					'currency' => $list['General']['booking_package_currency']['value'],
					'clock' => $list['General']['booking_package_clock']['value'],
					'startOfWeek' => $startOfWeek,
					'debug' => $this->dubug_javascript,
					'dateFormat' => $dateFormat,
					'positionOfWeek' => $positionOfWeek,
					'bookedList' => 1,
					
				);
				
			} else if ($mode == 'subscription_page') {
				
				$localize_script = array(
					'url' => admin_url('admin-ajax.php'), 
					'action' => $this->action_control, 
					'nonce' => wp_create_nonce($this->action_control."_ajax"), 
					'prefix' => $this->prefix,
					'javascriptSyntaxErrorNotification' => $javascriptSyntaxErrorNotification,
					'javascriptFileslist' => $javascriptFileslist,
					'visitorSubscriptionForStripe' => $this->visitorSubscriptionForStripe,
					'extension_url' => BOOKING_PACKAGE_EXTENSION_URL, 
					'is_owner_site' => $this->is_owner_site,
					'locale' => $locale,
					'site' => get_site_url(),
					'debug' => $this->dubug_javascript,
				);
				
			}
			
			$localize_script['referer_field'] = esc_attr(wp_unslash($_SERVER['REQUEST_URI']));
			
			return $localize_script;
			
		}
		
		/**
		public function app(){
			
			if($this->webApp == 0){
				
				print json_encode(array('status' => 'error'));
				die();
				
			}
			
			$p_v = "?p_v=".$this->plugin_version;
			header("Connection:Keep-Alive");
			header("Access-Control-Allow-Origin: *");
			
			if($_POST['app'] == 'download' || $_GET['app'] == 'download'){
				
				#var_dump(get_home_path());
				
				if($_POST['type'] == 'js' || $_GET['type'] == 'js' || $_POST['type'] == 'jquery' || $_GET['type'] == 'jquery'){
					
					header("Content-type: application/javascript; charset=utf-8");
					
				}else if($_POST['type'] == 'css' || $_GET['type'] == 'css'){
					
					header("Content-type: text/css; charset=utf-8");
					
				}
				
				
				$fileName = sanitize_text_field($_POST['file']);
				if(isset($_GET['file'])){
					
					$fileName = sanitize_text_field($_GET['file']);
					
				}
				
				$fileList = array();
				$dirList = array(plugin_dir_path( __FILE__ ).'js/', plugin_dir_path( __FILE__ ).'css/', __FILE__.'wp-includes/js/jquery/ui/');
				if($_POST['type'] == 'jquery' || $_GET['type'] == 'jquery'){
					
					$key = $this->prefix."home_path";
					$home_path = get_option($key);
					$dirList = array($home_path.'wp-includes/js/jquery/ui/');
					
				}
				
				for($i = 0; $i < count($dirList); $i++){
					
					$dir = $dirList[$i];
					if(is_dir($dir) && $handle = opendir($dir)){
						
						while(($file = readdir($handle)) !== false){
							
							if(filetype($path = $dir.$file) == "file"){
								
								$fileList[$file] = $path;
								
							}
							
						}
						
					}else{
						
						#echo __FILE__;
						
					}
					
				}
				
				if(isset($fileList[$fileName])){
					
					header('Content-Disposition: attachment; filename="'.$fileName.'"');
					$text = file_get_contents($fileList[$fileName]);
					print $text;
					
				}
				
			}else if($_POST['app'] == 'signon' || $_GET['app'] == 'signon'){
				
				header("Content-type: application/json; charset=utf-8");
				$response = $this->appLogin();
				header("Access-Control-Allow-Origin: *");
				print json_encode($response);
				
			}else if($_POST['app'] == 'localizeScript' || $_GET['app'] == 'localizeScript'){
				
				session_start();
				header("Content-type: application/json; charset=utf-8");
				$response = $this->appLogin();
				if(isset($response['status']) && $response['status'] == 'error'){
					
					print json_encode($response);
					die();
					
				}
				
				$url = site_url();
				#$url = admin_url();
				$nonce = wp_create_nonce('get_json_for_web_app');
				$nonceUrl = wp_nonce_url($url.'/', 'get_json_for_web_app', 'app_nonce' );
				#$nonceUrl .= '&_wp_http_referer='.esc_attr(wp_unslash($_SERVER['REQUEST_URI']));
				$response = array('user' => $response);
				$dictionary = array();
				$localizeScriptList = array('adomin', 'schedule_page', 'setting_page');
				for($i = 0; $i < count($localizeScriptList); $i++){
					
					$response[$localizeScriptList[$i]] = $this->localizeScript($localizeScriptList[$i]);
					$response[$localizeScriptList[$i]]['url'] = $nonceUrl;
					$dictionary = array_merge($dictionary, $this->getDictionary($localizeScriptList[$i], $this->plugin_name));
					
				}
				
				$response['dictionary'] = $dictionary;
				$response['wp_get_current_user'] = wp_get_current_user();
				$response['wp_get_session_token'] = wp_get_session_token();
				$response['session_id'] = session_id();
				$response['referer_field'] = esc_attr(wp_unslash($_SERVER['REQUEST_URI']));
				$response['nonce'] = $nonce;
				$response['wp_get_session_token'] = wp_get_session_token();
				$response['wp_nonce_tick'] = wp_nonce_tick();
				print json_encode($response);
				
			}else if($_POST['app'] == 'json' || $_GET['app'] == 'json'){
				
				$verify_nonce = wp_verify_nonce($_GET['app_nonce'], 'get_json_for_web_app');
				#$verify_nonce = check_ajax_referer($this->action_control."_ajax", $_POST['nonce']);
				if (isset($_GET['app_nonce']) && ($verify_nonce)){
					
					$response = $this->choeseMode();
					print json_encode($response);
					
				}else{
					
					#print wp_verify_nonce( $_GET['app_nonce'], 'get_json_for_web_app');
					$response['verify_nonce'] = $verify_nonce;
					$response['wp_get_current_user'] = wp_get_current_user();
					$response['wp_get_session_token'] = wp_get_session_token();
					$response['wp_get_referer'] = wp_get_referer();
					#$response['session_id'] = session_id();
					print json_encode($response);
					#print wp_referer_field(true);
					
				}
				
			}
			
			die();
			
		}
		**/
		
		public function appLogin(){
			
			$creds = array('user_login' => sanitize_text_field($_POST['user']), 'user_password' => sanitize_text_field($_POST['password']), 'remember' => true);
			if(isset($_GET['app'])){
				
				$creds = array('user_login' => sanitize_text_field($_GET['user']), 'user_password' => sanitize_text_field($_GET['password']), 'remember' => true);
				
			}
			
			$p_v = $this->plugin_version;
			$response = array();
			$user = wp_signon($creds, false);
			if(is_wp_error($user)){
				
				$response = array('status' => 'error', 'user' => $user, 'app_version' => $p_v);
				
			}else{
				
				$response = array('status' => 'error');
				$id = $user->data->ID;
				$user_nicename = $user->data->user_nicename;
				$allcaps = $user->allcaps;
				if(isset($allcaps['level_3']) && $allcaps['level_3'] === true){
					
					$response = array('status' => 'success', 'id' => $id, 'user_nicename' => $user_nicename, 'app_version' => $p_v);
					
				}
				
			}
			
			return $response;
			
		}
		
		public function cron_interval(){
			
			$time = 60 * 5;
			$schedules['retry_to_send_to_server'] = array(
        		'interval' => $time,
				'display'  => 'retry_to_send_to_server',
			);
 
    		return $schedules;
			
		}
		
		public function retry_to_send_to_server(){
			
			$name = $this->prefix."retry_to_send_to_server";
			$count = intval(get_option($name, 0));
			$count++;
			if($count == 1){
				
				add_option($name, $count);
				
			}else{
				
				update_option($name, $count);
				
			}
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
            $schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
            date_default_timezone_set($this->getTimeZone());
        	if (isset($_POST['accountKey'])) {
        		
        		$calendarAccount = $schedule->getCalendarAccount($_POST['accountKey']);
        		if (isset($calendarAccount['timezone']) && $calendarAccount['timezone'] != 'none') {
        			
        			$this->timezone = $timezone;
        			date_default_timezone_set($calendarAccount['timezone']);
        			
        		}
        		
        	}
            $schedule->retryToSendToServer();
			
		}
		
		public function deactivation_event(){
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			require_once(plugin_dir_path( __FILE__ ).'lib/Database.php');
			
			#$timestamp = wp_next_scheduled(array($this, 'retry_to_send_to_server'));
			#wp_unschedule_event($timestamp, array($this, 'retry_to_send_to_server'));
			wp_clear_scheduled_hook('retry_to_send_to_server');
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Setting.php');
			$setting = new booking_package_setting($this->prefix, $this->plugin_name);
			$setting->activation(BOOKING_PACKAGE_EXTENSION_URL, "deactivation");
			
			$database = new booking_package_database($this->prefix, $this->db_version);
			
		}
		
		public function help_schedule_page($id){
			
			$screen = get_current_screen();
			
			$screen->add_help_tab(array(
				'id'    => 'create_schedules',
				'title'   => 'Create a booking schedules', 
				'content' => '<p>How do I create and edit a booking schedule?</p><ol><li>Select the calendar you want to add schedule on “Calendar Setting” page.</li><li>Click the "Edit schedule by day of the week" button in the "Schedules" tab.</li></ol>'
			));
			
        	$screen->add_help_tab(array(
				'id'    => 'reflect_schedules',
				'title'   => 'Reflect schedules', 
				'content' => '<p>When the appointment is registered on the day of the week in the "Edit schedule by day of the week" panel Even if you change or add the schedule for that day, the result is not reflected in the calendar that has already been published. <br>To reflect the changed schedule Delete the day you want to reflect from the calendar.</p>'
			));
			$screen->add_help_tab(array(
				'id'    => 'delete_schedules',
				'title'   => 'Delete schedules', 
				'content' => '<p>To delete an appointment click the "Delete schedules" button or click the day.</p>'
			));
			
			$screen->add_help_tab(array(
				'id'    => 'link_schedule_and_service',
				'title'   => 'Link schedules and services', 
				'content' => '<p>How do i link booking schedules and services?</p><ol><li>Select the calendar you want to add services from the "Calendar Setting" page.</li><li>Click the "Service" tab and click the "Add service" button.</li><li>Then click "Setting" tab and set up "Enable the service function" and "Service name".</li></ol>'
			));
			#$screen->set_help_sidebar('<a href="https://easy-appointments.net/documentation/">More info!</a>');
			
			
		}
		
		public function createFirstCalendar(){
			
			require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
			$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
			$schedule->createFirstCalendar();
			
		}
		
		public function setHomePath(){
			
			if(function_exists('get_home_path')){
				
				$key = $this->prefix."home_path";
				if(get_option($key) === false){
								
					add_option($key, get_home_path());
						
				}else{
					
					update_option($key, get_home_path());
					
				}
				
			}
			
		}
		
		public function getFontFaceStyle(){
			
			$url = plugin_dir_url( __FILE__ );
			
			#$style = "<style>\n";
			$style = "	@font-face {\n";
			$style .= "		font-family: 'Material Icons';\n";
			$style .= "		font-style: normal;\n";
			$style .= "		font-weight: 400;\n";
			$style .= "		src: url(".$url."iconfont/MaterialIcons-Regular.eot);\n";
			$style .= "		src: local('Material Icons'),\n";
			$style .= "			local('MaterialIcons-Regular'),\n";
			$style .= "			url(".$url."iconfont/MaterialIcons-Regular.woff2) format('woff2'),\n";
			$style .= "			url(".$url."iconfont/MaterialIcons-Regular.woff) format('woff'),\n";
			$style .= "			url(".$url."iconfont/MaterialIcons-Regular.ttf) format('truetype');\n";
			$style .= "	}\n";
			#$style .= "</style>\n";
			return $style;
			
		}
		
		public function getStyle($list){
			
			$style = '<style type="text/css">';
			$style .= "#booking-package-memberActionPanel { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; font-size: ".$list['Design']['booking_package_fontSize']['value']."}\n";
			$style .= "#booking-package_myBookingHistory, #booking-package_myBookingDetailsFroVisitor { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; font-size: ".$list['Design']['booking_package_fontSize']['value']."}\n";
			$style .= "#booking-package_myBookingHistoryTable th, #booking-package_myBookingHistoryTable td { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; font-size: ".$list['Design']['booking_package_fontSize']['value']."}\n";
			$style .= "#booking-package_myBookingDetails { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; font-size: ".$list['Design']['booking_package_fontSize']['value']."}\n";
			$style .= "#booking-package { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; font-size: ".$list['Design']['booking_package_fontSize']['value']."}\n";
			$style .= "#booking-package button { font-size: ".$list['Design']['booking_package_fontSize']['value']."}\n";
			$style .= "#booking-package_durationStay { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_durationStay .bookingDetailsTitle { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_calendarPage { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_scheduleMainPanel { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_courseMainPanel { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage .topPanel { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage .topPanelNoAnimation { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage .daysListPanel { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage .daysListPanelNoAnimation { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage .bottomPanel { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage .bottomPanelForPositionInherit { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage .selectedDate { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage .courseListPanel { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_inputFormPanel { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_inputFormPanel .selectedDate { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_myBookingDetails .selectedDate { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_calendarPage .dayPanel { background-color: ".$list['Design']['booking_package_calendarBackgroundColorWithSchedule']['value']."; }\n";
			$style .= "#booking-package_calendarPage .closeDay { background-color: ".$list['Design']['booking_package_calendarBackgroundColorWithNoSchedule']['value']."; }\n";
			$style .= "#booking-package_schedulePage .selectPanel { background-color: ".$list['Design']['booking_package_scheduleAndServiceBackgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage .selectPanelError { background-color: ".$list['Design']['booking_package_scheduleAndServiceBackgroundColor']['value']."; }\n";
			$style .= "#booking-package_schedulePage .selectPanelActive { background-color: ".$list['Design']['booking_package_backgroundColorOfSelectedLabel']['value']."; }\n";
			$style .= "#booking-package_schedulePage .selectPanel:hover { background-color: ".$list['Design']['booking_package_mouseHover']['value']."; }\n";
			
			$style .= "#booking-package_servicePage { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			$style .= "#booking-package_servicePage .title { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			
			$style .= "#booking-package_servicePage .selectPanel { background-color: ".$list['Design']['booking_package_scheduleAndServiceBackgroundColor']['value']."; }\n";
			$style .= "#booking-package_servicePage .selectPanelError { background-color: ".$list['Design']['booking_package_scheduleAndServiceBackgroundColor']['value']."; }\n";
			$style .= "#booking-package_servicePage .selectPanelActive { background-color: ".$list['Design']['booking_package_backgroundColorOfSelectedLabel']['value']."; }\n";
			$style .= "#booking-package_servicePage .selectPanel:hover { background-color: ".$list['Design']['booking_package_mouseHover']['value']."; }\n";
			
			$style .= "#booking-package_serviceDetails { background-color: ".$list['Design']['booking_package_backgroundColor']['value']."; }\n";
			
			$style .= "#booking-package_calendarPage .pointer:hover { background-color: ".$list['Design']['booking_package_mouseHover']['value']."; }\n";
			$style .= "#booking-package_calendarPage .holidayPanel { background-color: ".$list['Design']['booking_package_backgroundColorOfRegularHolidays']['value']." !important; }\n";
			#$style .= "#booking-package_calendarPage .nationalHoliday { background-color: ".$list['Design']['booking_package_backgroundColorOfNationalHolidays']['value']."; }\n";
			
			$styleList = array(
				"#booking-package_calendarPage .dayPanel", 
				"#booking-package_schedulePage .selectPanel", 
				"#booking-package_schedulePage .selectPanelError", 
				"#booking-package_schedulePage .daysListPanel", 
				"#booking-package_schedulePage .topPanel", 
				"#booking-package_schedulePage .topPanelNoAnimation", 
				"#booking-package_schedulePage .bottomPanel",
				"#booking-package_schedulePage .bottomPanelForPositionInherit",
				"#booking-package_servicePage .selectPanel", 
				"#booking-package_servicePage .selectPanelError", 
				"#booking-package_servicePage .daysListPanel", 
				"#booking-package_servicePage .topPanel", 
				"#booking-package_servicePage .topPanelNoAnimation", 
				"#booking-package_servicePage .bottomPanel",
				"#booking-package_inputFormPanel .selectedDate",
				"#booking-package_myBookingDetails .selectedDate",
				"#booking-package_inputFormPanel .row",
				"#booking-package_myBookingDetails .row",
				"#booking-package_durationStay .row",
				"#booking-package_myBookingDetailsFroVisitor .row",
				"#booking-package_durationStay .bookingDetailsTitle",
				"#booking-package_serviceDetails .row",
				"#booking-package_serviceDetails .borderColor",
				"#booking-package_servicePage .borderColor",
			);
			for($i = 0; $i < count($styleList); $i++){
				
				$style .= $styleList[$i]." { border-color: ".$list['Design']['booking_package_borderColor']['value']."; }\n";
				
			}
			
			$style .= "</style>";
			
			return $style;
			
		}
		
		public function getPhpVersion(){
			
			$v = explode('.', phpversion());
			$phpV = $v[0].".".$v[1];
			return floatval($phpV);
			
		}
		
		public function create_dir() {
			
			$upload_dir = wp_upload_dir();
            $dirname = $upload_dir['basedir'] . '/' . $this->plugin_name;
            if (!file_exists($dirname)) {
            	
            	wp_mkdir_p($dirname);
            	#file_put_contents($dirname . '/test.css', "test");
            	
            }
			
		}
		
		public function wp_insert_site($data){
			
			if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
				
				include_once(ABSPATH . 'wp-admin/includes/plugin.php');
				include_once(ABSPATH . 'wp-includes/ms-functions.php');
				if (is_plugin_active_for_network('booking-package/index.php') === true) {
					
					require_once(plugin_dir_path( __FILE__ ) . 'lib/Setting.php');
					switch_to_blog($data->id);
					$this->create_database(false);
					$site = "http://" . $data->domain . $data->path;
					if (is_ssl()) {
						
						$site = "https://" . $data->domain . $data->path;
						
					}
					
					$timezone = $this->getTimeZone();
					$setting = new booking_package_setting($this->prefix, $this->plugin_name);
					$setting->activation(BOOKING_PACKAGE_EXTENSION_URL, "activation", $this->plugin_version, $timezone, $site);
					restore_current_blog();
					
				}
				
			}
			
		}
		
		public function wpmu_new_blog($blog_id, $user_id, $domain, $path, $site_id, $meta){
			
			#var_dump($param);
			if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
				
				include_once(ABSPATH . 'wp-admin/includes/plugin.php');
				include_once(ABSPATH . 'wp-includes/ms-functions.php');
				if (is_plugin_active_for_network('booking-package/index.php') === true) {
					
					require_once(plugin_dir_path( __FILE__ ) . 'lib/Setting.php');
					switch_to_blog($blog_id);
					$this->create_database();
					restore_current_blog();
					
				}
				
			}
			
		}
		
		public function wp_delete_site($old_site){
			
			if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
				
				include_once(ABSPATH . 'wp-admin/includes/plugin.php');
				include_once(ABSPATH . 'wp-includes/ms-functions.php');
				require_once(plugin_dir_path( __FILE__ ) . 'lib/Database.php');
				if (is_plugin_active_for_network('booking-package/index.php') === true) {
					
					switch_to_blog($old_site->id);
					$database = new booking_package_database($this->prefix, null);
					$database->uninstall(true);
					restore_current_blog();
					
				}
				
			}
			
		}
		
		public function delete_blog($blog_id, $drop) {
			
			if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
				
				include_once(ABSPATH . 'wp-admin/includes/plugin.php');
				include_once(ABSPATH . 'wp-includes/ms-functions.php');
				require_once(plugin_dir_path( __FILE__ ) . 'lib/Database.php');
				if (is_plugin_active_for_network('booking-package/index.php') === true) {
					
					switch_to_blog($blog_id);
					$database = new booking_package_database($this->prefix, null);
					$database->uninstall(true);
					restore_current_blog();
					
				}
				
			}
			
		}
		
		public function getTimeZone() {
			
			$timezone = get_option($this->prefix . "timezone", null);
			if (is_null($timezone)) {
				
				$timezone = get_option('timezone_string', 'UTC');
				if (is_null($timezone) || strlen($timezone) == 0) {
					
					$timezone = 'UTC';
					
				}
				
				add_option($this->prefix . "timezone", sanitize_text_field($timezone));
				
			}
			$this->timezone = $timezone;
			return $timezone;
			
		}
		
		public function ms_site_check(){
			
			if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
				
				$bool = ms_site_check();
				if ($bool === true) {
					
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
					include_once( ABSPATH . 'wp-includes/ms-functions.php' );
					if (is_plugin_active_for_network('booking-package/index.php') === true) {
						
						$response = array();
						$id = get_current_blog_id();
						$response['id'] = $id;
						
						if (intval($id) != intval(SITE_ID_CURRENT_SITE)) {
							
							$isExtensionsValid = false;
							$subscription = array();
							$sites = get_sites();
							foreach ((array) $sites as $site) {
								
								if (intval($site->id) == intval(SITE_ID_CURRENT_SITE)) {
									
									#var_dump($site->blog_id);
									switch_to_blog($site->blog_id);
									$setting = new booking_package_setting($this->prefix, $this->plugin_name);
									$isExtensionsValid = $setting->extensionFunction(false);
									if ($isExtensionsValid === true) {
										
										$subscription = $setting->upgradePlan('get');
										
									}
									break;
									
								}
								
							}
							
							#switch_to_blog($id);
							$response['isExtensionsValid'] = $isExtensionsValid;
							$response['subscription'] = $subscription;
							restore_current_blog();
							
							if ($isExtensionsValid === true) {
								
								
								
							}
							
							return $response;
							
						} else {
							
							return false;
							
						}
						
					} else {
						
						return false;
						
					}
					
				} else {
					
					return false;
					
				}
				
			} else {
				
				return false;
				
			}
			
		}
		
		public function jsonAndPhpError($str){
			
			$javascriptSyntaxErrorNotification = get_option($this->prefix."javascriptSyntaxErrorNotification", 1);
			if(intval($javascriptSyntaxErrorNotification) == 1 && function_exists("json_last_error") && function_exists("json_last_error_msg")){
				
				
				/**
				$debug = debug_backtrace();
				for($i = 0; $i < count($debug); $i++){
					
					$debug[$i]['object'] = array();
					$debug[$i]['args'] = array();
					
				}
				$errors = array(
					'url' => $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 
					'type' => 'PHP',
					'errorType' => "test",
					'line' => 0,
					'file' => 0,
					'msg' => "test2",
					'col' => 0, 
					'version' => $this->plugin_version, 
					'browser' => $_SERVER['HTTP_USER_AGENT'],
					'code' => $_SERVER['HTTP_USER_AGENT'],
					'debug' => $debug,
					'post' => $_POST,
				);
				#var_dump($errors);
				$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
				$response = $schedule->scriptError($errors);
				var_dump($response);
				**/
				
				/**
				$errors = error_get_last();
				if(!is_null($errors) && $errors['type'] == E_ERROR || $errors['type'] == E_WARNING){
					
					$debug = debug_backtrace();
					for($i = 0; $i < count($debug); $i++){
						
						$debug[$i]['object'] = array();
						$debug[$i]['args'] = array();
						
					}
					$errors = array(
						'url' => $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 
						'type' => 'PHP',
						'errorType' => $erros['type'],
						'line' => $errors['line'],
						'file' => $errors['file'],
						'msg' => $errors['message'],
						'col' => 0, 
						'version' => $this->plugin_version, 
						'browser' => $_SERVER['HTTP_USER_AGENT'],
						'code' => $_SERVER['HTTP_USER_AGENT'],
						'debug' => $debug,
						'post' => $_POST,
					);
					$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
					$schedule->scriptError($errors);
					
				}
				
				if(json_last_error() !== JSON_ERROR_NONE){
					
					$debug = debug_backtrace();
					for($i = 0; $i < count($debug); $i++){
						
						$debug[$i]['object'] = array();
						$debug[$i]['args'] = array();
						
					}
					$errors = array(
						'url' => $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 
						'type' => 'PHP',
						'line' => 0,
						'file' => 'json error',
						'msg' => json_last_error_msg(),
						'col' => 0, 
						'version' => $this->plugin_version, 
						'browser' => $_SERVER['HTTP_USER_AGENT'],
						'code' => $_SERVER['HTTP_USER_AGENT'],
						'error' => $str,
						'debug' => $debug,
						'post' => $_POST,
					);
					$schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
					$schedule->scriptError($errors);
					
				}
				**/
				
			}
			
		}
		
		public function changeTimeFormat($timeFormat) {
			
			if (!is_numeric($timeFormat)) {
				
				return $timeFormat;
				
			}
			
			if (intval($timeFormat) == 12) {
				
				$timeFormat = '12a.m.p.m';
				
			} else if (intval($timeFormat) == 24) {
				
				$timeFormat = '24hours';
				
			}
			
			return $timeFormat;
			
		}
		
		public function getDictionary($mode, $pluginName){
			
			$dictionary = array(
				'Error' => __('Error', $pluginName),
				'Add' => __('Add', $pluginName),
				'Delete' => __('Delete', $pluginName),
				'Edit' => __('Edit', $pluginName),
				'Change' => __('Change', $pluginName),
				'Copy' => __('Copy', $pluginName),
				'Return' => __('Return', $pluginName),
				'Save' => __('Save', $pluginName),
				'Cancel' => __('Cancel', $pluginName),
				'Close' => __('Close', $pluginName),
				'Help' => __('Help', $pluginName),
				'Price' => __('Price', $pluginName),
				'Warning' => __('Warning', $pluginName),
				'Booking' => __('Booking', $pluginName),
				'January' => __('January', $pluginName),
				'February' => __('February', $pluginName),
				'March' => __('March', $pluginName),
				'April' => __('April', $pluginName),
				'May' => __('May', $pluginName),
				'June' => __('June', $pluginName),
				'July' => __('July', $pluginName),
				'August' => __('August', $pluginName),
				'September' => __('September', $pluginName),
				'October' => __('October', $pluginName),
				'November' => __('November', $pluginName),
				'December' => __('December', $pluginName),
				'Jan' => __('Jan', $pluginName),
				'Feb' => __('Feb', $pluginName),
				'Mar' => __('Mar', $pluginName),
				'Apr' => __('Apr', $pluginName),
				'May' => __('May', $pluginName),
				'Jun' => __('Jun', $pluginName),
				'Jul' => __('Jul', $pluginName),
				'Aug' => __('Aug', $pluginName),
				'Sep' => __('Sep', $pluginName),
				'Oct' => __('Oct', $pluginName),
				'Nov' => __('Nov', $pluginName),
				'Dec' => __('Dec', $pluginName),
				'Sunday' => __('Sunday', $pluginName),
				'Monday' => __('Monday', $pluginName),
				'Tuesday' => __('Tuesday', $pluginName),
				'Wednesday' => __('Wednesday', $pluginName),
				'Thursday' => __('Thursday', $pluginName),
				'Friday' => __('Friday', $pluginName),
				'Saturday' => __('Saturday', $pluginName),
				'Sun' => __('Sun', $pluginName),
				'Mon' => __('Mon', $pluginName),
				'Tue' => __('Tue', $pluginName),
				'Wed' => __('Wed', $pluginName),
				'Thu' => __('Thu', $pluginName),
				'Fri' => __('Fri', $pluginName),
				'Sat' => __('Sat', $pluginName),
				'Booking Date' => __('Booking Date', $pluginName),
				'Booking date' => __('Booking Date', $pluginName),
				'Arrival (Check-in)' => __('Arrival (Check-in)', $pluginName),
				'Departure (Check-out)' => __('Departure (Check-out)', $pluginName),
				'Arrival' => __('Arrival', $pluginName),
				'Departure' => __('Departure', $pluginName),
				'Check-in' => __('Check-in', $pluginName),
				'Check-out' => __('Check-out', $pluginName),
				'Total number of guests' => __('Total number of guests', $pluginName),
				'Total length of stay' => __('Total length of stay', $pluginName),
				'Additional fees' => __('Additional fees', $pluginName),
				'Accommodation fees' => __('Accommodation fees', $pluginName),
				'Total price' => __('Total price', $pluginName),
				'Total amount' => __('Total amount', $pluginName),
				'Summary' => __('Summary', $pluginName),
				'night' => __('night', $pluginName),
				'nights' => __('nights', $pluginName),
				'Night' => __('Night', $pluginName),
				'Nights' => __('Nights', $pluginName),
				'room' => __('room', $pluginName),
				'rooms' => __('rooms', $pluginName),
				'Title' => __('Title', $pluginName),
				'Booking details' => __('Booking details', $pluginName),
				'Total payment amount' => __('Total payment amount', $pluginName),
				'Reception date' => __('Reception date', $pluginName),
				/**
				'(for %s night)' => __('(for %s night)', $pluginName),
				'(for %s nights)' => __('(for %s nights)', $pluginName),
				**/
				'Clear' => __('Clear', $pluginName),
				'person' => __('person', $pluginName),
				'people' => __('people', $pluginName),
				'Please choose %s' => __('Please choose %s', $pluginName),
				'Please tap here and choose %s' => __('Please tap here and choose %s', $pluginName),
				'An error was found in JavaScript syntax. Send javascript syntax error to the author?' => __('An error was found in JavaScript syntax. Send javascript syntax error to the author?', $pluginName),
				'Subscribed users only' => __('Subscribed users only', $pluginName),
				'%s remaining' => __('%s remaining', $pluginName),
				'An unknown cause of error occurred' => __('An unknown cause of error occurred', $pluginName),
				'Status' => __('Status', $pluginName),
				'approved' => __("approved", $pluginName),
				'pending' => __('pending', $pluginName),
				'canceled' => __('canceled', $pluginName),
				'Can we really cancel your booking?' => __('Can we really cancel your booking?', $pluginName),
				'Your personal details do not displayed on this page.' => __('Your personal details do not displayed on this page.', $pluginName),
				'Surcharge and Tax' => __('Surcharge and Tax', $pluginName),
				'Surcharge' => __('Surcharge', $pluginName),
				'Tax' => __('Tax', $pluginName),
				'Select' => __('Select', $pluginName),
				'%s:%s a.m.' => __('%s:%s a.m.', $pluginName),
				'%s:%s p.m.' => __('%s:%s p.m.', $pluginName),
				'%s:%s am' => __('%s:%s am', $pluginName),
				'%s:%s pm' => __('%s:%s pm', $pluginName),
				'%s:%s AM' => __('%s:%s AM', $pluginName),
				'%s:%s PM' => __('%s:%s PM', $pluginName),
				'Change status' => __('Change status', $pluginName),
				'Add another room' => __('Add another room', $pluginName),
				'Enabled' => __('Enabled', $pluginName),
				'Disabled' => __('Disabled', $pluginName),
			);
			
			
			if ($mode == "adomin") {
				
				$dictionary['Download CSV'] = __("Download CSV", $pluginName);
				$dictionary['Timezone'] = __("Timezone", $pluginName);
				$dictionary['Booking'] = __("Booking", $pluginName);
				$dictionary['No reservations'] = __("No reservations", $pluginName);
				$dictionary['No schedules'] = __('No schedules', $pluginName);
				
				$dictionary['No visitors'] = __('No visitors', $pluginName);
				
				$dictionary['Confirm sending of email'] = __('Confirm sending of email', $pluginName);
				$dictionary['Confirm contents update'] = __('Confirm contents update', $pluginName);
				$dictionary['Do you update to pending status?'] = __('Do you update to pending status?', $pluginName);
				$dictionary['Do you update to approved status?'] = __('Do you update to approved status?', $pluginName);
				$dictionary['Refund confirmation'] = __('Refund confirmation', $pluginName);
				$dictionary['This booking has been paid by credit card. Do you refund the price to the customer?'] = __('This booking has been paid by credit card. Do you refund the price to the customer?', $pluginName);
				$dictionary['Do you send e-mail notifications to customers or administrators?'] = __('Do you send e-mail notifications to customers or administrators?', $pluginName);
				$dictionary['Confirm deletion of data'] = __('Confirm deletion of data', $pluginName);
				$dictionary['Are you sure you want to delete this booking?'] = __('Are you sure you want to delete this booking?', $pluginName);
				$dictionary['Please upgrade your free plan to enable this feature.'] = __('Please upgrade your free plan to enable this feature.', $pluginName);
				$dictionary['Service is not registered. '] = __('Service is not registered. ', $pluginName);
				$dictionary['Please create a service.'] = __('Please create a service.', $pluginName);
				$dictionary['No users found'] = __('No users found', $pluginName);
				
			} else if ($mode == "schedule_page") {
				
				$dictionary['Schedule setting'] = __('Schedule setting', $pluginName);
				$dictionary['Schedule setting on %s'] = __('Schedule setting on %s', $pluginName);
				$dictionary['Edit schedule by day of the week'] = __('Edit schedule by day of the week', $pluginName);
				$dictionary['hour'] = __('hour', $pluginName);
				$dictionary['hours'] = __('hours', $pluginName);
				$dictionary['minutes'] = __('minutes', $pluginName);
				$dictionary['deadline time'] = __('deadline time', $pluginName);
				$dictionary['capacities'] = __('capacities', $pluginName);
				$dictionary['remainders'] = __('remainders', $pluginName);
				$dictionary['Deadline time'] = __('Deadline time', $pluginName);
				$dictionary['%s min ago'] = __('%s min ago', $pluginName);
				$dictionary['%s min'] = __('%s min', $pluginName);
				$dictionary['Choose %s'] = __('Choose %s', $pluginName);
				$dictionary['Type of booking'] = __('Type of booking', $pluginName);
				$dictionary['Calendar status'] = __('Calendar status', $pluginName);
				$dictionary['Enable the service function'] = __('Enable the service function', $pluginName);
				$dictionary['Accommodation (Hotel)'] = __('Accommodation (Hotel)', $pluginName);
				$dictionary['Publish calendar'] = __('Publish calendar', $pluginName);
				$dictionary['Unpublish calendar'] = __('Unpublish calendar', $pluginName);
				$dictionary['Do you delete the "%s"?'] = __('Do you delete the "%s"?', $pluginName);
				$dictionary['Edit schedule'] = __('Edit schedule', $pluginName);
				$dictionary['Return to Calendar list'] = __('Return to Calendar list', $pluginName);
				$dictionary['Add new calendar'] = __('Add new calendar', $pluginName);
				$dictionary['Status'] = __('Status', $pluginName);
				$dictionary['Shortcode'] = __('Shortcode', $pluginName);
				$dictionary['Name'] = __('Name', $pluginName);
				$dictionary['Description'] = __('Description', $pluginName);
				$dictionary['Active'] = __('Active', $pluginName);
				$dictionary['Price'] = __('Price', $pluginName);
				$dictionary['Duration time'] = __('Duration time', $pluginName);
				$dictionary['Unique ID'] = __('Unique ID', $pluginName);
				$dictionary['Value'] = __('Value', $pluginName);
				$dictionary['Required'] = __('Required', $pluginName);
				$dictionary['Is Name'] = __('Is Name', $pluginName);
				$dictionary['Is a location in Google Calendar'] = __('Is a location in Google Calendar', $pluginName);
				$dictionary['Is Email'] = __('Is Email', $pluginName);
				$dictionary['Type'] = __('Type', $pluginName);
				$dictionary['Options'] = __('Options', $pluginName);
				$dictionary['Add service'] = __('Add service', $pluginName);
				$dictionary['Change ranking'] = __('Change ranking', $pluginName);
				$dictionary['Add field'] = __('Add field', $pluginName);
				$dictionary['Do you delete service of "%s"?'] = __('Do you delete service of "%s"?', $pluginName);
				$dictionary['Do you copy service of "%s"?'] = __('Do you copy service of "%s"?', $pluginName);
				$dictionary['Do you delete filed of "%s"?'] = __('Do you delete filed of "%s"?', $pluginName);
				$dictionary['Disable'] = __('Disable', $pluginName);
				$dictionary['Enable'] = __('Enable', $pluginName);
				$dictionary['New booking'] = __('New booking', $pluginName);
				$dictionary['Approval of booking'] = __('Approval of booking', $pluginName);
				$dictionary['Pending of booking'] = __('Pending of booking', $pluginName);
				$dictionary['Deletion of booking'] = __('Deletion of booking', $pluginName);
				$dictionary['Cancellation of booking'] = __('Cancellation of booking', $pluginName);
				$dictionary['Deletion of booking'] = __('Deletion of booking', $pluginName);
				$dictionary['Subject'] = __('Subject', $pluginName);
				$dictionary['Content'] = __('Content', $pluginName);
				$dictionary['State'] = __('State', $pluginName);
				$dictionary['Date'] = __('Date', $pluginName);
				$dictionary['Number of rooms available'] = __('Number of rooms available', $pluginName);
				$dictionary['Cost per night'] = __('Cost per night', $pluginName);
				$dictionary['Maximum number of people staying in one room'] = __('Maximum number of people staying in one room', $pluginName);
				$dictionary['Include children in the maximum number of people in the room'] = __('Include children in the maximum number of people in the room', $pluginName);
				$dictionary['Expressions of arrival and departure'] = __('Expressions of arrival and departure', $pluginName);
				$dictionary['Exclude'] = __('Exclude', $pluginName);
				$dictionary['Include'] = __('Include', $pluginName);
				$dictionary['Confirm deletion of calendar'] = __('Confirm deletion of calendar', $pluginName);
				$dictionary['Number of people'] = __('Number of people', $pluginName);
				$dictionary['Booking is completed within 24 hours (hair salon, hospital etc.)'] = __('Booking is completed within 24 hours (hair salon, hospital etc.)', $pluginName);
				$dictionary['Accommodation (hotels, campgrounds, etc.)'] = __('Accommodation (hotels, campgrounds, etc.)', $pluginName);
				$dictionary['You can use following shortcodes in content editor.'] = __('You can use following shortcodes in content editor.', $pluginName);
				$dictionary['[%s] is inserting "%s"'] = __('[%s] is inserting "%s"', $pluginName);
				$dictionary['Fixed calendar'] = __('Fixed calendar', $pluginName);
				$dictionary['Display remaining capacity'] = __('Display remaining capacity', $pluginName);
				$dictionary['Public days from today'] = __('Public days from today', $pluginName);
				$dictionary['Unavailable days from today'] = __('Unavailable days from today', $pluginName);
				$dictionary['Delete schedules'] = __('Delete schedules', $pluginName);
				$dictionary['Refresh token'] = __('Refresh token', $pluginName);
				$dictionary['The "%s" is only available to subscribed users.'] = __('The "%s" is only available to subscribed users.', $pluginName);
				$dictionary['Cancellation URI'] = __('Cancellation URI', $pluginName);
				$dictionary['Received URI'] = __('Received URI', $pluginName);
				$dictionary['National holiday'] = __('National holiday', $pluginName);
				$dictionary['Published'] = __('Published', $pluginName);
				$dictionary['Unpublished'] = __('Unpublished', $pluginName);
				$dictionary['Taxes'] = __('Taxes', $pluginName);
				$dictionary['Surcharges'] = __('Surcharges', $pluginName);
				$dictionary['Add option'] = __('Add option', $pluginName);
				$dictionary['Add surcharge or tax'] = __('Add surcharge or tax', $pluginName);
				$dictionary['Payment method'] = __('Payment method', $pluginName);
				$dictionary['Stop'] = __('Stop', $pluginName);
				$dictionary['You can use following shortcodes in content editer.'] = __('You can use following shortcodes in content editer.', $pluginName);
				$doctionary['This calendar shares the schedules of the "%s".'] = __('This calendar shares the schedules of the "%s".', $pluginName);
				
			} else if ($mode == "setting_page") {
				
				$dictionary['Cancel subscription'] = __('Cancel subscription', $pluginName);
				$dictionary['Register credit card'] = __("Register credit card", $pluginName);
				$dictionary['Update subscription'] = __("Update subscription", $pluginName);
				$dictionary['Change ranking'] = __('Change ranking', $pluginName);
				$dictionary['Add service'] = __('Add service', $pluginName);
				$dictionary['New service'] = __('New service', $pluginName);
				$dictionary['Refresh token'] = __('Refresh token', $pluginName);
				$dictionary['Name'] = __('Name', $pluginName);
				$dictionary['Description'] = __('Description', $pluginName);
				$dictionary['Active'] = __('Active', $pluginName);
				$dictionary['Price'] = __('Price', $pluginName);
				$dictionary['Duration time'] = __('Duration time', $pluginName);
				$dictionary['Unique ID'] = __('Unique ID', $pluginName);
				$dictionary['Value'] = __('Value', $pluginName);
				$dictionary['Required'] = __('Required', $pluginName);
				$dictionary['Is Name'] = __('Is Name', $pluginName);
				$dictionary['Is a location in Google Calendar'] = __('Is a location in Google Calendar', $pluginName);
				$dictionary['Is Email'] = __('Is Email', $pluginName);
				$dictionary['Type'] = __('Type', $pluginName);
				$dictionary['Options'] = __('Options', $pluginName);
				$dictionary['Cancellation of booking'] = __('Cancellation of booking', $pluginName);
				$dictionary['Email is sending to Visitor after Deletion of booking.'] = __('Email is sending to Visitor after Deletion of booking.', $pluginName);
				$dictionary['The Service account must be in JSON format.'] = __('The Service account must be in JSON format.', $pluginName);
				$dictionary['Confirmation of cancel'] = __('Confirmation of cancel', $pluginName);
				$dictionary['Subscriptions ID'] = __('Subscriptions ID', $pluginName);
				$dictionary['Invoice ID'] = __('Invoice ID', $pluginName);
				$dictionary['Expiration date'] = __('Expiration date', $pluginName);
				$dictionary['Customers email'] = __('Customers email', $pluginName);
				$dictionary['Do you delete option of "%s"?'] = __('Do you delete option of "%s"?', $pluginName);
				$dictionary['Do you really cancel the subscription?'] = __('Do you really cancel the subscription?', $pluginName);
				$dictionary['Do you delete service of "%s"?'] = __('Do you delete service of "%s"?', $pluginName);
				$dictionary['Do you delete filed of "%s"?'] = __('Do you delete filed of "%s"?', $pluginName);
				$dictionary['General'] = __('General', $pluginName);
				$dictionary['Country'] = __('Country', $pluginName);
				$dictionary['Selected country'] = __('Selected country', $pluginName);
				$dictionary['Frequently used countries'] = __('Frequently used countries', $pluginName);
				$dictionary['Other countries'] = __('Other countries', $pluginName);
				$dictionary['Subject'] = __('Subject', $pluginName);
				$dictionary['Content'] = __('Content', $pluginName);
				$dictionary['You have specified the user for deletion.'] = __('You have specified the user for deletion.', $pluginName);
				$dictionary['Automatically adjust the position of the booking heading'] = __('Automatically adjust the position of the booking heading', $pluginName);
				$dictionary['Confirm sending of email'] = __('Confirm sending of email', $pluginName);
				$dictionary['Do you send e-mail notifications to customers or administrators?'] = __('Do you send e-mail notifications to customers or administrators?', $pluginName);
				
			} else if ($mode == "Upgrade_js") {
				
				$dictionary['Upgrade'] = __('Upgrade', $pluginName);
				$dictionary['Credit card'] = __('Credit card', $pluginName);
				$dictionary['Submit Payment'] = __('Submit Payment', $pluginName);
				#$dictionary['You have to input missing text fields.'] = __('You have to input missing text fields.', $pluginName);
				$dictionary['Please choose a plan.'] = __('Please choose a plan.', $pluginName);
				$dictionary['First Name'] = __('First Name', $pluginName);
				$dictionary['Last Name'] = __('Last Name', $pluginName);
				$dictionary['Email address'] = __('Email address', $pluginName);
				#$dictionary['By taking out a subscription, you agree to %s.'] = __('By taking out a subscription, you agree to %s.', $pluginName);
				#$dictionary['the terms of Service'] = __('the terms of Service', $pluginName);
				#$dictionary['Thank you for signing up for the subscription.'] = __('Thank you for signing up for the subscription.', $pluginName);
				#$dictionary['Please reload this browser.'] = __('Please reload this browser.', $pluginName);
				#$dictionary['To subscribe to the paid version of Booking Package you must use HTTPS.'] = __('To subscribe to the paid version of Booking Package you must use HTTPS.', $pluginName);
				
			} else if ($mode == "bookingPageForVisitors") {
				
				$dictionary['Please fill in your details'] = __('Please fill in your details', $pluginName);
				$dictionary['Booking details'] = __('Booking details', $pluginName);
				$dictionary['Your Booking Details'] = __('Your Booking Details', $pluginName);
				$dictionary['Book now'] = __('Book now', $pluginName);
				$dictionary['Return to schedules'] = __('Return to schedules', $pluginName);
				$dictionary['Return to calendar'] = __('Return to calendar', $pluginName);
				$dictionary['Booking Completed'] = __('Booking Completed', $pluginName);
				$dictionary['Credit card'] = __('Credit card', $pluginName);
				$dictionary['Payment & Booking'] = __('Payment & Booking', $pluginName);
				$dictionary['Booking & Payment now'] = __('Booking & Payment now', $pluginName);
				$dictionary['Service is not registered. '] = __('Service is not registered. ', $pluginName);
				$dictionary['Submit Payment'] = __('Submit Payment', $pluginName);
				$dictionary['Sign in'] = __('Sign in', $pluginName);
				$dictionary['Cancel booking'] = __('Cancel booking', $pluginName);
				$dictionary['Next'] = __('Next', $pluginName);
				$dictionary['You have not selected anything'] = __('You have not selected anything', $pluginName);
				$dictionary['Select option'] = __("Select option", $pluginName);
				$dictionary['Choose a date'] = __('Choose a date', $pluginName);
				$dictionary['Select payment method'] = __('Select payment method', $pluginName);
				$dictionary['I will pay locally'] = __('I will pay locally', $pluginName);
				$dictionary['Pay with Credit Card'] = __('Pay with Credit Card', $pluginName);
				$dictionary['Pay with PayPal'] = __('Pay with PayPal', $pluginName);
				$dictionary['Do you really want to delete the license as a member?'] = __('Do you really want to delete the license as a member?', $pluginName);
				
			}
			
			return $dictionary;
			
		}
		
		
	}
	
	class booking_package_widget extends WP_Widget{
		
		public $plugin_name = 'booking-package';
		
		public $prefix = 'booking_package_';
		
		public function __construct() {
			
			$pluginName = $this->plugin_name;
			$test = load_plugin_textdomain($pluginName, false, dirname( plugin_basename( __FILE__ ) ).'/languages');
			#var_dump($test);
			$widget_options = array(
		        'classname'                     => 'booking_package_widget',
		        'description'                   => 'Booking system works within the widget.',
		        'customize_selective_refresh'   => true,
		    );
		    
		    parent::__construct( 'booking_package_widget', 'Booking Package', $widget_options);
			
		}
		
		public function widget($args, $instance){
	        
	        if(is_active_widget(false, false, $this->id_base, true)){
	        	
	        	$defaults = array("calendarKey" => null);
		        $instance = wp_parse_args((array) $instance, $defaults);
		        #var_dump($instance);
		        $account = array('id' => 0);
		        if(!is_null($instance['calendarKey'])){
		        	
		        	$account['id'] = intval($instance['calendarKey']);
		        	
		        }else{
		        	
		        	require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
			        $schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
			        $accountList = $schedule->getCalendarAccountListData();
			        foreach ((array) $accountList as $key => $value) {
			        	
			        	$account['id'] = intval($value['key']);
			        	break;
			        	
			        }
		        	
		        }
		        
		        $booking_package = new BOOKING_PACKAGE();
		        $html = $booking_package->bookingPageForVisitors($account);
		        echo $html;
	        	
	        }
	        
	    }
	    
	    public function form($instance){
	        
	        
	        $defaults = array("calendarKey" => null);
	        $instance = wp_parse_args((array) $instance, $defaults);
	        $calendarKey = 0;
	        if(!is_null($instance['calendarKey'])){
	        	
	        	$calendarKey = intval($instance['calendarKey']);
	        	
	        }
	        
	        require_once(plugin_dir_path( __FILE__ ).'lib/Schedule.php');
	        $schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
	        $accountList = $schedule->getCalendarAccountListData();
	        echo '<p style="">';
	        echo _e('Booking Calendar :', $this->plugin_name);
	        echo '<select id="'.$this->get_field_id('calendarKey').'" name="'.$this->get_field_name('calendarKey').'" style="margin-left: 1em;">';
	        foreach ((array) $accountList as $key => $value) {
	        	
	        	if($calendarKey == intval($value['key'])){
	        		
	        		echo '<option value="'.intval($value['key']).'" selected>'.$value['name'].'</option>';
	        		
	        	}else{
	        		
	        		echo '<option value="'.intval($value['key']).'">'.$value['name'].'</option>';
	        		
	        	}
	        	
	        	
	        }
	        echo '</select></p>';
	        
	    }
		
	    public function update($new_instance, $old_instance){
	        
	        echo "update";
	        $instance = $old_instance;
	        $instance['calendarKey'] = sanitize_text_field($new_instance['calendarKey']);
			return $instance;
	        
	    }
		
	}
	
	$booking_package = new BOOKING_PACKAGE();
	
	
?>