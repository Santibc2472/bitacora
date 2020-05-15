<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : addons/woocommerce/includes/class-database.php
* File Version            : 1.0
* Created / Last Modified : 04 December 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : WooCommerce database PHP class. IMPORTANT! Version, configuration, initialization, initial data, update,  need to be in same file because of issues with instalation/update via FTP.
*/

    if (!class_exists('DOPBSPWooCommerceDatabase')){
        class DOPBSPWooCommerceDatabase{
            /*
             * Private variables.
             */
            private $db_version = 1.002;
            
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Add database configuration.
                 */
                add_filter('dopbsp_filter_database_configuration', array(&$this, 'config'), 9);
                
                /*
                 * Initialize database.
                 */
                add_action('init', array(&$this, 'init'), 11);
                 
                /*
                 * Change database version if requested.
                 */
                if (DOPBSP_CONFIG_INIT_DATABASE
                        || DOPBSP_REPAIR_DATABASE_TEXT){
                    update_option('DOPBSP_db_version_woocommerce', '1.0');
                }
            }
            
// Database
            
            /*
             * Initialize plugin tables.
             */
            function init(){
                global $DOPBSP;
                global $DOPBSPWooCommerce;
                
                /*
                 * Get current database version.
                 */
                $current_db_version = get_option('DOPBSP_db_version_woocommerce');
                 
                if ($this->db_version != (float)$current_db_version){
                    require_once(str_replace('\\', '/', ABSPATH).'wp-admin/includes/upgrade.php');
                    
                    $sql_woocommerce = "CREATE TABLE " . $DOPBSPWooCommerce->tables->woocommerce . " (
                                            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                            cart_item_key VARCHAR(64) DEFAULT '".$DOPBSP->classes->database->db_config->woocommerce['cart_item_key']."' COLLATE ".$DOPBSP->classes->database->db_collation." NOT NULL,
                                            token VARCHAR(64) DEFAULT '".$DOPBSP->classes->database->db_config->woocommerce['token']."' COLLATE ".$DOPBSP->classes->database->db_collation." NOT NULL,
                                            order_item_id BIGINT UNSIGNED DEFAULT ".$DOPBSP->classes->database->db_config->woocommerce['order_item_id']." NOT NULL,
                                            product_id BIGINT UNSIGNED DEFAULT ".$DOPBSP->classes->database->db_config->woocommerce['product_id']." NOT NULL,
                                            calendar_id BIGINT UNSIGNED DEFAULT ".$DOPBSP->classes->database->db_config->woocommerce['calendar_id']." NOT NULL,
                                            language VARCHAR(8) DEFAULT '".$DOPBSP->classes->database->db_config->woocommerce['language']."' COLLATE ".$DOPBSP->classes->database->db_collation." NOT NULL,
                                            currency VARCHAR(32) DEFAULT '".$DOPBSP->classes->database->db_config->woocommerce['currency']."' COLLATE ".$DOPBSP->classes->database->db_collation." NOT NULL,
                                            currency_code VARCHAR(8) DEFAULT '".$DOPBSP->classes->database->db_config->woocommerce['currency_code']."' COLLATE ".$DOPBSP->classes->database->db_collation." NOT NULL,
                                            data TEXT COLLATE ".$DOPBSP->classes->database->db_collation." NOT NULL,
                                            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                                            UNIQUE KEY id (id),
                                            KEY cart_item_key (cart_item_key),
                                            KEY token (token),
                                            KEY order_item_id (order_item_id),
                                            KEY product_id (product_id),
                                            KEY date_created (date_created)
                                        );";
                    
                    /*
                     * Create/update the database tables.
                     */
                    dbDelta($sql_woocommerce);
                    
                    /*
                     * Update database version.
                     */
                    $current_db_version == '' ? add_option('DOPBSP_db_version_woocommerce', $this->db_version):update_option('DOPBSP_db_version_woocommerce', $this->db_version);
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
                 * WooCommerce
                 */
                $db_config->woocommerce = array('cart_item_key' => '',
                                                'token' => '',
                                                'order_item_id' => 0,
                                                'product_id' => 0,
                                                'calendar_id' => 0,
                                                'language' => '',
                                                'currency' => '',
                                                'currency_code' => '',
                                                'data' => '',
                                                'date_created' => '');
                
                return $db_config;
            }
        }
    }