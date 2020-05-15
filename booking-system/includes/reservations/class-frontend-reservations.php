<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : includes/reservations/class-reservations-extras.php
* File Version            : 1.1.1
* Created / Last Modified : 04 December 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end reservations PHP class.
*/

    if (!class_exists('DOPBSPFrontEndReservations')){
        class DOPBSPFrontEndReservations extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function __construct(){
            }
            
            /*
             * Get reservation data.
             */
            function get(){
                global $DOPBSP;
                    
                return array('data' => array(),
                             'text' => array('addressShippingCopy' => $DOPBSP->text('RESERVATIONS_RESERVATION_ADDRESS_SHIPPING_COPY'),
                                             'buttonApprove' => $DOPBSP->text('RESERVATIONS_RESERVATION_APPROVE'),
                                             'buttonCancel' => $DOPBSP->text('RESERVATIONS_RESERVATION_CANCEL'),
                                             'buttonClose' => $DOPBSP->text('RESERVATIONS_RESERVATION_CLOSE'),
                                             'buttonDelete' => $DOPBSP->text('RESERVATIONS_RESERVATION_DELETE'),
                                             'buttonReject' => $DOPBSP->text('RESERVATIONS_RESERVATION_REJECT'),
                                             'dateCreated' => $DOPBSP->text('RESERVATIONS_RESERVATION_DATE_CREATED'),
                                             'id' => $DOPBSP->text('RESERVATIONS_RESERVATION_ID'),
                                             'instructions' => $DOPBSP->text('RESERVATIONS_RESERVATION_INSTRUCTIONS'),
                                             'language' => $DOPBSP->text('RESERVATIONS_RESERVATION_LANGUAGE'),   
                                             'noAddressBilling' => $DOPBSP->text('RESERVATIONS_RESERVATION_NO_ADDRESS_BILLING'),   
                                             'noAddressShipping' => $DOPBSP->text('RESERVATIONS_RESERVATION_NO_ADDRESS_SHIPPING'),   
                                             'noExtras' => $DOPBSP->text('RESERVATIONS_RESERVATION_NO_EXTRAS'),   
                                             'noDiscount' => $DOPBSP->text('RESERVATIONS_RESERVATION_NO_DISCOUNT'),
                                             'noCoupon' => $DOPBSP->text('RESERVATIONS_RESERVATION_NO_COUPON'),
                                             'noFees' => $DOPBSP->text('RESERVATIONS_RESERVATION_NO_FEES'),
                                             'noForm' => $DOPBSP->text('RESERVATIONS_RESERVATION_NO_FORM'),
                                             'noFormField' => $DOPBSP->text('RESERVATIONS_RESERVATION_NO_FORM_FIELD'),
                                             'price' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_PRICE'),
                                             'priceChange' => $DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PRICE_CHANGE'),
                                             'priceTotal' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_TOTAL_PRICE'),   
                                             'selectDays' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_SELECT_DAYS'),
                                             'selectHours' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_SELECT_HOURS'),
                                             'status' => $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS'),
                                             'statusApproved' => $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_APPROVED'),
                                             'statusCanceled' => $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_CANCELED'),
                                             'statusExpired' => $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_EXPIRED'),
                                             'statusPending' => $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_PENDING'),
                                             'statusRejected' => $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_REJECTED'),
                                             'title' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_TITLE'),
                                             'titleDetails' => $DOPBSP->text('RESERVATIONS_RESERVATION_DETAILS_TITLE')));
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
             * @post address_billing_data (object): billing address data
             * @post address_shipping_data (object): shipping address data
             * @post payment_method (string): selected payment method
             * @post form_addon_data (object): form addon data
             * @post card_data (object): card data
             * @post token (string): payment token (different for payment gateways)
             * @post page_url (string): page url were the calendar is
             */
            function book(){
		global $DOT;
                global $DOPBSP;
                    
// HOOK (dopbsp_action_book_before) *************************************** Add action before booking request.
                do_action('dopbsp_action_book_before');

                $calendar_id = $DOT->post('calendar_id', 'int');
                $language = $DOT->post('language');
                $currency = $DOT->post('currency');
                $currency_code = $DOT->post('currency_code');
                $cart = $DOT->post('cart_data');
                $form = $DOT->post('form');
                $address_billing = $DOT->post('address_billing_data');
                $address_shipping = $DOT->post('address_shipping_data');
                $payment_method = $DOT->post('payment_method');
                $token = $DOT->post('token');
                $ip = $_SERVER['REMOTE_ADDR'];
                    
                // Sync with iCal
                $DOPBSP->classes->backend_calendar_schedule->sync($calendar_id, true);
                
                /*
                 * Verify reservations.
                 */
                $settings_payment = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                               'payment');
                
                for ($i=0; $i<count($cart); $i++){
                    $reservation = $cart[$i];
                    $reservation['ip'] = $ip;
                    
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
                        // $coupon = json_decode($reservation['coupon']);
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
                if ($payment_method != 'default'
                        && $payment_method != 'none'){
                    $token = $token == '' ? $DOPBSP->classes->prototypes->getRandomString(32):$token;
                }
                else{
                    $token = '';
                }
                $DOPBSP->vars->payment_token = $token;
                
                /*
                 * Add reservations.
                 */
                for ($i=0; $i<count($cart); $i++){
                    $reservation = $cart[$i];
                    $reservation['ip'] = $ip;
                
                    $reservation_id = $DOPBSP->classes->backend_reservation->add($calendar_id,
                                                                                 $language,
                                                                                 $currency,
                                                                                 $currency_code,
                                                                                 $reservation,
                                                                                 $form,
                                                                                 $address_billing,
                                                                                 $address_shipping,
                                                                                 $payment_method,
                                                                                 $token);
                    
                    if ($payment_method == 'default'
                            || $payment_method == 'none'){
                        if ($settings_payment->arrival_with_approval_enabled == 'true'){
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_with_approval_admin');
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_with_approval_user');
                        }
                        else{
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_admin');
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_user');
                        }
                    }
                }
                
// HOOK (dopbsp_action_book_payment) *************************************** Add action for payment gateways.
                do_action('dopbsp_action_book_payment');
                
// HOOK (dopbsp_action_book_after) *************************************** Add action after booking request.
                do_action('dopbsp_action_book_after');
                           
                die();
            }
            
            /*
             * Sync a reservation.
             * 
             * @post calendar_id (integer): calendar ID
             * @post language (string): selected language
             * @post currency (string): selected currency sign
             * @post currency_code (string): selected currency code
             * @post cart_data (array): list of reservations
             * @post form (object): form data
             * @post address_billing_data (object): billing address data
             * @post address_shipping_data (object): shipping address data
             * @post payment_method (string): selected payment method
             * @post form_addon_data (object): form addon data
             * @post card_data (object): card data
             * @post token (string): payment token (different for payment gateways)
             */
            function sync($calendar_id,
                          $language,
                          $currency,
                          $currency_code,
                          $cart,
                          $form,
                          $address_billing,
                          $address_shipping,
                          $payment_method,
                          $token,
                          $source = 'pinpoint'){
                global $DOPBSP;
                global $wpdb;
                
                $ip = $_SERVER['REMOTE_ADDR'];
                
                /*
                 * Verify reservations.
                 */
                $settings_payment = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                               'payment');
                
                /*
                 * Set token.
                 */
                if ($payment_method != 'default'
                        && $payment_method != 'none'){
                    $token = $token == '' ? $DOPBSP->classes->prototypes->getRandomString(32):$token;
                }
                else{
                    $token = '';
                }
                $DOPBSP->vars->payment_token = $token;
                
                /*
                 * Add reservations.
                 */
                for ($i=0; $i<count($cart); $i++){
                    $reservation = $cart[$i];
                    $reservation['ip'] = $ip; 
                    
                    // check reservation
                    if($source != 'airbnb') {
                        $control_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE uid="%s" AND calendar_id=%d AND (status="approved" OR status="expired")',
                                       $reservation['uid'], $calendar_id));
                    } else{
                        $control_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE check_in="%s" AND check_out="%s" AND start_hour="%s" AND end_hour="%s" AND calendar_id=%d AND (status="approved" OR status="expired")',
                                       $reservation['check_in'], $reservation['check_out'], $reservation['start_hour'], $reservation['end_hour'], $calendar_id));
                    }
                    
                    if($wpdb->num_rows < 1) {
                        $DOPBSP->classes->backend_reservation->add($calendar_id,
                                                                   $language,
                                                                   $currency,
                                                                   $currency_code,
                                                                   $reservation,
                                                                   $form,
                                                                   $address_billing,
                                                                   $address_shipping,
                                                                   $payment_method,
                                                                   $token,
                                                                   '',
                                                                   'approved',
                                                                   $source);
                    }
                }
            }
        }
    }