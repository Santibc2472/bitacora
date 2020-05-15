<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/dashboard/class-backend-dashboard.php
* File Version            : 1.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end dashboard PHP class.
*/

    if (!class_exists('DOPBSPBackEndDashboard')){
        class DOPBSPBackEndDashboard extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
        
            /*
             * Prints out the dashboard page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->backend_dashboard->template(array('api_key' => $DOPBSP->classes->backend_api_key->get(),
                                                                  'server' => $this->get()));
            }
            
            /*
             * Get dashboard server environment.
             * 
             * @return data array
             */
            function get(){
                global $woocommerce;
                global $DOPBSP;
                
                $dopbsp = get_plugin_data($DOPBSP->paths->abs.'dopbs.php');
                
                /*
                 * WooCommerce
                 */
                $woocommerce = in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ? get_plugin_data($woocommerce->plugin_path().'/woocommerce.php'):false;
                
                /*
                 * MySQL
                 */
                $mysql_match = array();
                
                ob_start();
                phpinfo(INFO_MODULES); 
                $php_info = ob_get_contents(); 
                ob_end_clean(); 
                
                $php_info = stristr($php_info, 'Client API version'); 
                preg_match('/[1-9].[0-9].[1-9][0-9]/', $php_info, $mysql_match); 
                
                $mysql_version = $mysql_match[0];
                
                /*
                 * WordPress required memory limit.
                 */
                $required_wp_memory_limit = is_multisite() ? DOPBSP_CONFIG_SERVER_MEMORY_LIMIT_WP_MULTISITE:DOPBSP_CONFIG_SERVER_MEMORY_LIMIT_WP;
                
                /*
                 * cURL
                 */
                $curl_version = curl_version();
                
                $server = array(array('title' => $DOPBSP->text('DASHBOARD_SERVER_VERSION'),
                                      'required' => '',
                                      'available' => $dopbsp['Version'],
                                      'icon' => 'dopbsp-none'),
                    
                                array('title' => $DOPBSP->text('DASHBOARD_SERVER_WORDPRESS_VERSION'),
                                      'required' => DOPBSP_CONFIG_SERVER_WORDPRESS_VERSION,
                                      'available' => get_bloginfo('version'),
                                      'icon' => DOPBSP_CONFIG_SERVER_WORDPRESS_VERSION > get_bloginfo('version') ? 'dopbsp-error':'dopbsp-success'),
                    
                                array('title' => $DOPBSP->text('DASHBOARD_SERVER_WORDPRESS_MULTISITE'),
                                      'required' => $DOPBSP->text('DASHBOARD_SERVER_NO'),
                                      'available' => is_multisite() ? $DOPBSP->text('DASHBOARD_SERVER_YES'):$DOPBSP->text('DASHBOARD_SERVER_NO'),
                                      'icon' => 'dopbsp-none'),
                    
                                array('title' => $DOPBSP->text('DASHBOARD_SERVER_WOOCOMMERCE_VERSION').' '.(DOPBSP_CONFIG_WOOCOMMERCE_ENABLE_CODE ? '['.$DOPBSP->text('DASHBOARD_SERVER_WOOCOMMERCE_ENABLE_CODE').']':''),
                                      'required' => !$woocommerce ? $DOPBSP->text('DASHBOARD_SERVER_NO'):DOPBSP_CONFIG_SERVER_WOOCOMMERCE_VERSION,
                                      'available' => !$woocommerce ? $DOPBSP->text('DASHBOARD_SERVER_NO'):$woocommerce['Version'],
                                      'icon' => !$woocommerce ? (DOPBSP_CONFIG_WOOCOMMERCE_ENABLE_CODE ? 'dopbsp-warning':'dopbsp-none'):(DOPBSP_CONFIG_SERVER_WOOCOMMERCE_VERSION > $woocommerce['Version'] ? 'dopbsp-error':'dopbsp-success')),
                    
                                array('title' => $DOPBSP->text('DASHBOARD_SERVER_PHP_VERSION'),
                                      'required' => DOPBSP_CONFIG_SERVER_PHP_VERSION,
                                      'available' => phpversion(),
                                      'icon' => DOPBSP_CONFIG_SERVER_PHP_VERSION > phpversion() ? 'dopbsp-error':'dopbsp-success'),
                    
                                array('title' => $DOPBSP->text('DASHBOARD_SERVER_MYSQL_VERSION'),
                                      'required' => DOPBSP_CONFIG_SERVER_MYSQL_VERSION,
                                      'available' => $mysql_version,
                                      'icon' => DOPBSP_CONFIG_SERVER_MYSQL_VERSION > $mysql_version ? 'dopbsp-error':'dopbsp-success'),
                    
                                array('title' => $DOPBSP->text('DASHBOARD_SERVER_MEMORY_LIMIT'),
                                      'required' => DOPBSP_CONFIG_SERVER_MEMORY_LIMIT,
                                      'available' => ini_get('memory_limit'),
                                      'icon' => (int)DOPBSP_CONFIG_SERVER_MEMORY_LIMIT > (int)ini_get('memory_limit') ? 'dopbsp-warning':'dopbsp-success'),
                    
                                array('title' => $DOPBSP->text('DASHBOARD_SERVER_MEMORY_LIMIT_WP'),
                                      'required' => $required_wp_memory_limit,
                                      'available' => WP_MEMORY_LIMIT,
                                      'icon' =>  (int)DOPBSP_CONFIG_SERVER_MEMORY_LIMIT > (int)$required_wp_memory_limit ? 'dopbsp-error':((int)$required_wp_memory_limit > (int)WP_MEMORY_LIMIT ? 'dopbsp-warning':'dopbsp-success')),
                    
                                array('title' => $DOPBSP->text('DASHBOARD_SERVER_MEMORY_LIMIT_WP_MAX'),
                                      'required' => '',
                                      'available' => WP_MAX_MEMORY_LIMIT,
                                      'icon' => (int)DOPBSP_CONFIG_SERVER_MEMORY_LIMIT > WP_MAX_MEMORY_LIMIT ? 'dopbsp-error':'dopbsp-none'),
                    
                                array('title' => $DOPBSP->text('DASHBOARD_SERVER_MEMORY_LIMIT_WOOCOMMERCE'),
                                      'required' => !$woocommerce && !DOPBSP_CONFIG_WOOCOMMERCE_ENABLE_CODE ? '':DOPBSP_CONFIG_SERVER_MEMORY_LIMIT_WOOCOMMERCE,
                                      'available' => ini_get('memory_limit'),
                                      'icon' => (int)DOPBSP_CONFIG_SERVER_MEMORY_LIMIT_WOOCOMMERCE > (int)ini_get('memory_limit') ? 'dopbsp-warning':'dopbsp-success'),
                    
                                array('title' => $DOPBSP->text('DASHBOARD_SERVER_CURL_VERSION'),
                                      'required' => DOPBSP_CONFIG_SERVER_CURL_VERSION,
                                      'available' => $curl_version['version'],
                                      'icon' => (float)DOPBSP_CONFIG_SERVER_CURL_VERSION > (float)$curl_version['version'] ? 'dopbsp-warning':'dopbsp-success'));
                
                return $server;
            }
        }
    }