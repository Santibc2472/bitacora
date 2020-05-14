<?php 
/*
Plugin Name: A+ Booking System
Version: 1.2.5
Plugin URI: https://book.eu.com/became-a-host/
Description: This WordPress Plugin will allow you to use the Book Everything Unlimited's booking services.
Author: A+ Booking System
Author URI: https://book.eu.com
*/
if (!defined('ABSPATH')) exit;

global $ABookingSystem;
$ABookingSystem = array();
global $abookingsystemdashboard;
$abookingsystemdashboard = new stdClass;

// Redirect after plugin is activated
register_activation_hook(__FILE__, 'wpAPlusBookingSystemActivate');

// Add settings link
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'wpAPlusBookingSystemSettingsLink');

/*
 * Config
 */

// Load Config General
include_once 'config/general.php';

// Load Config Database
include_once 'config/database.php';

// Load Config Requests
include_once 'config/requests.php';

// Load Config Resources
include_once 'config/resources.php';

// Load Config Menu
include_once 'config/menu.php';

// Load Config Extensions
include_once 'config/extensions.php';
 
// Plugin Url
$ABookingSystem['plugin_url'] = plugin_dir_url(__FILE__);

// Plugin path
$ABookingSystem['plugin_path'] = plugin_dir_path(__FILE__);

/*
 * Models
 */

// Load Dashboard - Main
include_once 'models/main.php';

// Start Main
$abookingsystemdashboard->main = class_exists('absdMain') ? new absdMain():'Class does not exist!';

/*
 * CMS
 */

// Load CMS
include_once 'cms/load.php';
  
/*
 * Plugin Activated
 */
function wpAPlusBookingSystemActivate(){
    add_option('wpaplusbookingsystem_activation', 'true');
}

/*
 * Plugin Add Settings Link
 */
function wpAPlusBookingSystemSettingsLink( $links ) {
    $links[] = '<a href="' .admin_url('admin.php?page=abookingsystemdashboard-connection').'">' . __('Settings') . '</a>';
    return $links;
}