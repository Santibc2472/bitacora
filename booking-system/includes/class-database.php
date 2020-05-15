<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : includes/class-database.php
* File Version            : 1.2.2
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Database PHP class. IMPORTANT! Version, configuration, initialization, initial data, update,  need to be in same file because of issues with instalation/update via FTP.
*/

    if (!class_exists('DOPBSPDatabase')){
        class DOPBSPDatabase{
            /*
             * Private variables.
             */
            private $db_version = 2.84;
            private $db_version_api_keys = 1.0;
            private $db_version_availability = 1.0;
            private $db_version_availability_no = 1.0;
            private $db_version_availability_price = 1.0;
            private $db_version_calendars = 1.07;
            private $db_version_coupons = 1.0;
            private $db_version_days = 1.01;
            private $db_version_discounts = 1.0;
            private $db_version_discounts_items = 1.0;
            private $db_version_discounts_items_rules = 1.0;
            private $db_version_emails = 1.0;
            private $db_version_emails_translation = 1.0;
            private $db_version_extras = 1.0;
            private $db_version_extras_groups = 1.01;
            private $db_version_extras_groups_items = 1.01;
            private $db_version_fees = 1.0;
            private $db_version_forms = 1.0;
            private $db_version_forms_fields = 1.02;
            private $db_version_forms_select_options = 1.0;
            private $db_version_languages = 1.0;
            private $db_version_locations = 1.0;
            private $db_version_models = 1.0;
            private $db_version_reservations = 1.01;
            private $db_version_rules = 1.0;
            private $db_version_searches = 1.0;
            private $db_version_settings = 1.0;
            private $db_version_settings_calendar = 1.0;
            private $db_version_settings_notifications = 1.0;
            private $db_version_settings_payment = 1.0;
            private $db_version_settings_search = 1.0;
            private $db_version_smses = 1.0;
            private $db_version_smses_translation = 1.0;
            private $db_version_translation = 1.03;
            
            /*
             * Public variables.
             */
            public $db_config;
            public $db_collation = 'utf8_unicode_ci';
            
            /*
             * Constructor
             */
            function __construct(){
                global $wpdb;
                
                $this->db_collation = $wpdb->collate != '' ? $wpdb->collate:$this->db_collation;
            
                add_filter('dopbsp_filter_database_configuration', array(&$this, 'config'), 9);
                 
                /*
                 * Change database version if requested.
                 */
                if (DOPBSP_CONFIG_INIT_DATABASE
                        || DOPBSP_REPAIR_DATABASE_TEXT){
                    update_option('DOPBSP_db_version', '2.0');
                    update_option('DOPBSP_db_version_api_keys', '0.1');
                    update_option('DOPBSP_db_version_availability', '0.1');
                    update_option('DOPBSP_db_version_availability_no', '0.1');
                    update_option('DOPBSP_db_version_availability_price', '0.1');
                    update_option('DOPBSP_db_version_calendars', '0.1');
                    update_option('DOPBSP_db_version_coupons', '0.1');
                    update_option('DOPBSP_db_version_days', '0.1');
                    update_option('DOPBSP_db_version_discounts', '0.1');
                    update_option('DOPBSP_db_version_discounts_items', '0.1');
                    update_option('DOPBSP_db_version_discounts_items_rules', '0.1');
                    update_option('DOPBSP_db_version_emails', '0.1');
                    update_option('DOPBSP_db_version_emails_translation', '0.1');
                    update_option('DOPBSP_db_version_extras', '0.1');
                    update_option('DOPBSP_db_version_extras_groups', '0.1');
                    update_option('DOPBSP_db_version_extras_groups_items', '0.1');
                    update_option('DOPBSP_db_version_fees', '0.1');
                    update_option('DOPBSP_db_version_forms', '0.1');
                    update_option('DOPBSP_db_version_forms_fields', '0.1');
                    update_option('DOPBSP_db_version_forms_select_options', '0.1');
                    update_option('DOPBSP_db_version_languages', '0.1');
                    update_option('DOPBSP_db_version_locations', '0.1');
                    update_option('DOPBSP_db_version_models', '0.1');
                    update_option('DOPBSP_db_version_reservations', '0.1');
                    update_option('DOPBSP_db_version_rules', '0.1');
                    update_option('DOPBSP_db_version_searches', '0.1');
                    update_option('DOPBSP_db_version_settings', '0.1');
                    update_option('DOPBSP_db_version_settings_calendar', '0.1');
                    update_option('DOPBSP_db_version_settings_notifications', '0.1');
                    update_option('DOPBSP_db_version_settings_payment', '0.1');
                    update_option('DOPBSP_db_version_settings_search', '0.1');
                    update_option('DOPBSP_db_version_smses', '0.1');
                    update_option('DOPBSP_db_version_smses_translation', '0.1');
                    update_option('DOPBSP_db_version_translation', '0.1');
                }
            }
            
// Database
            
            /*
             * Initialize plugin tables.
             */
            function init(){
                global $DOPBSP;
                
                $this->db_config = new stdClass;
                
                /*
                 * Default values and collation filters.
                 */
                $this->db_config = apply_filters('dopbsp_filter_database_configuration', $this->db_config);
                $this->db_collation = apply_filters('dopbsp_filter_database_collation', $this->db_collation);
                
                /*
                 * Get current database version.
                 */
                $current_db_version = get_option('DOPBSP_db_version');
                 
                if ($this->db_version != (float)$current_db_version){
                    require_once(str_replace('\\', '/', ABSPATH).'wp-admin/includes/upgrade.php');
                    
                    /*
                     * Get current tables' versions.
                     */
                    $current_db_version_api_keys = get_option('DOPBSP_db_version_api_keys');
                    $current_db_version_availability = get_option('DOPBSP_db_version_availability');
                    $current_db_version_availability_no = get_option('DOPBSP_db_version_availability_no');
                    $current_db_version_availability_price = get_option('DOPBSP_db_version_availability_price');
                    $current_db_version_calendars = get_option('DOPBSP_db_version_calendars');
                    $current_db_version_coupons = get_option('DOPBSP_db_version_coupons');
                    $current_db_version_days = get_option('DOPBSP_db_version_days');
                    $current_db_version_discounts = get_option('DOPBSP_db_version_discounts');
                    $current_db_version_discounts_items = get_option('DOPBSP_db_version_discounts_items');
                    $current_db_version_discounts_items_rules = get_option('DOPBSP_db_version_discounts_items_rules');
                    $current_db_version_emails = get_option('DOPBSP_db_version_emails');
                    $current_db_version_emails_translation = get_option('DOPBSP_db_version_emails_translation');
                    $current_db_version_extras = get_option('DOPBSP_db_version_extras');
                    $current_db_version_extras_groups = get_option('DOPBSP_db_version_extras_groups');
                    $current_db_version_extras_groups_items = get_option('DOPBSP_db_version_extras_groups_items');
                    $current_db_version_fees = get_option('DOPBSP_db_version_fees');
                    $current_db_version_forms = get_option('DOPBSP_db_version_forms');
                    $current_db_version_forms_fields = get_option('DOPBSP_db_version_forms_fields');
                    $current_db_version_forms_select_options = get_option('DOPBSP_db_version_forms_select_options');
                    $current_db_version_languages = get_option('DOPBSP_db_version_languages');
                    $current_db_version_locations = get_option('DOPBSP_db_version_locations');
                    $current_db_version_models = get_option('DOPBSP_db_version_models');
                    $current_db_version_reservations = get_option('DOPBSP_db_version_reservations');
                    $current_db_version_rules = get_option('DOPBSP_db_version_rules');
                    $current_db_version_searches = get_option('DOPBSP_db_version_searches');
                    $current_db_version_settings = get_option('DOPBSP_db_version_settings');
                    $current_db_version_settings_calendar = get_option('DOPBSP_db_version_settings_calendar');
                    $current_db_version_settings_notifications = get_option('DOPBSP_db_version_settings_notifications');
                    $current_db_version_settings_payment = get_option('DOPBSP_db_version_settings_payment');
                    $current_db_version_settings_search = get_option('DOPBSP_db_version_settings_search');
                    $current_db_version_smses = get_option('DOPBSP_db_version_smses');
                    $current_db_version_smses_translation = get_option('DOPBSP_db_version_smses_translation');
                    $current_db_version_translation = get_option('DOPBSP_db_version_translation');
                    
                    /*
                     * API keys table.
                     */
                    $sql_api_keys = "CREATE TABLE ".$DOPBSP->tables->api_keys." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->api_keys['user_id']." NOT NULL,
                                            api_key VARCHAR(128) DEFAULT '".$this->db_config->api_keys['api_key']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";
		    
		    /*
		     * Availability table.
		     */
                    $sql_availability = "CREATE TABLE ".$DOPBSP->tables->availability." (
                                            calendar_id BIGINT UNSIGNED DEFAULT ".$this->db_config->availability['calendar_id']." NOT NULL,
                                            date_start DATETIME DEFAULT '".$this->db_config->availability['date_start']."' NOT NULL,
                                            date_end DATETIME DEFAULT '".$this->db_config->availability['date_end']."' NOT NULL,
                                            KEY calendar_id (calendar_id),
                                            KEY date_start (date_start),
                                            KEY date_end (date_end)
                                        );";
		    
		    /*
		     * Availability number table.
		     */
                    $sql_availability_no = "CREATE TABLE ".$DOPBSP->tables->availability_no." (
                                            calendar_id BIGINT UNSIGNED DEFAULT ".$this->db_config->availability_no['calendar_id']." NOT NULL,
                                            no_available INT UNSIGNED DEFAULT '".$this->db_config->availability_no['no_available']."' NOT NULL,
                                            date_start DATETIME DEFAULT '".$this->db_config->availability_no['date_start']."' NOT NULL,
                                            date_end DATETIME DEFAULT '".$this->db_config->availability_no['date_end']."' NOT NULL,
                                            KEY calendar_id (calendar_id),
                                            KEY no_available (no_available),
                                            KEY date_start (date_start),
                                            KEY date_end (date_end)
                                        );";
		    
		    /*
		     * Availability price table.
		     */
                    $sql_availability_price = "CREATE TABLE ".$DOPBSP->tables->availability_price." (
                                            calendar_id BIGINT UNSIGNED DEFAULT ".$this->db_config->availability_price['calendar_id']." NOT NULL,
                                            price FLOAT UNSIGNED DEFAULT '".$this->db_config->availability_price['price']."' NOT NULL,
                                            date_start DATETIME DEFAULT '".$this->db_config->availability_price['date_start']."' NOT NULL,
                                            date_end DATETIME DEFAULT '".$this->db_config->availability_price['date_end']."' NOT NULL,
                                            KEY calendar_id (calendar_id),
                                            KEY price (price),
                                            KEY date_start (date_start),
                                            KEY date_end (date_end)
                                        );";
                    
                    /*
                     * Calendars table.
                     */
                    $sql_calendars = "CREATE TABLE ".$DOPBSP->tables->calendars." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->calendars['user_id']." NOT NULL,
                                            post_id BIGINT UNSIGNED DEFAULT ".$this->db_config->calendars['post_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->calendars['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            max_year INT UNSIGNED DEFAULT ".$this->db_config->calendars['max_year']." NOT NULL,
                                            hours_enabled VARCHAR(6) DEFAULT '".$this->db_config->calendars['hours_enabled']."' COLLATE ".$this->db_collation." NOT NULL,
                                            hours_interval_enabled VARCHAR(6) DEFAULT '".$this->db_config->calendars['hours_interval_enabled']."' COLLATE ".$this->db_collation." NOT NULL,
                                            min_available FLOAT DEFAULT ".$this->db_config->calendars['min_available']." NOT NULL,
                                            price_min FLOAT DEFAULT ".$this->db_config->calendars['price_min']." NOT NULL,
                                            price_max FLOAT DEFAULT ".$this->db_config->calendars['price_max']." NOT NULL,
                                            rating FLOAT DEFAULT ".$this->db_config->calendars['rating']." NOT NULL,
                                            address VARCHAR(512) DEFAULT '".$this->db_config->calendars['address']."' COLLATE ".$this->db_collation." NOT NULL,
                                            address_en VARCHAR(512) DEFAULT '".$this->db_config->calendars['address_en']."' COLLATE ".$this->db_collation." NOT NULL,
                                            address_alt VARCHAR(512) DEFAULT '".$this->db_config->calendars['address_alt']."' COLLATE ".$this->db_collation." NOT NULL,
                                            address_alt_en VARCHAR(512) DEFAULT '".$this->db_config->calendars['address_alt_en']."' COLLATE ".$this->db_collation." NOT NULL,
                                            default_availability TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            last_update_google DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                            last_update_airbnb DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
                                            coordinates TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id),
                                            KEY post_id (post_id),
                                            KEY min_available (min_available),
                                            KEY price_min (price_min),
                                            KEY price_max (price_max)
                                        );";
                    
                    /*
                     * Coupons table.
                     */
                    $sql_coupons = "CREATE TABLE ".$DOPBSP->tables->coupons." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->coupons['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->coupons['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            code VARCHAR(16) DEFAULT '".$this->db_config->coupons['code']."' COLLATE ".$this->db_collation." NOT NULL,
                                            start_date VARCHAR(16) DEFAULT '".$this->db_config->coupons['start_date']."' COLLATE ".$this->db_collation." NOT NULL,
                                            end_date VARCHAR(16) DEFAULT '".$this->db_config->coupons['end_date']."' COLLATE ".$this->db_collation." NOT NULL,
                                            start_hour VARCHAR(16) DEFAULT '".$this->db_config->coupons['start_hour']."' COLLATE ".$this->db_collation." NOT NULL,
                                            end_hour VARCHAR(16) DEFAULT '".$this->db_config->coupons['end_hour']."' COLLATE ".$this->db_collation." NOT NULL,
                                            no_coupons VARCHAR(16) DEFAULT '".$this->db_config->coupons['no_coupons']."' COLLATE ".$this->db_collation." NOT NULL,
                                            operation VARCHAR(1) DEFAULT '".$this->db_config->coupons['operation']."' COLLATE ".$this->db_collation." NOT NULL,
                                            price FLOAT DEFAULT '".$this->db_config->coupons['price']."' NOT NULL,
                                            price_type VARCHAR(8) DEFAULT '".$this->db_config->coupons['price_type']."' COLLATE ".$this->db_collation." NOT NULL,
                                            price_by VARCHAR(8) DEFAULT '".$this->db_config->coupons['price_by']."' COLLATE ".$this->db_collation." NOT NULL,
                                            translation TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";
                    
                    /*
                     * Days table.
                     */
                    $sql_days = "CREATE TABLE " . $DOPBSP->tables->days." (
                                            unique_key VARCHAR(32) COLLATE ".$this->db_collation." NOT NULL,
                                            calendar_id BIGINT UNSIGNED DEFAULT ".$this->db_config->days['calendar_id']." NOT NULL,
                                            day VARCHAR(16) DEFAULT '".$this->db_config->days['day']."' COLLATE ".$this->db_collation." NOT NULL,
                                            year SMALLINT UNSIGNED DEFAULT ".$this->db_config->days['year']." NOT NULL,
                                            data TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            min_available FLOAT DEFAULT '".$this->db_config->days['min_available']."' NOT NULL,
                                            price_min FLOAT DEFAULT '".$this->db_config->days['price_min']."' NOT NULL,
                                            price_max FLOAT DEFAULT '".$this->db_config->days['price_max']."' NOT NULL,
                                            UNIQUE KEY id (unique_key),
                                            KEY calendar_id (calendar_id),
                                            KEY day (day),
                                            KEY year (year),
                                            KEY min_available (min_available),
                                            KEY price_min (price_min),
                                            KEY price_max (price_max)
                                        );";

                    /*
                     * Discounts tables.
                     */
                    $sql_discounts = "CREATE TABLE ".$DOPBSP->tables->discounts." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->discounts['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->discounts['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            extras VARCHAR(6) DEFAULT '".$this->db_config->discounts['extras']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";
                    
                    $sql_discounts_items = "CREATE TABLE ".$DOPBSP->tables->discounts_items." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            discount_id BIGINT UNSIGNED DEFAULT ".$this->db_config->discounts_items['discount_id']." NOT NULL,
                                            position INT UNSIGNED DEFAULT ".$this->db_config->discounts_items['position']." NOT NULL,
                                            start_time_lapse VARCHAR(8) DEFAULT '".$this->db_config->discounts_items['start_time_lapse']."' COLLATE ".$this->db_collation." NOT NULL,
                                            end_time_lapse VARCHAR(8) DEFAULT '".$this->db_config->discounts_items['end_time_lapse']."' COLLATE ".$this->db_collation." NOT NULL,
                                            operation VARCHAR(1) DEFAULT '".$this->db_config->discounts_items['operation']."' COLLATE ".$this->db_collation." NOT NULL,
                                            price FLOAT DEFAULT '".$this->db_config->discounts_items['price']."' NOT NULL,
                                            price_type VARCHAR(8) DEFAULT '".$this->db_config->discounts_items['price_type']."' COLLATE ".$this->db_collation." NOT NULL,
                                            price_by VARCHAR(8) DEFAULT '".$this->db_config->discounts_items['price_by']."' COLLATE ".$this->db_collation." NOT NULL,
                                            translation TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY discount_id (discount_id)
                                        );";
                    
                    $sql_discounts_items_rules = "CREATE TABLE ".$DOPBSP->tables->discounts_items_rules." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            discount_item_id BIGINT UNSIGNED DEFAULT ".$this->db_config->discounts_items_rules['discount_item_id']." NOT NULL,
                                            position INT UNSIGNED DEFAULT ".$this->db_config->discounts_items_rules['position']." NOT NULL,
                                            start_date VARCHAR(16) DEFAULT '".$this->db_config->discounts_items_rules['start_date']."' COLLATE ".$this->db_collation." NOT NULL,
                                            end_date VARCHAR(16) DEFAULT '".$this->db_config->discounts_items_rules['end_date']."' COLLATE ".$this->db_collation." NOT NULL,
                                            start_hour VARCHAR(16) DEFAULT '".$this->db_config->discounts_items_rules['start_hour']."' COLLATE ".$this->db_collation." NOT NULL,
                                            end_hour VARCHAR(16) DEFAULT '".$this->db_config->discounts_items_rules['end_hour']."' COLLATE ".$this->db_collation." NOT NULL,
                                            operation VARCHAR(1) DEFAULT '".$this->db_config->discounts_items_rules['operation']."' COLLATE ".$this->db_collation." NOT NULL,
                                            price FLOAT DEFAULT '".$this->db_config->discounts_items_rules['price']."' NOT NULL,
                                            price_type VARCHAR(8) DEFAULT '".$this->db_config->discounts_items_rules['price_type']."' COLLATE ".$this->db_collation." NOT NULL,
                                            price_by VARCHAR(8) DEFAULT '".$this->db_config->discounts_items_rules['price_by']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY discount_item_id (discount_item_id)
                                        );";
                    
                    /*
                     * Emails table.
                     */
                    $sql_emails = "CREATE TABLE ".$DOPBSP->tables->emails." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->emails['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->emails['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";
                    
                    $sql_emails_translation = "CREATE TABLE ".$DOPBSP->tables->emails_translation." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            email_id BIGINT UNSIGNED DEFAULT ".$this->db_config->emails_translation['email_id']." NOT NULL,
                                            template VARCHAR(64) DEFAULT '".$this->db_config->emails_translation['template']."' COLLATE ".$this->db_collation." NOT NULL,
                                            subject TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            message LONGTEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY email_id (email_id),
                                            KEY template (template)
                                        );";

                    /*
                     * Extras tables.
                     */
                    $sql_extras = "CREATE TABLE ".$DOPBSP->tables->extras." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->extras['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->extras['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";
                    
                    $sql_extras_groups = "CREATE TABLE ".$DOPBSP->tables->extras_groups." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            extra_id BIGINT UNSIGNED DEFAULT ".$this->db_config->extras_groups['extra_id']." NOT NULL,
                                            position INT UNSIGNED DEFAULT ".$this->db_config->extras_groups['position']." NOT NULL,
                                            multiple_select VARCHAR(6) DEFAULT '".$this->db_config->extras_groups['multiple_select']."' COLLATE ".$this->db_collation." NOT NULL,
                                            required VARCHAR(6) DEFAULT '".$this->db_config->extras_groups['required']."' COLLATE ".$this->db_collation." NOT NULL,
                                            no_items_multiply VARCHAR(6) DEFAULT '".$this->db_config->extras_groups['no_items_multiply']."' COLLATE ".$this->db_collation." NOT NULL,
                                            translation TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY extra_id (extra_id)
                                        );";
                    
                    $sql_extras_groups_items = "CREATE TABLE ".$DOPBSP->tables->extras_groups_items." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            group_id BIGINT UNSIGNED DEFAULT ".$this->db_config->extras_groups_items['group_id']." NOT NULL,
                                            position INT UNSIGNED DEFAULT ".$this->db_config->extras_groups_items['position']." NOT NULL,
                                            operation VARCHAR(1) DEFAULT '".$this->db_config->extras_groups_items['operation']."' COLLATE ".$this->db_collation." NOT NULL,
                                            price FLOAT DEFAULT '".$this->db_config->extras_groups_items['price']."' NOT NULL,
                                            price_type VARCHAR(8) DEFAULT '".$this->db_config->extras_groups_items['price_type']."' COLLATE ".$this->db_collation." NOT NULL,
                                            price_by VARCHAR(8) DEFAULT '".$this->db_config->extras_groups_items['price_by']."' COLLATE ".$this->db_collation." NOT NULL,
                                            default_value VARCHAR(3) DEFAULT '".$this->db_config->extras_groups_items['default']."' COLLATE ".$this->db_collation." NOT NULL,
                                            translation TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY group_id (group_id)
                                        );";
                    
                    /*
                     * Fees table.
                     */
                    $sql_fees = "CREATE TABLE ".$DOPBSP->tables->fees." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->fees['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->fees['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            operation VARCHAR(1) DEFAULT '".$this->db_config->fees['operation']."' COLLATE ".$this->db_collation." NOT NULL,
                                            price FLOAT DEFAULT '".$this->db_config->fees['price']."' NOT NULL,
                                            price_type VARCHAR(8) DEFAULT '".$this->db_config->fees['price_type']."' COLLATE ".$this->db_collation." NOT NULL,
                                            price_by VARCHAR(8) DEFAULT '".$this->db_config->fees['price_by']."' COLLATE ".$this->db_collation." NOT NULL,
                                            included VARCHAR(6) DEFAULT '".$this->db_config->fees['included']."' COLLATE ".$this->db_collation." NOT NULL,
                                            extras VARCHAR(6) DEFAULT '".$this->db_config->fees['extras']."' COLLATE ".$this->db_collation." NOT NULL,
                                            cart VARCHAR(6) DEFAULT '".$this->db_config->fees['cart']."' COLLATE ".$this->db_collation." NOT NULL,
                                            translation TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";

                    /*
                     * Forms tables.
                     */
                    $sql_forms = "CREATE TABLE " . $DOPBSP->tables->forms . " (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->forms['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->forms['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";
                    
                    $sql_forms_fields = "CREATE TABLE " . $DOPBSP->tables->forms_fields . " (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            form_id BIGINT UNSIGNED DEFAULT ".$this->db_config->forms_fields['form_id']." NOT NULL,
                                            type VARCHAR(20) DEFAULT '".$this->db_config->forms_fields['type']."' COLLATE ".$this->db_collation." NOT NULL,
                                            position INT UNSIGNED DEFAULT ".$this->db_config->forms_fields['position']." NOT NULL,
                                            multiple_select VARCHAR(6) DEFAULT '".$this->db_config->forms_fields['multiple_select']."' COLLATE ".$this->db_collation." NOT NULL,
                                            allowed_characters TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            size INT UNSIGNED DEFAULT ".$this->db_config->forms_fields['size']." NOT NULL,
                                            is_email VARCHAR(6) DEFAULT '".$this->db_config->forms_fields['is_email']."' COLLATE ".$this->db_collation." NOT NULL,
                                            is_phone VARCHAR(6) DEFAULT '".$this->db_config->forms_fields['is_phone']."' COLLATE ".$this->db_collation." NOT NULL,
                                            default_country VARCHAR(2) DEFAULT '".$this->db_config->forms_fields['default_country']."' COLLATE ".$this->db_collation." NOT NULL,
                                            required VARCHAR(6) DEFAULT '".$this->db_config->forms_fields['required']."' COLLATE ".$this->db_collation." NOT NULL,
                                            add_to_day_hour_info VARCHAR(6) DEFAULT '".$this->db_config->forms_fields['add_to_day_hour_info']."' COLLATE ".$this->db_collation." NOT NULL,
                                            add_to_day_hour_body VARCHAR(6) DEFAULT '".$this->db_config->forms_fields['add_to_day_hour_body']."' COLLATE ".$this->db_collation." NOT NULL,
                                            translation TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY form_id (form_id)
                                        );";
                    
                    $sql_forms_select_options = "CREATE TABLE " . $DOPBSP->tables->forms_fields_options . " (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            field_id BIGINT UNSIGNED DEFAULT ".$this->db_config->forms_fields_options['field_id']." NOT NULL,
                                            position INT UNSIGNED DEFAULT ".$this->db_config->forms_fields_options['position']." NOT NULL,
                                            translation TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY field_id (field_id)
                                        );";
                    
                    /*
                     * Languages table.
                     */
                    $sql_languages = "CREATE TABLE ".$DOPBSP->tables->languages." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->languages['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            code VARCHAR(2) DEFAULT '".$this->db_config->languages['code']."' COLLATE ".$this->db_collation." NOT NULL,
                                            enabled VARCHAR(6) DEFAULT ".$this->db_config->languages['enabled']." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY code (code),
                                            KEY enabled (enabled)
                                        );";
                    
                    /*
                     * Locations table.
                     */
                    $sql_locations = "CREATE TABLE ".$DOPBSP->tables->locations." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->locations['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->locations['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            address VARCHAR(512) DEFAULT '".$this->db_config->locations['address']."' COLLATE ".$this->db_collation." NOT NULL,
                                            address_en VARCHAR(512) DEFAULT '".$this->db_config->locations['address_en']."' COLLATE ".$this->db_collation." NOT NULL,
                                            address_alt VARCHAR(512) DEFAULT '".$this->db_config->locations['address_alt']."' COLLATE ".$this->db_collation." NOT NULL,
                                            address_alt_en VARCHAR(512) DEFAULT '".$this->db_config->locations['address_alt_en']."' COLLATE ".$this->db_collation." NOT NULL,
                                            coordinates TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            calendars TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            link VARCHAR(512) DEFAULT '".$this->db_config->locations['link']."' COLLATE ".$this->db_collation." NOT NULL,
                                            image VARCHAR(512) DEFAULT '".$this->db_config->locations['image']."' COLLATE ".$this->db_collation." NOT NULL,
                                            businesses TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            businesses_other TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            languages TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            email VARCHAR(512) DEFAULT '".$this->db_config->locations['email']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";
		    
                    /*
                     * Models table.
                     */
                    $sql_models = "CREATE TABLE ".$DOPBSP->tables->models." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->models['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->models['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            enabled VARCHAR(6) DEFAULT '".$this->db_config->models['enabled']."' COLLATE ".$this->db_collation." NOT NULL,
				            multiple_calendars VARCHAR(6) DEFAULT '".$this->db_config->models['multiple_calendars']."' COLLATE ".$this->db_collation." NOT NULL,
                                            translation TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            translation_calendar TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";

                    /*
                     * Reservations table.
                     */   
                    $sql_reservations = "CREATE TABLE " . $DOPBSP->tables->reservations . " (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            calendar_id BIGINT UNSIGNED DEFAULT ".$this->db_config->reservations['calendar_id']." NOT NULL,
                                            language VARCHAR(8) DEFAULT '".$this->db_config->reservations['language']."' COLLATE ".$this->db_collation." NOT NULL,
                                            currency VARCHAR(32) DEFAULT '".$this->db_config->reservations['currency']."' COLLATE ".$this->db_collation." NOT NULL,
                                            currency_code VARCHAR(8) DEFAULT '".$this->db_config->reservations['currency_code']."' COLLATE ".$this->db_collation." NOT NULL,
                                            check_in VARCHAR(16) DEFAULT '".$this->db_config->reservations['check_in']."' COLLATE ".$this->db_collation." NOT NULL,
                                            check_out VARCHAR(16) DEFAULT '".$this->db_config->reservations['check_out']."' COLLATE ".$this->db_collation." NOT NULL,
                                            start_hour VARCHAR(16) DEFAULT '".$this->db_config->reservations['start_hour']."' COLLATE ".$this->db_collation." NOT NULL,
                                            end_hour VARCHAR(16) DEFAULT '".$this->db_config->reservations['end_hour']."' COLLATE ".$this->db_collation." NOT NULL,
                                            no_items INT UNSIGNED DEFAULT ".$this->db_config->reservations['no_items']." NOT NULL,
                                            price FLOAT DEFAULT ".$this->db_config->reservations['price']." NOT NULL,
                                            price_total FLOAT DEFAULT ".$this->db_config->reservations['price_total']." NOT NULL,
                                            refund FLOAT DEFAULT ".$this->db_config->reservations['refund']." NOT NULL,
                                            extras TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            extras_price FLOAT DEFAULT ".$this->db_config->reservations['extras_price']." NOT NULL,
                                            discount TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            discount_price FLOAT DEFAULT ".$this->db_config->reservations['discount_price']." NOT NULL,
                                            coupon TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            coupon_price FLOAT DEFAULT ".$this->db_config->reservations['coupon_price']." NOT NULL,
                                            fees TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            fees_price FLOAT DEFAULT ".$this->db_config->reservations['fees_price']." NOT NULL,
                                            deposit TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            deposit_price FLOAT DEFAULT ".$this->db_config->reservations['deposit_price']." NOT NULL,
                                            days_hours_history TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            form TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            address_billing TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            address_shipping TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            email VARCHAR(128) DEFAULT '".$this->db_config->reservations['email']."' COLLATE ".$this->db_collation." NOT NULL,
                                            phone VARCHAR(32) DEFAULT '".$this->db_config->reservations['phone']."' COLLATE ".$this->db_collation." NOT NULL,
                                            status VARCHAR(16) DEFAULT '".$this->db_config->reservations['status']."' COLLATE ".$this->db_collation." NOT NULL,
                                            payment_method VARCHAR(32) DEFAULT '".$this->db_config->reservations['payment_method']."' NOT NULL, 
                                            payment_status VARCHAR(32) DEFAULT '".$this->db_config->reservations['payment_status']."' NOT NULL, 
                                            transaction_id VARCHAR(128) DEFAULT '".$this->db_config->reservations['transaction_id']."' COLLATE ".$this->db_collation." NOT NULL, 
                                            reservation_from VARCHAR(32) DEFAULT 'pinpoint' COLLATE ".$this->db_collation." NOT NULL, 
                                            uid VARCHAR(75) NOT NULL, 
                                            token VARCHAR(128) DEFAULT '".$this->db_config->reservations['token']."' NOT NULL, 
                                            ip VARCHAR(32) DEFAULT '".$this->db_config->reservations['ip']."' NOT NULL, 
                                            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY calendar_id (calendar_id),
                                            KEY check_in (check_in),
                                            KEY check_out (check_out),
                                            KEY start_hour (end_hour),
                                            KEY status (status),
                                            KEY payment_method (payment_method),
                                            KEY transaction_id (transaction_id),
                                            KEY uid (uid),
                                            KEY token (token)
                                    );";
                    
                    /*
                     * Rules table.
                     */
                    $sql_rules = "CREATE TABLE ".$DOPBSP->tables->rules." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->rules['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->rules['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            time_lapse_min FLOAT DEFAULT '".$this->db_config->rules['time_lapse_min']."' NOT NULL,
                                            time_lapse_max FLOAT DEFAULT '".$this->db_config->rules['time_lapse_max']."' NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";
                    
                    /*
                     * Search tables.
                     */
                    $sql_searches = "CREATE TABLE ".$DOPBSP->tables->searches." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->searches['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->searches['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            calendars_excluded TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            currency VARCHAR(128) DEFAULT '".$this->db_config->searches['currency']."' COLLATE ".$this->db_collation." NOT NULL,
                                            currency_position VARCHAR(32) DEFAULT '".$this->db_config->searches['currency_position']."' COLLATE ".$this->db_collation." NOT NULL,
                                            hours_enabled VARCHAR(6) DEFAULT '".$this->db_config->searches['hours_enabled']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";
                    
                    if ($current_db_version == ''
			    || $current_db_version >= 2.64){
			/*
			 * Settings tables.
			*/
		       $sql_settings = "CREATE TABLE ".$DOPBSP->tables->settings." (
					       id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
					       name VARCHAR(128) DEFAULT '".$this->db_config->settings['name']."' COLLATE ".$this->db_collation." NOT NULL,
					       value TEXT COLLATE ".$this->db_collation." NOT NULL,
					       UNIQUE KEY id (id),
					       KEY name (name)
					   );";

		       $sql_settings_calendar = "CREATE TABLE ".$DOPBSP->tables->settings_calendar." (
					       id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
					       calendar_id BIGINT UNSIGNED DEFAULT ".$this->db_config->settings_calendar['calendar_id']." NOT NULL,
					       name VARCHAR(128) DEFAULT '".$this->db_config->settings_calendar['name']."' COLLATE ".$this->db_collation." NOT NULL,
					       value TEXT COLLATE ".$this->db_collation." NOT NULL,
					       UNIQUE KEY id (id),
					       KEY calendar_id (calendar_id),
					       KEY name (name)
					   );";

		       $sql_settings_notifications = "CREATE TABLE ".$DOPBSP->tables->settings_notifications." (
					       id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
					       calendar_id BIGINT UNSIGNED DEFAULT ".$this->db_config->settings_notifications['calendar_id']." NOT NULL,
					       name VARCHAR(128) DEFAULT '".$this->db_config->settings_notifications['name']."' COLLATE ".$this->db_collation." NOT NULL,
					       value TEXT COLLATE ".$this->db_collation." NOT NULL,
					       UNIQUE KEY id (id),
					       KEY calendar_id (calendar_id),
					       KEY name (name)
					   );";

		       $sql_settings_payment = "CREATE TABLE ".$DOPBSP->tables->settings_payment." (
					       id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
					       calendar_id BIGINT UNSIGNED DEFAULT ".$this->db_config->settings_payment['calendar_id']." NOT NULL,
					       name VARCHAR(128) DEFAULT '".$this->db_config->settings_payment['name']."' COLLATE ".$this->db_collation." NOT NULL,
					       value TEXT COLLATE ".$this->db_collation." NOT NULL,
					       UNIQUE KEY id (id),
					       KEY calendar_id (calendar_id),
					       KEY name (name)
					   );";

		       $sql_settings_search = "CREATE TABLE ".$DOPBSP->tables->settings_search." (
					       id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
					       search_id BIGINT UNSIGNED DEFAULT ".$this->db_config->settings_search['search_id']." NOT NULL,
					       name VARCHAR(128) DEFAULT '".$this->db_config->settings_search['name']."' COLLATE ".$this->db_collation." NOT NULL,
					       value TEXT COLLATE ".$this->db_collation." NOT NULL,
					       UNIQUE KEY id (id),
					       KEY search_id (search_id),
					       KEY name (name)
					   );";
		    }
                    
                    /*
                     * SMSes tables.
                     */
                    $sql_smses = "CREATE TABLE ".$DOPBSP->tables->smses." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            user_id BIGINT UNSIGNED DEFAULT ".$this->db_config->smses['user_id']." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".$this->db_config->smses['name']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY user_id (user_id)
                                        );";
                    
                    $sql_smses_translation = "CREATE TABLE ".$DOPBSP->tables->smses_translation." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            sms_id BIGINT UNSIGNED DEFAULT ".$this->db_config->smses_translation['sms_id']." NOT NULL,
                                            template VARCHAR(64) DEFAULT '".$this->db_config->smses_translation['template']."' COLLATE ".$this->db_collation." NOT NULL,
                                            message LONGTEXT COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY sms_id (sms_id),
                                            KEY template (template)
                                        );";
                    
                    /*
                     * Translation tables.
                     */
                    $languages[0] = 'en';
                    $languages = explode(',', DOPBSP_CONFIG_TRANSLATION_LANGUAGES_TO_INSTALL);
                    
                    for ($l=0; $l<count($languages); $l++){
                        $sql_translation = "CREATE TABLE ".$DOPBSP->tables->translation."_".$languages[$l]." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            key_data VARCHAR(128) DEFAULT '".$this->db_config->translation['key_data']."' COLLATE ".$this->db_collation." NOT NULL,
                                            parent_key VARCHAR(128) DEFAULT '".$this->db_config->translation['parent_key']."' COLLATE ".$this->db_collation." NOT NULL,
                                            text_data TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            translation TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            location VARCHAR(32) DEFAULT '".$this->db_config->translation['location']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY key_data (key_data)
                                        );";
                        $this->db_version_translation != $current_db_version_translation ? dbDelta($sql_translation):'';
                    }
                    
                    /*
                     * Update Translations.
                     */
                    $this->updateTranslations2x();
                    
                    /*
                     * Create/update the database tables.
                     */
                    $this->db_version_api_keys != $current_db_version_api_keys ? dbDelta($sql_api_keys):'';
                    $this->db_version_availability != $current_db_version_availability ? dbDelta($sql_availability):'';
                    $this->db_version_availability_no != $current_db_version_availability_no ? dbDelta($sql_availability_no):'';
                    $this->db_version_availability_price != $current_db_version_availability_price ? dbDelta($sql_availability_price):'';
                    $this->db_version_calendars != $current_db_version_calendars ? dbDelta($sql_calendars):'';
                    $this->db_version_coupons != $current_db_version_coupons ? dbDelta($sql_coupons):'';
                    $this->db_version_days != $current_db_version_days ? dbDelta($sql_days):'';
                    $this->db_version_discounts != $current_db_version_discounts ? dbDelta($sql_discounts):'';
                    $this->db_version_discounts_items != $current_db_version_discounts_items ? dbDelta($sql_discounts_items):'';
                    $this->db_version_discounts_items_rules != $current_db_version_discounts_items_rules ? dbDelta($sql_discounts_items_rules):'';
                    $this->db_version_emails != $current_db_version_emails ? dbDelta($sql_emails):'';
                    $this->db_version_emails_translation != $current_db_version_emails_translation ? dbDelta($sql_emails_translation):'';
                    $this->db_version_extras != $current_db_version_extras ? dbDelta($sql_extras):'';
                    $this->db_version_extras_groups != $current_db_version_extras_groups ? dbDelta($sql_extras_groups):'';
                    $this->db_version_extras_groups_items != $current_db_version_extras_groups_items ? dbDelta($sql_extras_groups_items):'';
                    $this->db_version_fees != $current_db_version_fees ? dbDelta($sql_fees):'';
                    $this->db_version_forms != $current_db_version_forms ? dbDelta($sql_forms):'';
                    $this->db_version_forms_fields != $current_db_version_forms_fields ? dbDelta($sql_forms_fields):'';
                    $this->db_version_forms_select_options != $current_db_version_forms_select_options ? dbDelta($sql_forms_select_options):'';
                    $this->db_version_languages != $current_db_version_languages ? dbDelta($sql_languages):'';
                    $this->db_version_locations != $current_db_version_locations ? dbDelta($sql_locations):'';
                    $this->db_version_models != $current_db_version_models ? dbDelta($sql_models):'';
                    $this->db_version_reservations != $current_db_version_reservations ? dbDelta($sql_reservations):'';
                    $this->db_version_rules != $current_db_version_rules ? dbDelta($sql_rules):'';
		    $this->db_version_searches != $current_db_version_searches ? dbDelta($sql_searches):'';
                    $this->db_version_smses != $current_db_version_smses ? dbDelta($sql_smses):'';
                    $this->db_version_smses_translation != $current_db_version_smses_translation ? dbDelta($sql_smses_translation):'';
		    
                    if ($current_db_version == ''
			    || $current_db_version >= 2.64){
			$this->db_version_settings != $current_db_version_settings ? dbDelta($sql_settings):'';
			$this->db_version_settings_calendar != $current_db_version_settings_calendar ? dbDelta($sql_settings_calendar):'';
			$this->db_version_settings_notifications != $current_db_version_settings_notifications ? dbDelta($sql_settings_notifications):'';
			$this->db_version_settings_payment != $current_db_version_settings_payment ? dbDelta($sql_settings_payment):'';
			$this->db_version_settings_search != $current_db_version_settings_search ? dbDelta($sql_settings_search):'';
		    }
                    
                    /*
                     * Update database.
                     */
                    $this->update();
                    
                    if ($current_db_version != ''
                            && $current_db_version <= 2.42){
                        /*
                         * Reservation table.
                         */
                        $this->updateReservations2x();
                    }
                    
                    /*
                     * Update database version.
                     */
                    $current_db_version == '' ? add_option('DOPBSP_db_version', $this->db_version):update_option('DOPBSP_db_version', $this->db_version);
                        
                    /*
                     * Update tables' versions.
                     */
                    $current_db_version_api_keys == '' ? add_option('DOPBSP_db_version_api_keys', $this->db_version_api_keys):
                                                          update_option('DOPBSP_db_version_api_keys', $this->db_version_api_keys);
                    $current_db_version_availability == '' ? add_option('DOPBSP_db_version_availability', $this->db_version_availability):
							     update_option('DOPBSP_db_version_availability', $this->db_version_availability);
                    $current_db_version_availability_no == '' ? add_option('DOPBSP_db_version_availability_no', $this->db_version_availability_no):
								update_option('DOPBSP_db_version_availability_no', $this->db_version_availability_no);
                    $current_db_version_availability_price == '' ? add_option('DOPBSP_db_version_availability_price', $this->db_version_availability_price):
								   update_option('DOPBSP_db_version_availability_price', $this->db_version_availability_price);
                    $current_db_version_calendars == '' ? add_option('DOPBSP_db_version_calendars', $this->db_version_calendars):
                                                          update_option('DOPBSP_db_version_calendars', $this->db_version_calendars);
                    $current_db_version_coupons == '' ? add_option('DOPBSP_db_version_coupons', $this->db_version_coupons):
                                                        update_option('DOPBSP_db_version_coupons', $this->db_version_coupons);
                    $current_db_version_days == '' ? add_option('DOPBSP_db_version_days', $this->db_version_days):
                                                     update_option('DOPBSP_db_version_days', $this->db_version_days);
                    $current_db_version_discounts == '' ? add_option('DOPBSP_db_version_discounts', $this->db_version_discounts):
                                                          update_option('DOPBSP_db_version_discounts', $this->db_version_discounts);
                    $current_db_version_discounts_items == '' ? add_option('DOPBSP_db_version_discounts_items', $this->db_version_discounts_items):
                                                                update_option('DOPBSP_db_version_discounts_items', $this->db_version_discounts_items);
                    $current_db_version_discounts_items_rules == '' ? add_option('DOPBSP_db_version_discounts_items_rules', $this->db_version_discounts_items_rules):
                                                                      update_option('DOPBSP_db_version_discounts_items_rules', $this->db_version_discounts_items_rules);
                    $current_db_version_emails == '' ? add_option('DOPBSP_db_version_emails', $this->db_version_emails):
                                                       update_option('DOPBSP_db_version_emails', $this->db_version_emails);
                    $current_db_version_emails_translation == '' ? add_option('DOPBSP_db_version_emails_translation', $this->db_version_emails_translation):
                                                                   update_option('DOPBSP_db_version_emails_translation', $this->db_version_emails_translation);
                    $current_db_version_extras == '' ? add_option('DOPBSP_db_version_extras', $this->db_version_extras):
                                                       update_option('DOPBSP_db_version_extras', $this->db_version_extras);
                    $current_db_version_extras_groups == '' ? add_option('DOPBSP_db_version_extras_groups', $this->db_version_extras_groups):
                                                              update_option('DOPBSP_db_version_extras_groups', $this->db_version_extras_groups);
                    $current_db_version_extras_groups_items == '' ? add_option('DOPBSP_db_version_extras_groups_items', $this->db_version_extras_groups_items):
                                                                    update_option('DOPBSP_db_version_extras_groups_items', $this->db_version_extras_groups_items);
                    $current_db_version_fees == '' ? add_option('DOPBSP_db_version_fees', $this->db_version_fees):
                                                     update_option('DOPBSP_db_version_fees', $this->db_version_fees);
                    $current_db_version_forms == '' ? add_option('DOPBSP_db_version_forms', $this->db_version_forms):
                                                      update_option('DOPBSP_db_version_forms', $this->db_version_forms);
                    $current_db_version_forms_fields == '' ? add_option('DOPBSP_db_version_forms_fields', $this->db_version_forms_fields):
                                                             update_option('DOPBSP_db_version_forms_fields', $this->db_version_forms_fields);
                    $current_db_version_forms_select_options == '' ? add_option('DOPBSP_db_version_forms_select_options', $this->db_version_forms_select_options):
                                                                     update_option('DOPBSP_db_version_forms_select_options', $this->db_version_forms_select_options);
                    $current_db_version_languages == '' ? add_option('DOPBSP_db_version_languages', $this->db_version_languages):
                                                          update_option('DOPBSP_db_version_languages', $this->db_version_languages);
                    $current_db_version_locations == '' ? add_option('DOPBSP_db_version_locations', $this->db_version_locations):
                                                          update_option('DOPBSP_db_version_locations', $this->db_version_locations);
                    $current_db_version_models == '' ? add_option('DOPBSP_db_version_models', $this->db_version_models):
                                                       update_option('DOPBSP_db_version_models', $this->db_version_models);
                    $current_db_version_reservations == '' ? add_option('DOPBSP_db_version_reservations', $this->db_version_reservations):
                                                             update_option('DOPBSP_db_version_reservations', $this->db_version_reservations);
                    $current_db_version_rules == '' ? add_option('DOPBSP_db_version_rules', $this->db_version_rules):
                                                      update_option('DOPBSP_db_version_rules', $this->db_version_rules);
                    $current_db_version_searches == '' ? add_option('DOPBSP_db_version_searches', $this->db_version_searches):
                                                         update_option('DOPBSP_db_version_searches', $this->db_version_searches);
                    $current_db_version_settings == '' ? add_option('DOPBSP_db_version_settings', $this->db_version_settings):
                                                         update_option('DOPBSP_db_version_settings', $this->db_version_settings);
                    $current_db_version_settings_calendar == '' ? add_option('DOPBSP_db_version_settings_calendar', $this->db_version_settings_calendar):
                                                                  update_option('DOPBSP_db_version_settings_calendar', $this->db_version_settings_calendar);
                    $current_db_version_settings_notifications == '' ? add_option('DOPBSP_db_version_settings_notifications', $this->db_version_settings_notifications):
                                                                       update_option('DOPBSP_db_version_settings_notifications', $this->db_version_settings_notifications);
                    $current_db_version_settings_payment == '' ? add_option('DOPBSP_db_version_settings_payment', $this->db_version_settings_payment):
                                                                 update_option('DOPBSP_db_version_settings_payment', $this->db_version_settings_payment);
                    $current_db_version_settings_search == '' ? add_option('DOPBSP_db_version_settings_search', $this->db_version_settings_search):
                                                                update_option('DOPBSP_db_version_settings_search', $this->db_version_settings_search);
                    $current_db_version_smses == '' ? add_option('DOPBSP_db_version_smses', $this->db_version_smses):
                                                       update_option('DOPBSP_db_version_smses', $this->db_version_smses);
                    $current_db_version_smses_translation == '' ? add_option('DOPBSP_db_version_smses_translation', $this->db_version_smses_translation):
                                                                   update_option('DOPBSP_db_version_smses_translation', $this->db_version_smses_translation);
                    $current_db_version_translation == '' ? add_option('DOPBSP_db_version_translation', $this->db_version_translation):
                                                            update_option('DOPBSP_db_version_translation', $this->db_version_translation);
                    
                    
                    $this->set();
                }
            }
            
