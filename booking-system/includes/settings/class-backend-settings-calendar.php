<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/settings/class-backend-settings-calendar.php
* File Version            : 1.0.6
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end calendar settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettingsCalendar')){
        class DOPBSPBackEndSettingsCalendar extends DOPBSPBackEndSettings{
            /*
             * Constructor
             */
            function __construct(){
                add_filter('dopbsp_filter_default_settings_calendar', array(&$this, 'defaults'), 9);
            }
            
            /*
             * Display calendar settings
             * 
             * @post id (integer): calendar ID
             * 
             * @return calendar settings HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $DOPBSP->views->backend_settings_calendar->template(array('id' => $DOT->post('id', 'int')));
                
                die();
            }
            
            /*
             * Set default calendar settings.
             * 
             * @param default_calendar (array): default calendar options values
             * 
             * @return default calendar settings array
             */
            function defaults($default_calendar){
                $default_calendar = array('date_type' => '1',
                                          'template' => 'default',
                                          'booking_stop' => '0',
                                          'months_no' => '1',
                                          'view_only' => 'false',
                                          'server_time' => 'false',
                                          'hide_price' => 'false',
                                          'hide_no_available' => 'false',
                                          'minimum_no_available' => '1',
                                          'timezone' => '',
                                          'max_year' => date('Y'), // REMOVE AFTER UPDATE 4.0

                                          'currency' => 'USD',
                                          'currency_position' => 'before',
                    
//                                          'price_thousand_separator' => ',',
//                                          'price_decimal_separator' => '.',
//                                          'price_decimals_no' => '2',

                                          'days_available' => 'true,true,true,true,true,true,true',
                                          'days_details_from_hours' => 'true',
                                          'days_first' => '1',
                                          'days_first_displayed' => '',
                                          'days_morning_check_out' => 'false',
                                          'days_multiple_select' => 'true',

                                          'hours_add_last_hour_to_total_price' => 'true',
                                          'hours_ampm' => 'false',
                                          'hours_definitions' => '[{"value": "00:00"}]',
                                          'hours_enabled' => 'false',
                                          'hours_info_enabled' => 'true',
                                          'hours_interval_enabled' => 'false',
                                          'hours_interval_autobreak_enabled' => 'false',
                                          'hours_multiple_select' => 'true',

                                          'sidebar_no_items_enabled' => 'true',
                                          'sidebar_style' => '1',

                                          'rule' => '0',
                                          'extra' => '0',
                                          'cart_enabled' => 'false',
                                          'discount' => '0',
                                          'fees' => '',
                                          'coupon' => '0',

                                          'deposit' => '0',
                                          'deposit_type' => 'percent',
                                          'deposit_pay_full_amount' => 'true',

                                          'form' => '1',
                    
                                          'terms_and_conditions_enabled' => 'false',
                                          'terms_and_conditions_link' => '',
                                         
                                          'ical_url' => '',
                                         
                                          'google_enabled' => 'false',
                                          'google_client_id' => '',
                                          'google_client_secret' => '',
                                          'google_calendar_id' => '',
                                          'google_feed_url' => '',
                                          'google_sync_time' => '3600',
                                         
                                          'airbnb_enabled' => 'false',
                                          'airbnb_feed_url' => '',
                                          'airbnb_sync_time' => '3600');
                
                return $default_calendar;
            } 
        }
    }