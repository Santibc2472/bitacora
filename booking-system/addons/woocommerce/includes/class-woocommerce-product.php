<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : addons/woocommerce/includes/class-woocommerce-product.php
* File Version            : 1.0
* Created / Last Modified : 04 December 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : WooCommerce product PHP class.
*/

    if (!class_exists('DOPBSPWooCommerceProduct')){
        class DOPBSPWooCommerceProduct{
            /*
             * Constructor.
             */
            function __construct(){
                global $product;
                /*
                 * Add calendar in product summary.
                 */
                add_filter('woocommerce_single_product_summary', array(&$this, 'summary'), 25);
                
                /*
                 * Add calendar in product tab.
                 */
                add_filter('woocommerce_product_tabs', array(&$this, 'tab'));
                
                /*
                 * Display minimum price from calendar.
                 */
                // add_filter('woocommerce_get_price_html', array(&$this, 'price'), $product, 2);
            }
            
            /*
             * Add booking calendar in product summary section.
             * 
             * @return sidebar HTML or calendar shortcode
             */
            function summary(){
                global $post;
	
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? 'en':get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true),
                                                    'add_to_cart' => get_post_meta($post->ID, 'dopbsp_woocommerce_add_to_cart', true) == '' ? 'false':get_post_meta($post->ID, 'dopbsp_woocommerce_add_to_cart', true));
                    
                if ($dopbsp_woocommerce_options['calendar'] != '' 
                        && $dopbsp_woocommerce_options['calendar'] != '0'){
                    /*
                     * Add all calendar.
                     */
                    if ($dopbsp_woocommerce_options['position'] == 'summary'){
                        echo do_shortcode('[dopbsp id='.$dopbsp_woocommerce_options['calendar'].' lang='.$dopbsp_woocommerce_options['language'].' woocommerce=true woocommerce_product_id='.$post->ID.' woocommerce_position='.$dopbsp_woocommerce_options['position'].' woocommerce_add_to_cart='.$dopbsp_woocommerce_options['add_to_cart'].']');
                    }
                
                    /*
                     * Add only sidebar.
                     */    
                    if ($dopbsp_woocommerce_options['position'] == 'summary-tabs'){
                        echo '<div class="DOPBSPCalendar-sidebar" id="DOPBSPCalendar-outer-sidebar'.$dopbsp_woocommerce_options['calendar'].'"></div>';
                    }
                }
            }
            
            /*
             * Add booking calendar in product tab section.
             * 
             * @return tab object
             */
            function tab(){
		global $post;
                global $DOPBSP;
                
		$tab = array();
	
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? 'en':get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true),
                                                    'add_to_cart' => get_post_meta($post->ID, 'dopbsp_woocommerce_add_to_cart', true) == '' ? 'false':get_post_meta($post->ID, 'dopbsp_woocommerce_add_to_cart', true));
                
                if ($dopbsp_woocommerce_options['calendar'] != '' 
                        && $dopbsp_woocommerce_options['calendar'] != '0' 
                        && ($dopbsp_woocommerce_options['position'] == 'tabs' 
                                || $dopbsp_woocommerce_options['position'] == 'summary-tabs')){
                    
                    $DOPBSP->classes->translation->set($dopbsp_woocommerce_options['language'],
                                                       false);
                    
                    $tab['booking-system'] = array('title' => $DOPBSP->text('WOOCOMMERCE_TABS'),
                                                   'priority' => 1,
                                                   'callback' => array($this, 'tabContent'));
                    return $tab;
                }
            }
            
            /*
             * Add booking calendar in product tab section.
             * 
             * @return calendar shortcode
             */
            function tabContent(){
                global $post;
	
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? 'en':get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true),
                                                    'add_to_cart' => get_post_meta($post->ID, 'dopbsp_woocommerce_add_to_cart', true) == '' ? 'false':get_post_meta($post->ID, 'dopbsp_woocommerce_add_to_cart', true));
                    
                echo do_shortcode('[dopbsp id='.$dopbsp_woocommerce_options['calendar'].' lang='.$dopbsp_woocommerce_options['language'].' woocommerce=true woocommerce_product_id='.$post->ID.' woocommerce_position='.$dopbsp_woocommerce_options['position'].' woocommerce_add_to_cart='.$dopbsp_woocommerce_options['add_to_cart'].']');
            }
            
            
            /*
             * Display minimum price from calendar on product page.
             * 
             * @param price (string): current price html
             * @param product (object): product data
             * 
             * @return price html
             */
            function price($price,
                           $product){
                global $wpdb;
                global $DOPBSP;
                
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($product->get_id(), 'dopbsp_woocommerce_calendar', true));
                    
                if ($dopbsp_woocommerce_options['calendar'] != '' 
                        && $dopbsp_woocommerce_options['calendar'] != '0'){
                    $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                              $dopbsp_woocommerce_options['calendar']));
                    
                    $settings_calendar = $DOPBSP->classes->backend_settings->values($calendar->id,  
                                                                                    'calendar');
                    $price_value = $DOPBSP->classes->price->set($calendar->price_min,
                                                                $DOPBSP->classes->currencies->get($settings_calendar->currency),
                                                                $settings_calendar->currency_position);
                    $price = '<span class="amount">'.$DOPBSP->text('WOOCOMMERCE_STARTING_FROM').': '.$price_value.'</span>';
                }
                
                return $price;
            }  
        }
    }