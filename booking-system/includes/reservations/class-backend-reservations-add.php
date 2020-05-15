<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : includes/reservations/class-backend-reservations-add.php
* File Version            : 1.1
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservations add PHP class.
*/

    if (!class_exists('DOPBSPBackEndReservationsAdd')){
        class DOPBSPBackEndReservationsAdd extends DOPBSPBackEndReservations{
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
                global $wpdb;
                global $DOPBSP;
                
                $data = array();
                
                $id = $DOT->post('calendar_id', 'int');
                $language =  $DOPBSP->classes->backend_language->get();
                
                $settings_calendar = $DOPBSP->classes->backend_settings->values($id,  
                                                                                'calendar');
                $settings_payment = $DOPBSP->classes->backend_settings->values($id,  
                                                                               'payment');
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                          $id));
                
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
                              'cart' => array('data' => array('enabled' => false),
                                              'text' => array('isEmpty' => $DOPBSP->text('CART_IS_EMPTY'),
                                                              'title' => $DOPBSP->text('CART_TITLE'))),
                              'coupons' => $DOPBSP->classes->frontend_coupons->get($settings_calendar->coupon,
                                                                                   $language),
                              'currency' => array('data' => array('code' => $settings_calendar->currency,
                                                                  'position' => $settings_calendar->currency_position,
                                                                  'sign' => $DOPBSP->classes->currencies->get($settings_calendar->currency),
                                                  'text' => array())),
                              'days' => array('data' => array('available' => $DOPBSP->classes->frontend_calendar->getAvailableDays($settings_calendar->days_available),
                                                              'first' => (int)$settings_calendar->days_first,
                                                              'firstDisplayed' => $settings_calendar->days_first_displayed,
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
                                                               'interval' => $settings_calendar->hours_interval_enabled == 'true' ? true:false,
                                                               'interval_autobreak' => $settings_calendar->hours_interval_enabled == 'false' ? false:($settings_calendar->hours_interval_autobreak_enabled == 'true' ? true:false),
                                                               'multipleSelect' => $settings_calendar->hours_multiple_select == 'true' ? true:false),
                                               'text' => array()),
                              'ID' => $id,
                              'default_schedule' => $calendar->default_availability != '' ? $calendar->default_availability:'{"available":1,"bind":0,"hours":{},"hours_definitions":[{"value":"00:00"}],"info":"","notes":"","price":0,"promo":0,"status":"none"}',
                              'months' => array('data' => array('no' => 3),
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
                                                                                            ''),
                              'woocommerce' => array('data' => array('add_to_cart' => false,
                                                                     'enabled' => false,
                                                                     'product_id' => 0),
                                                     'text' => array('none' => $DOPBSP->text('WOOCOMMERCE_PRODUCT_NONE'),
                                                                     'reservation' => $DOPBSP->text('WOOCOMMERCE_PRODUCT_RESERVATION'),
                                                                     'addToCart' => $DOPBSP->text('WOOCOMMERCE_ADD_TO_CART'))));
                
                echo json_encode($data);
                
                die();
            }
            
            /*
             * Book a reservation.
             * 
             * @post calendar_id (integer): calendar ID
             * @post language (string): selected language
             * @post currency (string): selected currency sign
             * @post currency_code (string): selected currency code
             * @post cart_data (array): list of reservations
             * @post form (object): form data
             * @post address_billing (object): billing address details
             * @post address_shipping (object): shipping address details
             * @post status (object): reservation status
             * @post payment_method (string): selected payment method
             * @post transaction_id (object): transaction ID
             */
            function book(){
		global $DOT;
                global $DOPBSP;
                    
                $calendar_id = $DOT->post('calendar_id', 'int');
                $language = $DOT->post('language');
                $currency = $DOT->post('currency');
                $currency_code = $DOT->post('currency_code');
                $cart = $DOT->post('cart_data');
                $form = $DOT->post('form');
                $address_billing = $DOT->post('address_billing_data');
                $address_shipping = $DOT->post('address_shipping_data');
                $status = $DOT->post('status');
                $payment_method = $DOT->post('payment_method');
                $transaction_id = $DOT->post('transaction_id');
                
                /*
                 * Verify reservations.
                 */
                $settings_payment = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                               'payment');
                
                for ($i=0; $i<count($cart); $i++){
                    $reservation = $cart[$i];
                    
                    if (($payment_method != 'default' 
                                    && $payment_method != 'none')
                            || $settings_payment->arrival_with_approval_enabled == 'true'){
                        /*
                         * Verify reservations availability.
                         */
                        if ($reservation['start_hour'] == ''){
                            if (!$DOPBSP->classes->backend_calendar_schedule->validateDays($calendar_id, $reservation['check_in'], $reservation['check_out'], $reservation['no_items'])){
                                echo 'unavailable';
                                die();
                            }
                        }
                        else{
                            if (!$DOPBSP->classes->backend_calendar_schedule->validateHours($calendar_id, $reservation['check_in'], $reservation['start_hour'], $reservation['end_hour'], $reservation['no_items'])){
                                echo 'unavailable';
                                die();
                            }
                        }
                
                        /*
                         * Verify coupon.
                         */
                        $coupon = $reservation['coupon'];
                        
                        if ($coupon['id'] != 0){
                            if (!$DOPBSP->classes->backend_coupon->validate($coupon['id'])){
                                echo 'unavailable-coupon';
                                die();
                            }
                        }
                    }
                }
                
                /*
                 * Set token.
                 */
                $token = '';
                
                /*
                 * Add reservations.
                 */
                for ($i=0; $i<count($cart); $i++){
                    $reservation = $cart[$i];
                
                    $reservation_id = $DOPBSP->classes->backend_reservation->add($calendar_id,
                                                                                 $language,
                                                                                 $currency,
                                                                                 $currency_code,
                                                                                 $reservation,
                                                                                 $form,
                                                                                 $address_billing,
                                                                                 $address_shipping,
                                                                                 $payment_method,
                                                                                 $token,
                                                                                 $transaction_id,
                                                                                 $status);
                    /*
                     * Send notification emails to client.
                     */
                    if ($payment_method == 'default'
                            || $payment_method == 'none'){
                        if ($status == 'approved'){
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_with_approval_user');
                        }
                        else{
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_user');
                        }
                    }
                    else{
                        $DOPBSP->classes->backend_reservation_notifications->send($reservation->id,
                                                                                  $payment_method.'_user');
                    }
                }
                           
                die();
            }
        }
    }