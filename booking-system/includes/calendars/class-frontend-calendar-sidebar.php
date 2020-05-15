<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/calendars/class-frontend-calendar-sidebar.php
* File Version            : 1.0.2
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end calendar sidebar PHP class.
*/

    if (!class_exists('DOPBSPFrontEndCalendarSidebar')){
        class DOPBSPFrontEndCalendarSidebar extends DOPBSPFrontEndCalendar{
            /*
             * Constructor.
             */
            function __construct(){
            }
            
            /*
             * Get sidebar options.
             * 
             * @param settings (object): calendar settings
             * @param woocommerce (string): check if WooCommerce is enabled 
             *                              "true"
             *                              "false"
             * @param woocommerce_position (string): booking calendar elements position on product page
             *                                       "summary"
             *                                       "summary-tabs"
             *                                       "tabs"
             * 
             * @return data array
             */
            function get($settings,
                         $woocommerce,
                         $woocommerce_position){
                $positions = array();
                
                $sidebar_style = (int)$settings->sidebar_style;
                $cart_enabled = $settings->cart_enabled;
                
                if ($woocommerce == 'true'){
                    $cart_enabled = 'false';
                            
                    if ($woocommerce_position != 'tabs'){
                        $sidebar_style = 4;
                    }
                    elseif ($sidebar_style == 3){
                        if ($settings->extra != 0){
                            $sidebar_style = 2;
                        }
                        else{
                            $sidebar_style = 1;
                        }
                    }
                    elseif ($sidebar_style == 2
                                && $settings->extra == 0){
                            $sidebar_style = 1;
                    }
                }
                
                switch ($sidebar_style){
                    case 2:
                        $positions = array('search' => array('column' => 1,
                                                             'row' => 1),
                                           'extras' => array('column' => $woocommerce == 'false' ? 1:3,
                                                             'row' => 2),       
                                           'coupons' => array('column' => 1,
                                                             'row' => 3),    
                                           'reservation' => array('column' => $cart_enabled == 'true' ? 2:($woocommerce == 'false' ? 3:4),
                                                                  'row' => 1),
                                           'cart' => array('column' => 3,
                                                           'row' => 1),
                                           'form' => array('column' => 4,
                                                           'row' => 1),
                                           'order' => array('column' => 4,
                                                            'row' =>  2));
                        break;
                    case 3:
                        $positions = array('search' => array('column' => 1,
                                                             'row' => 1),
                                           'extras' => array('column' => 1,
                                                             'row' => 2),     
                                           'coupons' => array('column' => 1,
                                                             'row' => 3),      
                                           'reservation' => array('column' => 2,
                                                                  'row' => 1),
                                           'cart' => array('column' => 3,
                                                           'row' => 1),
                                           'form' => array('column' => $cart_enabled == 'true' ? 4:3,
                                                           'row' => 1),
                                           'order' => array('column' => 4,
                                                            'row' =>  $cart_enabled == 'true' ? 2:1));
                        break;
                    case 4:
                        $positions = array('search' => array('column' => 1,
                                                             'row' => 1),
                                           'extras' => array('column' => 1,
                                                             'row' => 2),         
                                           'coupons' => array('column' => 1,
                                                             'row' => 3),    
                                           'reservation' => array('column' => 1,
                                                                  'row' => 4),
                                           'cart' => array('column' => 1,
                                                           'row' => 5),
                                           'form' => array('column' => 1,
                                                           'row' => 6),
                                           'order' => array('column' => 1,
                                                            'row' => 7));
                        break;
                    case 5:
                        $positions = array('search' => array('column' => 1,
                                                             'row' => 1),
                                           'extras' => array('column' => 1,
                                                             'row' => 2),         
                                           'coupons' => array('column' => 1,
                                                             'row' => 3),    
                                           'reservation' => array('column' => 1,
                                                                  'row' => 4),
                                           'cart' => array('column' => 1,
                                                           'row' => 5),
                                           'form' => array('column' => 1,
                                                           'row' => 6),
                                           'order' => array('column' => 1,
                                                            'row' => 7));
                        break;
                    default:
                        $positions = array('search' => array('column' => 1,
                                                             'row' => 1),
                                           'extras' => array('column' => 1,
                                                             'row' => 2),
                                           'coupons' => array('column' => 1,
                                                             'row' => 3),       
                                           'reservation' => array('column' => $settings->extra != 0 || $woocommerce == 'true' ? 2:1,
                                                                  'row' => $settings->extra != 0 || $woocommerce == 'true' ? 1:4),
                                           'cart' => array('column' => 2,
                                                           'row' => 2),
                                           'form' => array('column' => 2,
                                                           'row' => 3),
                                           'order' => array('column' => 2,
                                                            'row' => 4));
                }
                
                return array('data' => array('noItems' => $settings->sidebar_no_items_enabled == 'true' ? true:false,
                                             'positions' => $positions,
                                             'style' => $sidebar_style),
                             'text' => array());
            }
        }
    }