// Set            
            
            /*
             * Set initial data for plugin tables.
             */
            function set(){
                global $DOPBSP;
                /*
                 * Translation data.
                 */
                
                $DOPBSP->classes->backend_translation->database();
                
                if(is_admin()) {
                    $DOPBSP->classes->translation->set();
                }
                
                /*
                 * Add calendar
                 */
                $this->setCalendar();
                
                /*
                 * Add calendar
                 */
                $this->setLocation();
                
                /*
                 * Emails data.
                 */
                $this->setEmails();
                
                /*
                 * Extras data.
                 */
                $this->setExtras();
                
                /*
                 * Forms data.
                 */
                $this->setForms();
                
                /*
                 * SMSes data.
                 */
                $this->setSmses();
            }
            
            /*
             * Add calendar if not exist.
             */
            function setCalendar($name = ''){
                global $wpdb;
                global $DOPBSP;
                
                if($name == '') {
                    $name = $DOPBSP->text('CALENDARS_ADD_CALENDAR_NAME');
                }
                
                /*
                 * Update calendar data.
                 */
                $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' where id=1');
                
                if ($wpdb->num_rows == 0){
                    /*
                     * Add calendar.
                     */
                    $wpdb->insert($DOPBSP->tables->calendars, array('id' => 1,
                                                                    'user_id' => wp_get_current_user()->ID,
                                                                    'name' => $name));
                }
            }
            
            /*
             * Add location if not exist.
             */
            function setLocation($name = ''){
                global $wpdb;
                global $DOPBSP;
                
                if($name == '') {
                    $name = $DOPBSP->text('LOCATIONS_ADD_LOCATION_NAME');
                }
                
                /*
                 * Update location data.
                 */
                $locations = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->locations.' where id=1');
                
                if ($wpdb->num_rows == 0){
                    /*
                     * Add calendar.
                     */
                    $wpdb->insert($DOPBSP->tables->locations, array('id' => 1,
                                                                    'user_id' => wp_get_current_user()->ID,
                                                                    'name' => $name));
                }
            }
            
            /*
             * Set emails data.
             */
            function setEmails(){
                global $wpdb;
                global $DOPBSP;
                
                $control_data = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->emails.' WHERE id=1');
                
                if ($wpdb->num_rows == 0){
                     $wpdb->insert($DOPBSP->tables->emails, array('id' => 1,
                                                                  'user_id' => 0,
                                                                  'name' => $DOPBSP->text('EMAILS_DEFAULT_NAME')));
                    /*
                     * Simple book.
                     */
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'book_admin',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_ADMIN_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_ADMIN')));
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'book_user',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_USER_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_USER')));
                    /*
                     * Book with approval.
                     */
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'book_with_approval_admin',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_ADMIN_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_ADMIN')));
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'book_with_approval_user',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_USER_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_USER')));
                    /*
                     * Approved
                     */
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'approved',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_APPROVED_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_APPROVED')));
                    /*
                     * Canceled
                     */
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'canceled',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_CANCELED_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_CANCELED')));
                    /*
                      Rejected
                     */
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'rejected',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_REJECTED_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_REJECTED')));

                    /*
                     * Payment gateways.
                     */
                    $pg_list = $DOPBSP->classes->payment_gateways->get();

                    for ($i=0; $i<count($pg_list); $i++){
                        $pg_id = $pg_list[$i];
                        
                        $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                                 'template' => $pg_id.'_admin',
                                                                                 'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_'.strtoupper($pg_id).'_ADMIN_SUBJECT'),
                                                                                 'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_'.strtoupper($pg_id).'_ADMIN')));
                        $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                                 'template' => $pg_id.'_user',
                                                                                 'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_'.strtoupper($pg_id).'_USER_SUBJECT'),
                                                                                 'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_'.strtoupper($pg_id).'_USER')));
                    }
                }
            }
            
            /*
             * Set extras data.
             */
            function setExtras(){
                global $wpdb;
                global $DOPBSP;
                
                $control_data = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->extras.' WHERE id=1');
                
                if ($wpdb->num_rows == 0){
                    $wpdb->insert($DOPBSP->tables->extras, array('id' => 1,
                                                                 'user_id' => wp_get_current_user()->ID,
                                                                 'name' => $DOPBSP->text('EXTRAS_DEFAULT_PEOPLE')));
                    $wpdb->insert($DOPBSP->tables->extras_groups, array('id' => 1,
                                                                        'extra_id' => 1,
                                                                        'position' => 1,
                                                                        'multiple_select' => 'false',
                                                                        'required' => 'true',
                                                                        'translation' => $DOPBSP->classes->translation->encodeJSON('EXTRAS_DEFAULT_ADULTS')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 1,
                                                                              'group_id' => 1,
                                                                              'position' => 1,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '1')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 2,
                                                                              'group_id' => 1,
                                                                              'position' => 2,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '2')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 3,
                                                                              'group_id' => 1,
                                                                              'position' => 3,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '3')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 4,
                                                                              'group_id' => 1,
                                                                              'position' => 4,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '4')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 5,
                                                                              'group_id' => 1,
                                                                              'position' => 5,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '5')));
                    $wpdb->insert($DOPBSP->tables->extras_groups, array('id' => 2,
                                                                        'extra_id' => 1,
                                                                        'position' => 2,
                                                                        'multiple_select' => 'false',
                                                                        'required' => 'true',
                                                                        'translation' => $DOPBSP->classes->translation->encodeJSON('EXTRAS_DEFAULT_CHILDREN')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 6,
                                                                              'group_id' => 2,
                                                                              'position' => 1,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '0')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 7,
                                                                              'group_id' => 2,
                                                                              'position' => 2,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '1')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 8,
                                                                              'group_id' => 2,
                                                                              'position' => 3,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '2')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 9,
                                                                              'group_id' => 2,
                                                                              'position' => 4,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '3')));
                }
            }
            
            /*
             * Set forms data.
             */
            function setForms(){
                global $wpdb;
                global $DOPBSP;
                
                $control_data = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->forms.' WHERE id=1');
                
                if ($wpdb->num_rows == 0){
                    $wpdb->insert($DOPBSP->tables->forms, array('id' => 1,
                                                                'user_id' => wp_get_current_user()->ID,
                                                                'name' => $DOPBSP->text('FORMS_DEFAULT_NAME')));
                    $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => 1,
                                                                       'form_id' => 1,
                                                                       'type' => 'text',
                                                                       'position' => 1,
                                                                       'multiple_select' => 'false',
                                                                       'allowed_characters' => '',
                                                                       'size' => 0,
                                                                       'is_email' => 'false',
                                                                       'is_phone' => 'false',
                                                                       'default_country' => 'US',
                                                                       'required' => 'true',
                                                                       'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_DEFAULT_FIRST_NAME')));
                    $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => 2,
                                                                       'form_id' => 1,
                                                                       'type' => 'text',
                                                                       'position' => 2,
                                                                       'multiple_select' => 'false',
                                                                       'allowed_characters' => '',
                                                                       'size' => 0,
                                                                       'is_email' => 'false',
                                                                       'is_phone' => 'false',
                                                                       'default_country' => 'US',
                                                                       'required' => 'true',
                                                                       'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_DEFAULT_LAST_NAME')));
                    $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => 3,
                                                                       'form_id' => 1,
                                                                       'type' => 'text',
                                                                       'position' => 3,
                                                                       'multiple_select' => 'false',
                                                                       'allowed_characters' => '',
                                                                       'size' => 0,
                                                                       'is_email' => 'true',
                                                                       'is_phone' => 'false',
                                                                       'default_country' => 'US',
                                                                       'required' => 'true',
                                                                       'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_DEFAULT_EMAIL')));
                    $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => 4,
                                                                       'form_id' => 1,
                                                                       'type' => 'text',
                                                                       'position' => 4,
                                                                       'multiple_select' => 'false',
                                                                       'allowed_characters' => '0123456789+-().',
                                                                       'size' => 0,
                                                                       'is_email' => 'false',
                                                                       'is_phone' => 'true',
                                                                       'default_country' => 'US',
                                                                       'required' => 'true',
                                                                       'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_DEFAULT_PHONE')));
                    $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => 5,
                                                                       'form_id' => 1,
                                                                       'type' => 'textarea',
                                                                       'position' => 5,
                                                                       'multiple_select' => 'false',
                                                                       'allowed_characters' => '',
                                                                       'size' => 0,
                                                                       'is_email' => 'false',
                                                                       'is_phone' => 'false',
                                                                       'required' => 'true',
                                                                       'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_DEFAULT_MESSAGE')));
                }
            }
            
            /*
             * Set SMSes data.
             */
            function setSmses(){
                global $wpdb;
                global $DOPBSP;
                
                $control_data = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->smses.' WHERE id=1');
                
                if ($wpdb->num_rows == 0){
                     $wpdb->insert($DOPBSP->tables->smses, array('id' => 1,
                                                                  'user_id' => 0,
                                                                  'name' => $DOPBSP->text('SMSES_DEFAULT_NAME')));
                    /*
                     * Simple book.
                     */
                    $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => 1,
                                                                             'template' => 'book_admin',
                                                                             'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_BOOK_ADMIN')));
                    $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => 1,
                                                                             'template' => 'book_user',
                                                                             'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_BOOK_USER')));
                    /*
                     * Book with approval.
                     */
                    $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => 1,
                                                                             'template' => 'book_with_approval_admin',
                                                                             'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_BOOK_WITH_APPROVAL_ADMIN')));
                    $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => 1,
                                                                             'template' => 'book_with_approval_user',
                                                                             'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_BOOK_WITH_APPROVAL_USER')));
                    /*
                     * Approved
                     */
                    $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => 1,
                                                                             'template' => 'approved',
                                                                             'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_APPROVED')));
                    /*
                     * Canceled
                     */
                    $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => 1,
                                                                             'template' => 'canceled',
                                                                             'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_CANCELED')));
                    /*
                      Rejected
                     */
                    $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => 1,
                                                                             'template' => 'rejected',
                                                                             'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_REJECTED')));

                    /*
                     * Payment gateways.
                     */
                    $pg_list = $DOPBSP->classes->payment_gateways->get();

                    for ($i=0; $i<count($pg_list); $i++){
                        $pg_id = $pg_list[$i];
                        
                        $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => 1,
                                                                                 'template' => $pg_id.'_admin',
                                                                                 'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_'.strtoupper($pg_id).'_ADMIN')));
                        $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => 1,
                                                                                 'template' => $pg_id.'_user',
                                                                                 'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_'.strtoupper($pg_id).'_USER')));
                    }
                }
            }
            
