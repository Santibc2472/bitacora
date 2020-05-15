<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : config.php
* File Version            : 1.2.4
* Created / Last Modified : 17 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Configuration file.
*/

// ***************************************************************************** Begin general defaults.

    define('DOPBSP_CONFIG_INIT_DATABASE', false); // Set to "true" if you want to update database structure at each action.
    define('DOPBSP_CONFIG_REPAIR_TRANSLATION_DATABASE', false); // Set to "true" to repair translation database. All your previous translation will be replace.
    define('DOPBSP_CONFIG_DELETE_DATA_ON_DELETE', false);  // Set to "true" if you want to delete all data when you delete the plugin from admin.
    define('DOPBSP_CONFIG_WOOCOMMERCE_ENABLE_CODE', false);  // Set to "true" if you want WooCommerce code to be enabled, even if WooComemrce is not installed/detected.
    define('DOPBSP_CONFIG_API_KEY', 'D0PBSPAP1');  // Set API Key
    
// ***************************************************************************** End general defaults.
    
    
// ***************************************************************************** Begin translation defaults.

    define('DOPBSP_CONFIG_TRANSLATION_LANGUAGES_TO_INSTALL', 'en'); // Set the languages you want to install. Add the abbreviations separated by commas.
    define('DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE', 'en'); // Set default language.
    define('DOPBSP_CONFIG_TRANSLATION_DISPLAY_ALL', true); // Set to "false" if you want to disable the possibility to display all translation text in back end. Use in case you receive a 500 error from server.
    define('DOPBSP_CONFIG_TRANSLATION_DISPLAY_START_ALL', true); // Set to "false" if you do not want to display all text when the translation page is loaded.
    
// ***************************************************************************** End translation defaults.
    
    
// ***************************************************************************** Begin users permissions defaults.

    define('DOPBSP_CONFIG_USERS_PERMISSIONS_ADMINISTRATORS', 0); // Set to "1" to allow administrators to view all calendars by default. "0" to not allow.
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_AUTHORS', 0); // Set to "1" to allow authors to create calendars by default. "0" to not allow.
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_CONTRIBUTORS', 0); // Set to "1" to allow contributors to create calendars by default. "0" to not allow.
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_EDITORS', 0); // Set to "1" to allow editors to create calendars by default. "0" to not allow.
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_SUBSCRIBERS', 0); // Set to "1" to allow subscribers to create calendars by default. "0" to not allow.
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_OTHERS', 0); // Set to "1" to allow other user roles to create calendars by default. "0" to not allow.
    
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_ADMINISTRATORS', 1); // Set to "1" to allow administrator to create custom posts by default. "0" to not allow.
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_AUTHORS', 1); // Set to "1" to allow authors to create custom posts by default. "0" to not allow.
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_CONTRIBUTORS', 1); // Set to "1" to allow contributors to create custom posts by default. "0" to not allow.
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_EDITORS', 1); // Set to "1" to allow editors to create custom posts by default. "0" to not allow.
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_SUBSCRIBERS', 1); // Set to "1" to allow subscribers to create custom posts by default. "0" to not allow.
    define('DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_OTHERS', 1); // Set to "1" to allow other user roles to create custom posts by default. "0" to not allow.

// ***************************************************************************** End users permissions defaults.
    
    
// ***************************************************************************** Begin server requirements.
    
    define('DOPBSP_CONFIG_SERVER_WORDPRESS_VERSION', '3.5'); // WordPress version
    define('DOPBSP_CONFIG_SERVER_WOOCOMMERCE_VERSION', '2.1.0'); // WooCommerce version
    define('DOPBSP_CONFIG_SERVER_PHP_VERSION', '5.1'); // PHP version
    define('DOPBSP_CONFIG_SERVER_MYSQL_VERSION', '5.0'); // MySQL version
    define('DOPBSP_CONFIG_SERVER_MEMORY_LIMIT', '32M'); // Memory limit
    define('DOPBSP_CONFIG_SERVER_MEMORY_LIMIT_WP', '40M'); // WordPress Memory limit
    define('DOPBSP_CONFIG_SERVER_MEMORY_LIMIT_WP_MULTISITE', '64M'); // Wordpress multisite memory limit
    define('DOPBSP_CONFIG_SERVER_MEMORY_LIMIT_WOOCOMMERCE', '64M'); // Memory limit with WooCommerce
    define('DOPBSP_CONFIG_SERVER_CURL_VERSION', '7.34'); // cURL version
    
// ***************************************************************************** End server requirements.

    
// ***************************************************************************** Begin help defaults.
    
    define('DOPBSP_CONFIG_HELP_DOCUMENTATION_URL', 'https://pinpoint.world/documentation-booking?utm_source=WordPress&utm_medium=Plugin%20FREE'); // Link to plugin documentation.
    define('DOPBSP_CONFIG_SHOP_URL', 'https://pinpoint.world/shop/'); // Link to Dot on Paper shop.
    define('DOPBSP_CONFIG_SHOP_SSL_VERIFY', false); // Verify Dot on Paper shop when activating a plugin.
    
// ***************************************************************************** End help defaults.
    

// ***************************************************************************** Begin views display.
    
    define('DOPBSP_CONFIG_VIEW_ADDONS', true); // Display add-ons.
    define('DOPBSP_CONFIG_VIEW_DOCUMENTATION', true); // Display documentation.
    define('DOPBSP_CONFIG_VIEW_THEMES', true); // Display themes.
    define('DOPBSP_CONFIG_VIEW_PRO', true); // Display pro tips.
    
// ***************************************************************************** End views display.
    

// ***************************************************************************** Begin reservation details.
    
    define('DOPBSP_CONFIG_VIEW_IP_ADDRESS', false); // Display IP Address.
    
// ***************************************************************************** End reservation details.