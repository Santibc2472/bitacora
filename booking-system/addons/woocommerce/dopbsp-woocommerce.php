<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : addons/woocommerce/dopbsp-woocommerce.php
* File Version            : 1.0
* Created / Last Modified : 04 December 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : WooCommerce PHP class.
*/

    DOPBSPErrorsHandler::start();
    
    try{
        /*
         * Classses
         */
        include_once 'includes/class-woocommerce-cart.php';
        include_once 'includes/class-woocommerce-category.php';
        include_once 'includes/class-woocommerce-database.php';
        include_once 'includes/class-woocommerce-order.php';
        include_once 'includes/class-woocommerce-product.php';
        include_once 'includes/class-woocommerce-tab.php';
        include_once 'includes/class-woocommerce-translation-text.php';
    }
    catch(Exception $ex){
        add_action('admin_notices', 'dopbspMissingFiles');
    }
    
    DOPBSPErrorsHandler::finish();
    
    /*
     * Global classes.
     */
    global $DOPBSPWooCommerce;

    if (!class_exists('DOPBSPWooCommerce')){
        class DOPBSPWooCommerce{
            /*
             * Public variables.
             */
            public $classes;
            public $tables;
            
            /*
             * Constructor
             */
            function __construct(){
		global $DOT;
		
                $this->classes = new stdClass;
                $this->tables = new stdClass;
                
                $this->defineTables();
                
                /*
                 * Initialize classes.
                 */
                $this->initClasses();
                
//                if (!is_admin() 
//                        || $DOT->post('dopbsp_frontend_ajax_request')){
                    $this->initFrontEndAJAX();
//                }
            }
            
            /*
             * Defines plugin's tables constants.
             */
            function defineTables(){
                global $wpdb;

                /*
                 * WooCommerce table.
                 */
                $this->tables->woocommerce = $wpdb->prefix.'dopbsp_woocommerce';
            }
            
            /*
             * Initialize PHP classes.
             */
            function initClasses(){
                /*
                 * Initialize database class. This class is the 1st initialized.
                 */
                $this->classes->database = class_exists('DOPBSPWooCommerceDatabase') ? new DOPBSPWooCommerceDatabase():'Class does not exist!';
    
                /*
                 * Initialize translation class. This class is the 2nd initialized.
                 */
                class_exists('DOPBSPWooCommerceTranslationText') ? new DOPBSPWooCommerceTranslationText():'Class does not exist!';

                /*
                 * Initialize WooCommerce cart class.
                 */
                $this->classes->cart = class_exists('DOPBSPWooCommerceCart') ? new DOPBSPWooCommerceCart():'Class does not exist!';
                
                /*
                 * Initialize WooCommerce category class.
                 */
                $this->classes->category = class_exists('DOPBSPWooCommerceCategory') ? new DOPBSPWooCommerceCategory():'Class does not exist!';
                
                /*
                 * Initialize WooCommerce order class.
                 */
                $this->classes->order = class_exists('DOPBSPWooCommerceOrder') ? new DOPBSPWooCommerceOrder():'Class does not exist!';
                
                /*
                 * Initialize WooCommerce product class.
                 */
                $this->classes->product = class_exists('DOPBSPWooCommerceProduct') ? new DOPBSPWooCommerceProduct():'Class does not exist!';
                
                /*
                 * Initialize WooCommerce tab class.
                 */
                $this->classes->tab = class_exists('DOPBSPWooCommerceTab') ? new DOPBSPWooCommerceTab():'Class does not exist!';
            }
            
            /*
             * Initialize front end AJAX requests. 
             */
            function initFrontEndAJAX(){
                /*
                 * WooCommerce front end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_woocommerce_add_to_cart', array(&$this->classes->cart, 'add'));
                add_action('wp_ajax_nopriv_dopbsp_woocommerce_add_to_cart', array(&$this->classes->cart, 'add'));
            }
            
            /*
             * Clean unused reservations.
             */
            function clean(){
                global $wpdb;
                
                $wpdb->query('SELECT * FROM '.$this->tables->woocommerce.' WHERE date_created < DATE_SUB(CURDATE(),INTERVAL 2 MONTH)');
            }
        }
        
        $DOPBSPWooCommerce = new DOPBSPWooCommerce();
    }