// Update
            
            /*
             * Update database. Rename table columns and transfer data from old tables.
             */
            function update(){
                $current_db_version = get_option('DOPBSP_db_version');
                
                /*
                 * Rename calendar settings table.
                 */
                $this->updateRename();
                
                /*
                 * Update Calendar table.
                 */
                if ($current_db_version != ''
                        && $current_db_version < 2.0){
                    
                    /*
                     * Calendars tables.
                     */
                    $this->updateCalendars1x();
                    
                    /*
                     * Settings tables.
                     */
                    $this->updateSettings1x();
                    
                    /*
                     * Days tables.
                     */
                    $this->updateDays1x();
                    
                    /*
                     * Forms tables.
                     */
                    $this->updateForms1x();
                    
                    /*
                     * Reservations tables.
                     */
                    $this->updateReservations1x();
                }
		
		/*
		 * Update availability.
		 */
                if ($current_db_version != ''
                        && $current_db_version < 2.64){
		    $this->updateAvailability264();
		}
            }
            
            /*
             * Update calendars tables from versions 1.x
             */
            function updateCalendars1x(){
                global $wpdb;
                global $DOPBSP;
                
                $old_calendar = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->old_calendars.' where id=1');
                
                if($wpdb->num_rows > 0) {
                    $this->setCalendar($old_calendar->name);
                }
            }
            
            /*
             * Update days tables from versions 1.x
             */
            function updateDays1x(){
                global $wpdb;
                global $DOPBSP;
                
                $old_days = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->old_days.' where calendar_id=1');
                
                if($wpdb->num_rows > 0) {
                    
                    foreach($old_days as $day) {
                        
                        
                        $current_day = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->days.' where unique_key="'.$day->calendar_id.'_'.$day->day.'"');
                        
                        if($wpdb->num_rows < 1) {
                            
                            $newJSONData = json_decode($day->data);
                            $newJSONData->available = intval($newJSONData->available);
                            $newJSONData->bind = intval($newJSONData->bind);
                            $newJSONData->price = floatval($newJSONData->price);
                            $newJSONData->promo = floatval($newJSONData->promo);
                            $newJSONData->info_info = array();
                            $newJSONData->info_body = array();


                            $hours = $newJSONData->hours;

                            foreach($hours as $key => $value){
                                $newJSONData->hours->{$key}->available = intval($hours->{$key}->available);
                                $newJSONData->hours->{$key}->bind = intval($hours->{$key}->bind);
                                $newJSONData->hours->{$key}->price = floatval($hours->{$key}->price);
                                $newJSONData->hours->{$key}->promo = intval($hours->{$key}->promo);
                            }

                            /*
                             * Add day.
                             */
                            $wpdb->insert($DOPBSP->tables->days, array('unique_key' => $day->calendar_id.'_'.$day->day,
                                                                       'calendar_id' => $day->calendar_id,
                                                                       'day' => $day->day,
                                                                       'year' => $day->year,
                                                                       'data' => json_encode($newJSONData))); 
                        }
                   }
                }
            }
            
            /*
             * Update forms tables from versions 1.x
             */
            function updateForms1x(){
                global $wpdb;
                global $DOPBSP;
                
                $old_form = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->old_forms);
                
                if ($wpdb->num_rows > 0){
                    $wpdb->insert($DOPBSP->tables->forms, array('id' => 1,
                                                                'user_id' => 0,
                                                                'name' => $old_form->name));
                    
                    $old_fields = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->old_forms_fields.' where form_id='.$old_form->id);
                    
                    if ($wpdb->num_rows > 0){
                        
                        foreach ($old_fields as $field) {
                            $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => $field->id,
                                                                               'form_id' => $field->form_id,
                                                                               'type' => $field->type,
                                                                               'position' => $field->position,
                                                                               'multiple_select' => $field->multiple_select,
                                                                               'allowed_characters' => $field->allowed_characters,
                                                                               'size' => $field->size,
                                                                               'is_email' => $field->is_email,
                                                                               'required' => $field->required,
                                                                               'translation' => $field->translation));
                            
                            if($field->type == 'select' || $field->type == 'checkbox') {
                                $old_fields_options = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->old_forms_fields_options.' where field_id='.$field->id);
                    
                                if ($wpdb->num_rows > 0){
                                    
                                    foreach ($old_fields_options as $field_option) {
                                        $wpdb->insert($DOPBSP->tables->forms_fields_options, array('id' => $field_option->id,
                                                                                                   'field_id' => $field_option->field_id,
                                                                                                   'translation' => $field_option->translation));
                                    }
                                }
                            }
                
                        } 
                    }
                }
            }
            
            
            
            /*
             * Update reservations tables from versions 1.x
             */
            function updateReservations1x(){
                global $wpdb;
                global $DOPBSP;
                
                $old_reservations = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->old_reservations);
                
                if($wpdb->num_rows > 0) {
                    
                    foreach($old_reservations as $reservation) {
                        /*
                         * Add reservation.
                         */
                        $discount = '{"id":"0","rule_id":"0","operation":"-","price":"'.$reservation->discount.'","price_type":"percent","price_by":"once","start_date":"","end_date":"","start_hour":"","end_hour":"","translation":""}';
                        $coupon = '{"id":"0","code":"","operation":"-","price":"0","price_type":"percent","price_by":"once","translation":""}';
                        $deposit = '{"price":"'.$reservation->deposit.'","price_type":"percent"}';
                        
                        $old_form = json_decode($reservation->info);
                        $new_form = '';
                        
                        $new_form .='[';
                        $k = 0;
                        
                        foreach($old_form as $form_field) {
                            
                            if ($k > 0) {
                                $new_form .=',';
                            }
                            $new_form .='{';
                            $new_form .='"id":"'.$form_field->id.'",';
                            
                            if(strpos($form_field->value, '@') !== false) {
                                $new_form .='"is_email":"true",';
                            } else {
                                $new_form .='"is_email":"false",';
                            }
                            $new_form .='"add_to_day_hour_info":"false",';
                            $new_form .='"add_to_day_hour_body":"false",';
                            $new_form .='"translation":"'.$form_field->name.'",';
                            $new_form .='"value":"'.$form_field->value.'"';
                            $new_form .='}';
                            $k++;
                        }
                        
                        $new_form .=']';
                         
                        $wpdb->insert($DOPBSP->tables->reservations, array('id' => $reservation->id,
                                                                            'calendar_id' => $reservation->calendar_id,
                                                                            'language' => $reservation->language,
                                                                            'currency' => $reservation->currency,
                                                                            'currency_code' => $reservation->currency_code,
                                                                            'check_in' => $reservation->check_in,
                                                                            'check_out' => $reservation->check_out,
                                                                            'start_hour' => $reservation->start_hour,
                                                                            'end_hour' => $reservation->end_hour,
                                                                            'no_items' => $reservation->no_items,
                                                                            'price' => $reservation->price,
                                                                            'price_total' => $reservation->total_price,
                                                                            'discount_price' => $reservation->discount,
                                                                            'discount' => $discount,
                                                                            'coupon_price' => 0,
                                                                            'coupon' => $coupon,
                                                                            'fees_price' => 0,
                                                                            'deposit_price' => $reservation->deposit,
                                                                            'deposit' => $deposit,
                                                                            'email' => $reservation->email,
                                                                            'status' => $reservation->status,
                                                                            'payment_method' => $reservation->payment_method,
                                                                            'transaction_id' => $reservation->paypal_transaction_id, 
                                                                            'refund' => 0, 
                                                                            'payment_status' => ($reservation->status == 'approved' && $reservation->paypal_transaction_id != '') ? 'paid':(($reservation->status == 'expired' || $reservation->status == 'canceled') ? '':$reservation->status), 
                                                                            'form' => $new_form,
                                                                            'date_created' => $reservation->date_created)); 
                        $new_form = '';
                   }
                }
            }
            
            /*
             * Update reservations tables from versions 1.x
             */
            function updateReservations2x(){
                global $wpdb;
                global $DOPBSP;
                $current_db_version = get_option('DOPBSP_db_version');
                
                if ($current_db_version != ''
                        && $current_db_version <= 2.42){
                    /*
                     * Update reservations data.
                     */
                    $reservations = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->reservations);

                    foreach ($reservations as $reservation){

                        $wpdb->update($DOPBSP->tables->reservations, array('uid' => $DOPBSP->classes->prototypes->getRandomString(32).'@'.str_ireplace(array('http://', 'https://'), '', home_url())), 
                                                                     array('id' => $reservation->id));
                    }  
                }
            }
            
            /*
             * Update settings tables from versions 1.x
             */
            function updateSettings1x(){
                global $wpdb;
                global $DOPBSP;
                
                $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->old_settings.' where calendar_id=1');
                
                if($wpdb->num_rows > 0) {

                        /*
                         * Days Available
                         */
                        if ($settings->available_days != 'true,true,true,true,true,true,true' && $settings->available_days != '') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'days_available',
                                                                                    'value' => $settings->available_days));
                        }

                        /*
                         * First Day
                         */
                        if ($settings->first_day != 1) { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'days_first',
                                                                                    'value' => $settings->first_day));
                        }

                        /*
                         * Currency
                         */
                        $settings->currency = $DOPBSP->classes->prototypes->convertOldCurrency($settings->currency);
                        
                        if ($settings->currency != 'USD') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'currency',
                                                                                    'value' => $settings->currency));
                        }

                        /*
                         * Date type
                         */
                        if ($settings->date_type != 1) { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'date_type',
                                                                                    'value' => $settings->date_type));
                        }

                        /*
                         * Template
                         */
                        if ($settings->template != 'default') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'template',
                                                                                    'value' => $settings->template));
                        }

                        /*
                         * Number of items
                         */
                        if ($settings->no_items_enabled != 'true') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'sidebar_no_items_enabled',
                                                                                    'value' => $settings->no_items_enabled));
                        }

                        /*
                         * View only
                         */
                        if ($settings->view_only != 'false') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'view_only',
                                                                                    'value' => $settings->view_only));
                        }

                        /*
                         * Terms & Conditions
                         */
                        if ($settings->terms_and_conditions_enabled != 'false') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'terms_and_conditions_enabled',
                                                                                    'value' => $settings->terms_and_conditions_enabled)); 

                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'terms_and_conditions_link',
                                                                                    'value' => $settings->terms_and_conditions_link));
                        }

                        /*
                         * Morning Checkout
                         */
                        if ($settings->morning_check_out != 'false') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'days_morning_check_out',
                                                                                    'value' => $settings->morning_check_out));
                        }

                        /*
                         * Hours Enabled
                         */
                        if ($settings->hours_enabled != 'false') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'hours_enabled',
                                                                                    'value' => $settings->hours_enabled));
                        }

                        /*
                         * Hours Definitions
                         */
                        if ($settings->hours_definitions != '[{"value": "00:00"}]') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'hours_definitions',
                                                                                    'value' => $settings->hours_definitions));
                        }

                        /*
                         * Multiple hours select
                         */
                        if ($settings->multiple_hours_select != 'true') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'hours_multiple_select',
                                                                                    'value' => $settings->multiple_hours_select));
                        }

                        /*
                         * Hours AMPM
                         */
                        if ($settings->hours_ampm != 'false') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'hours_ampm',
                                                                                    'value' => $settings->hours_ampm));
                        }

                        /*
                         * Add last hour to Total Price
                         */
                        if ($settings->last_hour_to_total_price != 'true') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'hours_add_last_hour_to_total_price',
                                                                                    'value' => $settings->last_hour_to_total_price));
                        }

                        /*
                         * Hours interval 
                         */
                        if ($settings->hours_interval_enabled != 'false') { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'hours_interval_enabled',
                                                                                    'value' => $settings->hours_interval_enabled));
                        }

                        /*
                         * Deposit
                         */
                        if ($settings->deposit != 0) { 
                            $wpdb->insert($DOPBSP->tables->settings_calendar, array('calendar_id' => 1,
                                                                                    'unique_key' => 'deposit',
                                                                                    'value' => $settings->deposit));
                        }

                        /*
                         * Notification Email
                         */
                        if ($settings->notifications_email != '') { 
                            $wpdb->insert($DOPBSP->tables->settings_notifications, array('calendar_id' => 1,
                                                                                         'unique_key' => 'email',
                                                                                         'value' => $settings->notifications_email));
                        }

                        /*
                         * Smtp Enabled 
                         */
                        if ($settings->smtp_enabled != 'false') { 
                            /*
                             * Smtp host name 
                             */
                            if ($settings->smtp_host_name != '') { 
                                $wpdb->insert($DOPBSP->tables->settings_notifications, array('calendar_id' => 1,
                                                                                             'unique_key' => 'smtp_host_name',
                                                                                             'value' => $settings->smtp_host_name));
                            }

                            /*
                             * Smtp host port 
                             */
                            if ($settings->smtp_host_port != '25') { 
                                $wpdb->insert($DOPBSP->tables->settings_notifications, array('calendar_id' => 1,
                                                                                             'unique_key' => 'smtp_host_port',
                                                                                             'value' => $settings->smtp_host_port));
                            }

                            /*
                             * Smtp SSL 
                             */
                            if ($settings->smtp_ssl != 'false') { 
                                $wpdb->insert($DOPBSP->tables->settings_notifications, array('calendar_id' => 1,
                                                                                             'unique_key' => 'smtp_ssl',
                                                                                             'value' => $settings->smtp_ssl));
                            }

                            /*
                             * Smtp User 
                             */
                            if ($settings->smtp_user != '') { 
                                $wpdb->insert($DOPBSP->tables->settings_notifications, array('calendar_id' => 1,
                                                                                             'unique_key' => 'smtp_user',
                                                                                             'value' => $settings->smtp_user));
                            }

                            /*
                             * Smtp Password 
                             */
                            if ($settings->smtp_password != '') { 
                                $wpdb->insert($DOPBSP->tables->settings_notifications, array('calendar_id' => 1,
                                                                                             'unique_key' => 'smtp_password',
                                                                                             'value' => $settings->smtp_password));
                            }
                        }

                        /*
                         * Payment Arrival
                         */
                        if ($settings->payment_arrival_enabled != 'true') { 
                            $wpdb->insert($DOPBSP->tables->settings_payment, array('calendar_id' => 1,
                                                                                   'unique_key' => 'arrival_enabled',
                                                                                   'value' => $settings->payment_arrival_enabled));
                        }

                        /*
                         * Payment PayPal Enabled
                         */
                        if ($settings->payment_paypal_enabled != 'false') { 
                            $wpdb->insert($DOPBSP->tables->settings_payment, array('calendar_id' => 1,
                                                                                   'unique_key' => 'paypal_enabled',
                                                                                   'value' => $settings->payment_paypal_enabled));
                        } 

                        $sanbox = '';

                        if ($settings->payment_paypal_sandbox_enabled != 'false') {
                            $sanbox = 'sandbox_';
                            $wpdb->insert($DOPBSP->tables->settings_payment, array('calendar_id' => 1,
                                                                                   'unique_key' => 'paypal_sandbox_enabled',
                                                                                   'value' => $settings->payment_paypal_sandbox_enabled));
                        }

                        /*
                         * Payment PayPal Username
                         */
                        if ($settings->payment_paypal_username != '') {
                            $wpdb->insert($DOPBSP->tables->settings_payment, array('calendar_id' => 1,
                                                                                   'unique_key' => 'paypal_'.$sanbox.'username',
                                                                                   'value' => $settings->payment_paypal_username));
                        }

                        /*
                         * Payment PayPal Password
                         */
                        if ($settings->payment_paypal_password != '') {
                            $wpdb->insert($DOPBSP->tables->settings_payment, array('calendar_id' => 1,
                                                                                   'unique_key' => 'paypal_'.$sanbox.'password',
                                                                                   'value' => $settings->payment_paypal_password));
                        }

                        /*
                         * Payment PayPal Signature
                         */
                        if ($settings->payment_paypal_signature != '') {
                            $wpdb->insert($DOPBSP->tables->settings_payment, array('calendar_id' => 1,
                                                                                   'unique_key' => 'paypal_'.$sanbox.'signature',
                                                                                   'value' => $settings->payment_paypal_signature));
                        }

                        /*
                         * Payment PayPal Credit Card
                         */
                        if ($settings->payment_paypal_credit_card != 'false') {
                            $wpdb->insert($DOPBSP->tables->settings_payment, array('calendar_id' => 1,
                                                                                   'unique_key' => 'paypal_credit_card',
                                                                                   'value' => $settings->payment_paypal_credit_card));
                        }
                    }
            }
            
            /*
             * Update translations tables from versions 2.x
             */
            function updateTranslations2x(){
                global $wpdb;
                global $DOPBSP;
                $current_db_version = get_option('DOPBSP_db_version');
                
                if ($current_db_version != ''
                        && $current_db_version < 2.36){
                
                    $languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');
                    $languages_codes = array();
                    
                    foreach($languages as $language) {
                        array_push($languages_codes, $language->code);
                    }
                    /*
                     * Translation tables.
                     */
                    
                    for ($l=0; $l<count($languages_codes); $l++){
                        $sql_translation = "CREATE TABLE ".$DOPBSP->tables->translation."_".$languages_codes[$l]." (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            key_data VARCHAR(128) DEFAULT '".$this->db_config->translation['key_data']."' COLLATE ".$this->db_collation." NOT NULL,
                                            parent_key VARCHAR(128) DEFAULT '".$this->db_config->translation['parent_key']."' COLLATE ".$this->db_collation." NOT NULL,
                                            text_data TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            translation TEXT COLLATE ".$this->db_collation." NOT NULL,
                                            location VARCHAR(32) DEFAULT '".$this->db_config->translation['location']."' COLLATE ".$this->db_collation." NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY key_data (key_data)
                                        );";
                            
                        dbDelta($sql_translation);
                    }
                    
                    
                    
                    /*
                     * Update Translation texts.
                     */
                    for ($l=0; $l<count($languages_codes); $l++){

                        $query_values = array();

                        for ($i=0; $i<count($DOPBSP->classes->translation->text); $i++){
                            /*
                             * Set add query values.
                             */
                            
                            if(isset($DOPBSP->classes->translation->text[$i]['location'])){
                                
                                if($DOPBSP->classes->translation->text[$i]['location'] != 'backend') {
                                    $wpdb->update( $DOPBSP->tables->translation.'_'.$languages_codes[$l], array( 'location' => $DOPBSP->classes->translation->text[$i]['location']),array('key_data'=> $DOPBSP->classes->translation->text[$i]['key'],
                                                        'parent_key'=> $DOPBSP->classes->translation->text[$i]['parent'],
                                                        'text_data'=> $DOPBSP->classes->translation->text[$i]['text']));
                                }
                            }
                        }
                    }
                }
            
            }
            
            /*
             * Rename tables names.
             */
            function updateRename(){
                global $wpdb;
		global $DOPBSP;
                
                $current_db_version = get_option('DOPBSP_db_version');
                
                /*
                 * Rename calendars settings table.
                 */
                if ($current_db_version != ''
                        && $current_db_version < 2.165){
                    $control_data = $wpdb->query('SHOW TABLES LIKE "'.$wpdb->prefix.'dopbsp_settings_calendar"');
                    
                    if ($wpdb->num_rows == 0){
                        $wpdb->query('RENAME TABLE '.$wpdb->prefix.'dopbsp_settings TO '.$wpdb->prefix.'dopbsp_settings_calendar');
                    }
                }
		
		/*
		 * Update settings columns.
		 */
                if ($current_db_version != ''
                        && $current_db_version < 2.64){
		    $control_data = $wpdb->query('SHOW TABLES LIKE "'.$DOPBSP->tables->settings.'"');
		    
                    if ($wpdb->num_rows > 0){
                        $wpdb->query("ALTER TABLE ".$DOPBSP->tables->settings." CHANGE unique_key name VARCHAR(128) DEFAULT '".$this->db_config->settings['name']."' COLLATE ".$this->db_collation." NOT NULL");
                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings.' DROP INDEX unique_key');
                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings.' ADD INDEX name (name)');
                    }
		    
		    $control_data = $wpdb->query('SHOW TABLES LIKE "'.$DOPBSP->tables->settings_calendar.'"');
		    
                    if ($wpdb->num_rows > 0){
                        $wpdb->query("ALTER TABLE ".$DOPBSP->tables->settings_calendar." CHANGE unique_key name VARCHAR(128) DEFAULT '".$this->db_config->settings_calendar['name']."' COLLATE ".$this->db_collation." NOT NULL");
                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings_calendar.' DROP INDEX unique_key');
                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings_calendar.' ADD INDEX name (name)');
                    }
		    
		    $control_data = $wpdb->query('SHOW TABLES LIKE "'.$DOPBSP->tables->settings_notifications.'"');
		    
                    if ($wpdb->num_rows > 0){
                        $wpdb->query("ALTER TABLE ".$DOPBSP->tables->settings_notifications." CHANGE unique_key name VARCHAR(128) DEFAULT '".$this->db_config->settings_notifications['name']."' COLLATE ".$this->db_collation." NOT NULL");
                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings_notifications.' DROP INDEX unique_key');
                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings_notifications.' ADD INDEX name (name)');
                    }
		    
		    $control_data = $wpdb->query('SHOW TABLES LIKE "'.$DOPBSP->tables->settings_payment.'"');
		    
                    if ($wpdb->num_rows > 0){
                        $wpdb->query("ALTER TABLE ".$DOPBSP->tables->settings_payment." CHANGE unique_key name VARCHAR(128) DEFAULT '".$this->db_config->settings_payment['name']."' COLLATE ".$this->db_collation." NOT NULL");
                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings_payment.' DROP INDEX unique_key');
                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings_payment.' ADD INDEX name (name)');
                    }
		    
		    $control_data = $wpdb->query('SHOW TABLES LIKE "'.$DOPBSP->tables->settings_search.'"');
		    
                    if ($wpdb->num_rows > 0){
                        $wpdb->query("ALTER TABLE ".$DOPBSP->tables->settings_search." CHANGE unique_key name VARCHAR(128) DEFAULT '".$this->db_config->settings_search['name']."' COLLATE ".$this->db_collation." NOT NULL");
                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings_search.' DROP INDEX unique_key');
                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings_search.' ADD INDEX name (name)');
                    }
		}
            }
	    
	    /*
	     * Update availability - v2.6.4
	     */
	    function updateAvailability264(){
		global $DOT;
		
		$calendars = $DOT->models->calendars->get();
		
		foreach ($calendars as $calendar){
		    $DOT->models->availability->set($calendar->id);
		}
	    }
         
