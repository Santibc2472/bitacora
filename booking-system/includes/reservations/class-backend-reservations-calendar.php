<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/reservations/class-backend-reservations.php
* File Version            : 1.1.4
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservations PHP class.
*/

    if (!class_exists('DOPBSPBackEndReservationsCalendar')){
        class DOPBSPBackEndReservationsCalendar extends DOPBSPBackEndReservations{
            /*
             * Constructor.
             */
            function __construct(){
            }
            
            /*
             * Get calendar options in JSON format.
             * 
             * @post calendar_id (integer): calendar ID
             * 
             * @return options JSON
             */
            function getJSON(){
		global $DOT;
                global $DOPBSP;
                
                $data = array();
                
                $id = $DOT->post('calendar_id', 'int');
                $language =  $DOPBSP->classes->backend_language->get();
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($id,  
                                                                                'calendar');
                $settings_payment = $DOPBSP->classes->backend_settings->values($id,  
                                                                               'payment');
                
                /*
                 * JSON data.
                 */
                $data = array('calendar' => array('data' => array('bookingStop' => 0,
                                                                  'dateType' => (int)$settings_calendar->date_type,
                                                                  'language' => $language,
                                                                  'languages' => $DOPBSP->classes->languages->languages,
                                                                  'pluginURL' => $DOPBSP->paths->url,
                                                                  'maxYear' => $DOPBSP->classes->backend_calendar->getMaxYear($id),
                                                                  'reinitialize' => false,
                                                                  'view' => $settings_calendar->view_only == 'true' ? true:false),
                                                  'text' => array('addMonth' => $DOPBSP->text('CALENDARS_CALENDAR_ADD_MONTH_VIEW'),
                                                                  'available' => $DOPBSP->text('CALENDARS_CALENDAR_AVAILABLE_ONE_TEXT'),
                                                                  'availableMultiple' => $DOPBSP->text('CALENDARS_CALENDAR_AVAILABLE_TEXT'),
                                                                  'booked' => $DOPBSP->text('CALENDARS_CALENDAR_BOOKED_TEXT'),
                                                                  'nextMonth' => $DOPBSP->text('CALENDARS_CALENDAR_NEXT_MONTH'),
                                                                  'previousMonth' => $DOPBSP->text('CALENDARS_CALENDAR_PREVIOUS_MONTH'),
                                                                  'removeMonth' => $DOPBSP->text('CALENDARS_CALENDAR_REMOVE_MONTH_VIEW'),
                                                                  'unavailable' => $DOPBSP->text('CALENDARS_CALENDAR_UNAVAILABLE_TEXT'))), 
                              'coupons' => $DOPBSP->classes->frontend_coupons->get($settings_calendar->coupon,
                                                                                   $language),
                              'currency' => array('data' => array('code' => $settings_calendar->currency,
                                                                  'position' => $settings_calendar->currency_position,
                                                                  'sign' => $DOPBSP->classes->currencies->get($settings_calendar->currency),
                                                  'text' => array())),
                              'days' => array('data' => array('available' => $DOPBSP->classes->frontend_calendar->getAvailableDays($settings_calendar->days_available),
                                                              'first' => (int)$settings_calendar->days_first,
                                                              'morningCheckOut' => $settings_calendar->days_multiple_select == 'false' || $settings_calendar->hours_enabled == 'true' ? false:($settings_calendar->days_morning_check_out == 'true' ? true:false),
                                                              'multipleSelect' => $settings_calendar->hours_enabled == 'true' ? false:($settings_calendar->days_multiple_select == 'true' ? true:false)),
                                              'text' => array('names' => array($DOPBSP->text('DAY_SUNDAY'), 
                                                                               $DOPBSP->text('DAY_MONDAY'), 
                                                                               $DOPBSP->text('DAY_TUESDAY'), 
                                                                               $DOPBSP->text('DAY_WEDNESDAY'), 
                                                                               $DOPBSP->text('DAY_THURSDAY'), 
                                                                               $DOPBSP->text('DAY_FRIDAY'), 
                                                                               $DOPBSP->text('DAY_SATURDAY')),
                                                              'shortNames' => array($DOPBSP->text('SHORT_DAY_SUNDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_MONDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_TUESDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_WEDNESDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_THURSDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_FRIDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_SATURDAY')))),
                              'deposit' => array('data' => array('deposit' => (float)$settings_calendar->deposit,
                                                                 'type' => $settings_calendar->deposit_type),
                                                 'text' => array('left' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT_LEFT'),
                                                                 'title' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT'))), 
                              'discounts' => $DOPBSP->classes->frontend_discounts->get($settings_calendar->discount,
                                                                                       $language),
                              'extras' => $DOPBSP->classes->frontend_extras->get($settings_calendar->extra,
                                                                                 $language),
                              'fees' => $DOPBSP->classes->frontend_fees->get($settings_calendar->fees,
                                                                             $language),
                              'form' => $DOPBSP->classes->frontend_forms->get($settings_calendar->form,
                                                                              $language),
                              'hours' => array('data' => array('addLastHourToTotalPrice' => $settings_calendar->hours_multiple_select == 'false' ? true:($settings_calendar->hours_add_last_hour_to_total_price == 'true' && $settings_calendar->hours_interval_enabled == 'false' ? true:false),
                                                               'ampm' => $settings_calendar->hours_ampm == 'true' ? true:false,
                                                               'definitions' => json_decode($settings_calendar->hours_definitions),
                                                               'enabled' => $settings_calendar->hours_enabled == 'true' ? true:false,
                                                               'info' => $settings_calendar->hours_info_enabled == 'true' ? true:false,
                                                               'interval' => $settings_calendar->hours_multiple_select == 'false' ? false:($settings_calendar->hours_interval_enabled == 'true' ? true:false),
                                                               'interval_autobreak' => $settings_calendar->hours_multiple_select == 'false' ? false:($settings_calendar->hours_interval_autobreak_enabled == 'true' ? true:false),
                                                               'multipleSelect' => $settings_calendar->hours_multiple_select == 'true' ? true:false),
                                               'text' => array()),
                              'ID' => $id,
                              'months' => array('data' => array('no' => 1),
                                                'text' => array('names' => array($DOPBSP->text('MONTH_JANUARY'), 
                                                                                 $DOPBSP->text('MONTH_FEBRUARY'),  
                                                                                 $DOPBSP->text('MONTH_MARCH'),
                                                                                 $DOPBSP->text('MONTH_APRIL'),  
                                                                                 $DOPBSP->text('MONTH_MAY'),  
                                                                                 $DOPBSP->text('MONTH_JUNE'),  
                                                                                 $DOPBSP->text('MONTH_JULY'),  
                                                                                 $DOPBSP->text('MONTH_AUGUST'),  
                                                                                 $DOPBSP->text('MONTH_SEPTEMBER'),  
                                                                                 $DOPBSP->text('MONTH_OCTOBER'),  
                                                                                 $DOPBSP->text('MONTH_NOVEMBER'),  
                                                                                 $DOPBSP->text('MONTH_DECEMBER')),
                                                                'shortNames' => array($DOPBSP->text('SHORT_MONTH_JANUARY'),  
                                                                                      $DOPBSP->text('SHORT_MONTH_FEBRUARY'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_MARCH'),
                                                                                      $DOPBSP->text('SHORT_MONTH_APRIL'),
                                                                                      $DOPBSP->text('SHORT_MONTH_MAY'),
                                                                                      $DOPBSP->text('SHORT_MONTH_JUNE'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_JULY'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_AUGUST'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_SEPTEMBER'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_OCTOBER'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_NOVEMBER'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_DECEMBER')))),
                              'order' => $DOPBSP->classes->frontend_order->get($settings_calendar,
                                                                               $settings_payment),
                              'reservation' => $DOPBSP->classes->frontend_reservations->get(),
                              'rules' => $DOPBSP->classes->frontend_rules->get($settings_calendar->rule,
                                                                               $language),
                              'search' => $DOPBSP->classes->frontend_search->get(),
                              'sidebar' => $DOPBSP->classes->frontend_calendar_sidebar->get($settings_calendar,
                                                                                            'false',
                                                                                            ''));
                
                echo json_encode($data);
                
                die();
            }
          
            /*
             * Get calendar reservations in JSON format.
             */
            function get(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $calendar_id = $DOT->post('calendar_id', 'int');
                
                $reservations = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE calendar_id=%d AND (token="" OR (token<>"" AND (payment_method="none" OR payment_method="default"))) AND status<>"expired" ORDER BY check_in ASC, start_hour ASC',
                                                                  $calendar_id));
                echo json_encode($reservations);
                
            	die();      
            }
        }
    }