// Configuration
            
            /*
             * Set database configuration.
             * 
             * @param db_config (object): database configuration
             * 
             * @return database configuration
             */
            function config($db_config){
                /*
                 * API
                 */
                $db_config->api_keys = array('user_id' => 0,
                                             'api_key' => '');
		
                /*
                 * Availability
                 */
                $db_config->availability = array('calendar_id' => 0,
						 'date_start' => '0000-00-00 00:00:00',
						 'date_end' => '9999-01-01 00:00:00');
		
                /*
                 * Availability number.
                 */
                $db_config->availability_no = array('calendar_id' => 0,
						    'no_available' => 2,
						    'date_start' => '0000-00-00 00:00:00',
						    'date_end' => '9999-01-01 00:00:00');
		
                /*
                 * Availability price.
                 */
                $db_config->availability_price = array('calendar_id' => 0,
						       'price' => 0,
						       'date_start' => '0000-00-00 00:00:00',
						       'date_end' => '9999-01-01 00:00:00');
                
                /*
                 * Calendars
                 */
                $db_config->calendars = array('user_id' => 0,
                                              'post_id' => 0,
                                              'name' => '',
                                              'max_year' => 0,
                                              'hours_enabled' => 'false',
                                              'hours_interval_enabled' => 'false',
                                              'min_available' => 0,
                                              'price_min' => 0,
                                              'price_max' => 0,
                                              'rating' => 0,
                                              'address' => '',
                                              'address_en' => '',
                                              'address_alt' => '',
                                              'address_alt_en' => '',
                                              'coordinates' => '',
                                              'default_availability' => '{"available":1,"bind":0,"hours":{},"hours_definitions":[{"value":"00:00"}],"info":"","notes":"","price":0,"promo":0,"status":"none"}');
                
                /*
                 * Coupons
                 */
                $db_config->coupons = array('user_id' => 0,
                                            'name' => '',
                                            'code' => '',
                                            'start_time_lapse' => '',
                                            'end_time_lapse' => '',
                                            'start_date' => '',
                                            'end_date' => '',
                                            'start_hour' => '',
                                            'end_hour' => '',
                                            'no_coupons' => '',
                                            'operation' => '+',
                                            'price' => 0,
                                            'price_type' => 'fixed',
                                            'price_by' => 'once',
                                            'translation' => '');
                
                /*
                 * Days
                 */
                $db_config->days = array('calendar_id' => 0,
                                         'day' => '',
                                         'year' => date('Y'),
                                         'data' => '',
                                         'min_available' => 0,
                                         'price_min' => 0,
                                         'price_max' => 0);
                
                /*
                 * Discounts
                 */
                $db_config->discounts = array('user_id' => 0,
                                              'name' => '',
                                              'extras' => 'false');
                
                /*
                 * Discounts items.
                 */
                $db_config->discounts_items = array('discount_id' => 0,
                                                    'position' => 0,
                                                    'start_time_lapse' => '',
                                                    'end_time_lapse' => '',
                                                    'operation' => '-',
                                                    'price' => 0,
                                                    'price_type' => 'percent',
                                                    'price_by' => 'once',
                                                    'translation' => '');
                
                /*
                 * Discounts items rules.
                 */
                $db_config->discounts_items_rules = array('discount_item_id' => 0,
                                                          'position' => 0,
                                                          'start_date' => '',
                                                          'end_date' => '',
                                                          'start_hour' => '',
                                                          'end_hour' => '',
                                                          'operation' => '-',
                                                          'price' => 0,
                                                          'price_type' => 'percent',
                                                          'price_by' => 'once');
                
                /*
                 * Emails
                 */
                $db_config->emails = array('user_id' => 0,
                                           'name' => '');
                
                /*
                 * Emails translation.
                 */
                $db_config->emails_translation = array('email_id' => 0,
                                                       'template' => '',
                                                       'subject' => '',
                                                       'message' => '');
                
                /*
                 * Extras
                 */
                $db_config->extras = array('user_id' => 0,
                                           'name' => '');
                
                /*
                 * Extras groups.
                 */
                $db_config->extras_groups = array('extra_id' => 0,
                                                  'position' => 0,
                                                  'multiple_select' => 'false',
                                                  'required' => 'false',
                                                  'no_items_multiply' => 'true',
                                                  'translation' => '');
                
                /*
                 * Extras groups items.
                 */
                $db_config->extras_groups_items = array('group_id' => 0,
                                                        'position' => 0,
                                                        'operation' => '+',
                                                        'price' => 0,
                                                        'price_type' => 'fixed',
                                                        'price_by' => 'once',
                                                        'default' => 'no',
                                                        'translation' => '');
                
                /*
                 * Fees
                 */
                $db_config->fees = array('user_id' => 0,
                                         'name' => '',
                                         'operation' => '+',
                                         'price' => 0,
                                         'price_type' => 'fixed',
                                         'price_by' => 'once',
                                         'included' => 'true',
                                         'extras' => 'true',
                                         'cart' => 'true',
                                         'translation' => '');
                
                /*
                 * Forms
                 */
                $db_config->forms = array('user_id' => 0,
                                          'name' => '',
                                          'label' => '');
                
                /*
                 * Forms fields.
                 */
                $db_config->forms_fields = array('form_id' => 0,
                                                 'label' => '',
                                                 'type' => '',
                                                 'position' => 0,
                                                 'multiple_select' => 'false',
                                                 'allowed_characters' => '',
                                                 'size' => 0,
                                                 'is_email' => 'false',
                                                 'is_phone' => 'false',
                                                 'default_country' => 'US',
                                                 'required' => 'false',
                                                 'add_to_day_hour_info' => 'false',
                                                 'add_to_day_hour_body' => 'false',
                                                 'info' => '');
                
                /*
                 * Forms select options.
                 */
                $db_config->forms_fields_options = array('field_id' => 0,
                                                         'label' => '',
                                                         'position' => 0);
                
                /*
                 * Languages
                 */
                $db_config->languages = array('name' => '',
                                              'code' => '',
                                              'enabled' => 'false');
                
                /*
                 * Locations
                 */
                $db_config->locations = array('user_id' => 0,
                                              'name' => '',
                                              'address' => '',
                                              'address_en' => '',
                                              'address_alt' => '',
                                              'address_alt_en' => '',
                                              'coordinates' => '',
                                              'calendars' => '',
                                              'link' => '',
					      'image' => '',
					      'businesses' => '',
					      'businesses_other' => '',
					      'languages' => '',
					      'email' => '');
                
                /*
                 * Models
                 */
                $db_config->models = array('user_id' => 0,
                                           'name' => '',
					   'enabled' => 'true',
					   'multiple_calendars' => 'false',
					   'translation' => '',
					   'translation_calendar' => '');
                
                /*
                 * Reservations
                 */
                $db_config->reservations = array('calendar_id' => 0,
                                                 'language' => 'en',
                                                 'currency' => '$',
                                                 'currency_code' => 'USD',

                                                 'check_in' => '',
                                                 'check_out' => '',
                                                 'start_hour' => '',
                                                 'end_hour' => '',
                                                 'no_items' => 1,
                                                 'price' => 0,
                                                 'price_total' => 0,
                                                 'refund' => 0,

                                                 'extras' => '',
                                                 'extras_price' => 0,
                                                 'discount' => '',
                                                 'discount_price' => 0,
                                                 'coupon' => '',
                                                 'coupon_price' => 0,
                                                 'fees' => '',
                                                 'fees_price' => 0,
                                                 'deposit' => '',
                                                 'deposit_price' => 0,

                                                 'days_hours_history' => '',
                                                 'form' => '',
                                                 'address_billing' => '',
                                                 'address_shipping' => '',
                                            
                                                 'email' => '',
                                                 'phone' => '',
                                                 'status' => 'pending',
                                                 'payment_method' => 'default',
                                                 'payment_status' => 'pending',
                                                 'transaction_id' => '',
                                                 'token' => '',
                                                 'ip' => '',
                                                 'date_created' => '');
                
                /*
                 * Rules
                 */
                $db_config->rules = array('user_id' => 0,
                                          'name' => '',
                                          'time_lapse_min' => 0,
                                          'time_lapse_max' => 0);
                
                /*
                 * Search
                 */
                $db_config->searches = array('user_id' => 0,
                                             'name' => '',
                                             'calendars_excluded' => '',
                                             'currency' => 'USD',
                                             'currency_position' => 'before',
                                             'hours_enabled' => 'false');
                
                /*
                 * Settings
                 */
                $db_config->settings = array('name' => '',
                                             'value' => '');
                
                /*
                 * Settings calendar.
                 */
                $db_config->settings_calendar = array('calendar_id' => 0,
                                                      'name' => '',
                                                      'value' => '');
                
                /*
                 * Settings notifications.
                 */
                $db_config->settings_notifications = array('calendar_id' => 0,
                                                           'name' => '',
                                                           'value' => '');
                
                /*
                 * Settings payment.
                 */
                $db_config->settings_payment = array('calendar_id' => 0,
                                                     'name' => '',
                                                     'value' => '');
                
                /*
                 * Settings search.
                 */
                $db_config->settings_search = array('search_id' => 0,
                                                    'name' => '',
                                                    'value' => '');
                
                /*
                 * SMSes
                 */
                $db_config->smses = array('user_id' => 0,
                                          'name' => '');
                
                /*
                 * SMSes translation.
                 */
                $db_config->smses_translation = array('sms_id' => 0,
                                                      'template' => '',
                                                      'message' => '');
                
                /*
                 * Translation
                 */
                $db_config->translation = array('key_data' => '',
                                                'location' => 'backend',
                                                'parent_key' => '',
                                                'text_data' => '',
                                                'translation' => '');
                
                return $db_config;
            }
        }
    }