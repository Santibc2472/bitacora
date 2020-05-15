<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin (PRO)
* Version                 : 2.2.3
* File                    : includes/reservations/class-backend-reservation.php
* File Version            : 1.1.0
* Created / Last Modified : 21 April 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservations PHP class.
*/

    if (!class_exists('DOPBSPBackEndReservation')){
        class DOPBSPBackEndReservation extends DOPBSPBackEndReservations{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add reservation.
             * 
             * @param calendar_id (integer): calendar ID
             * @param language (string): selected language
             * @param currency (string): currency sign
             * @param currency_code (string): currency code
             * @param reservation (array): reservation details
             * @param form (object): form details
             * @param address_billing (object): billing address details
             * @param address_shipping (object): shipping address details
             * @param payment_method (string): payment method
             * @param token (string): payment token
             * @param transaction_id (string): transaction ID
             * @param status (string): reservation status
             * 
             * @return reservation ID
             */
            function add($calendar_id,
                         $language,
                         $currency,
                         $currency_code,
                         $reservation,
                         $form,
                         $address_billing,
                         $address_shipping,
                         $payment_method,
                         $token,
                         $transaction_id = '',
                         $status = '',
                         $source = 'pinpoint'){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $settings_payment = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                               'payment');
                
                $days_history = isset($reservation['days_hours_history']) ? $reservation['days_hours_history']:array();
                
                if($source != 'pinpoint') {
                    $settings_payment->arrival_with_approval_enabled = 'true';
                    
                    if($reservation['start_hour'] == '') {
                        $days_history = $DOPBSP->classes->backend_calendar_schedule->daysHistory($reservation['check_in'], 
                                                                                                 $reservation['check_out'],
                                                                                                 $calendar_id);
                    } else {
                        $days_history = $DOPBSP->classes->backend_calendar_schedule->daysHoursHistory($reservation['check_in'], 
                                                                                                $reservation['start_hour'],
                                                                                                $reservation['end_hour'],
                                                                                                $calendar_id);
                   
                    }
                }
                
                if(!empty($days_history)) {
                    /*
                     * Set status
                     */
                    $status = $status != '' ? $status:
                                              ((($payment_method == 'none' || $payment_method == 'default') && $settings_payment->arrival_with_approval_enabled == 'false') || ($payment_method != 'none' && $payment_method != 'default' && $payment_method != 'woocommerce') ? 'pending':'approved');
		
                    $wpdb->insert($DOPBSP->tables->reservations, array('calendar_id' => $calendar_id,
                                                                       'language' => $language,
                                                                       'currency' => $currency,
                                                                       'currency_code' => $currency_code,
                                                                       'check_in' => $reservation['check_in'],
                                                                       'check_out' => isset($reservation['check_out']) ? $reservation['check_out']:'',
                                                                       'start_hour' => isset($reservation['start_hour']) ? $reservation['start_hour']:'',
                                                                       'end_hour' => isset($reservation['end_hour']) ? $reservation['end_hour']:'',
                                                                       'no_items' => $reservation['no_items'],
                                                                       'price' => $reservation['price'],
                                                                       'price_total' => $reservation['price_total'],
                                                                       'extras' => isset($reservation['extras']) ? json_encode($reservation['extras']):'',
                                                                       'extras_price' => $reservation['extras_price'],
                                                                       'discount' => isset($reservation['discount']) ? json_encode($reservation['discount']):'',
                                                                       'discount_price' => $reservation['discount_price'],
                                                                       'coupon' => isset($reservation['coupon']) ? json_encode($reservation['coupon']):'',
                                                                       'coupon_price' => $reservation['coupon_price'],
                                                                       'fees' => isset($reservation['fees']) && $reservation['fees'] != '' ? json_encode($reservation['fees']):'',
                                                                       'fees_price' => $reservation['fees_price'],
                                                                       'deposit' => isset($reservation['deposit']) ? json_encode($reservation['deposit']):'',
                                                                       'deposit_price' => $reservation['deposit_price'],
                                                                       'days_hours_history' => json_encode($days_history),
                                                                       'form' => isset($form) && $form != '' ? json_encode($form):'',
                                                                       'address_billing' => isset($address_billing) && $address_billing != '' ? json_encode($address_billing):'',
                                                                       'address_shipping' => isset($address_shipping) && $address_shipping != '' ? ($address_shipping == 'billing_address' ? $address_shipping:json_encode($address_shipping)):'',
                                                                       'email' => isset($form) && $form != '' ? $this->getEmail($form):'',
                                                                       'phone' => isset($form) && $form != '' ? $this->getPhone($form):'',
                                                                       'status' => $status,
                                                                       'payment_method' => $payment_method,
                                                                       'token' => $token,
                                                                       'ip' => '', //isset($reservation['ip']) ? $reservation['ip']:'',
                                                                       'transaction_id' => $transaction_id != '' ? $transaction_id:'',
                                                                       'reservation_from' => $source,
                                                                       'uid' => isset($reservation['uid']) ? $reservation['uid']: ''));
                    $reservation_id = $wpdb->insert_id;
                    $reservation['uid'] = isset($reservation['uid']) ? $reservation['uid'] : $reservation_id.'@'.str_ireplace(array('http://', 'https://'), '', home_url());
                    if($source == 'pinpoint'){
                    $wpdb->update($DOPBSP->tables->reservations, array('uid' => $reservation['uid']),
                                                                 array('id' => $reservation_id));
                    }
                    
                    $settings_calendar = $DOPBSP->classes->backend_settings->values($calendar_id,  
                                                                                    'calendar');
                    $days = array();
                    $query_insert_values = array();

                    // Default Availability
                    $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                                 $calendar_id));
                    $days_data = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->days.' WHERE unique_key in ('.('"'.$calendar_id.'_'.implode('","'.$calendar_id.'_', $days).'"').') ORDER BY day');

                    $default_availability = json_decode($calendar->default_availability);
                    
                    $default_availability = $calendar->default_availability != '' ? $calendar->default_availability:'{"available": 1,
                                                                                                                       "bind": 0,
                                                                                                                       "price": 0,
                                                                                                                       "promo": 0,
                                                                                                                       "info":  "",
                                                                                                                       "info_body": "",
                                                                                                                       "info_info": "",
                                                                                                                       "notes": "",
                                                                                                                       "hours":{},
                                                                                                                       "hours_definitions":[{"value":"00:00"}],
                                                                                                                       "status": "available"}';

                    $default_availability = json_decode($default_availability);

                    $check_in = strtotime( $reservation['check_in'].' 12:00' );
                    $check_out = strtotime( $reservation['check_out'].' 12:00' );
                    
                    if ($settings_calendar->days_morning_check_out == 'true'){
                        $check_out_new = date('Y-m-d', strtotime($reservation['check_out']));
                        // check_out - 1 day
                        $check_out_time = new DateTime($check_out_new.' 00:00:00');
                        $check_out_time->modify('-1 day');
                        $check_out_new = $check_out_time->format('Y-m-d');
                        $reservation['check_out'] = $check_out_new;
                        $check_out = strtotime( $reservation['check_out'].' 12:00' );
                    }

                    if($reservation['check_out'] != '') {
                        
                        // Loop between timestamps, 24 hours at a time
                        for ( $i = $check_in; $i <= $check_out; $i = $i + 86400 ) {
                            $day = date( 'Y-m-d', $i );
                            $year = date( 'Y', $i );
                            $price_min  = 1000000000;
                            $price_max  = 0;

                            if ($settings_calendar->hours_enabled == 'true'){
                                    foreach ($default_availability->hours as $hour):
                                        $price = $hour->promo == '' ? ($hour->price == '' ? 0:(float)$hour->price):(float)$hour->promo;

                                        if ($hour->price != '0'){
                                            $price_min = $price < $price_min ? $price:$price_min;
                                            $price_max = $price > $price_max ? $price:$price_max;
                                        }
                                    endforeach;
                            }
                            else{
                                $price_min = 0;

                                if($default_availability != '') {
                                    $price_min = $default_availability->promo == '' ? ($default_availability->price == '' ? 0:(float)$default_availability->price):(float)$default_availability->promo;
                                }
                                $price_max = $price_min;
                            }

//                            if ($wpdb->num_rows != 0){
//                                $price_min  = 1000000000;
//                                $price_max  = 0;
//                                $data_new = '';
//                                $day_data = json_decode($control_data->data);
//
//                                if ($settings_calendar->hours_enabled == 'true'){
//
//                                    foreach ($day_data->hours as $key_hour => $hour):
//                                        $day_data->hours = (array)$day_data->hours;
//                                        $price = $day_data->hours[$key_hour]->promo == '' ? ($day_data->hours[$key_hour]->price == '' ? 0:(float)$day_data->hours[$key_hour]->price):(float)$day_data->hours[$key_hour]->promo;
//
//                                        if ($day_data->hours[$key_hour]->price != '0'){
//                                            $price_min = $price < $price_min ? $price:$price_min;
//                                            $price_max = $price > $price_max ? $price:$price_max;
//                                        }
//                                    endforeach;
//                                } else {
//                                    $price_min = $day_data->promo == '' ? ($day_data->price == '' ? 0:(float)$day_data->price):(float)$day_data->promo;
//                                    $price_max = $price_min;
//                                }
//
//                                $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($day_data),
//                                                                           'price_min' => $price_min,
//                                                                           'price_max' => $price_max), 
//                                                                     array('calendar_id' => $calendar_id,
//                                                                           'day' => $day));
//                            } else{
                                
                                if (!array_key_exists($day, $days_data)) {
                                    array_push($days, $day);
                                    $price_min  = 1000000000;
                                    $price_max  = 0;
                                    $data_new = '';
                                    $day_data = $default_availability;

                                    if ($settings_calendar->hours_enabled == 'true'){

                                        foreach ($day_data->hours as $key_hour => $hour):
                                            $day_data->hours = (array)$day_data->hours;
                                            $price = $day_data->hours[$key_hour]->promo == '' ? ($day_data->hours[$key_hour]->price == '' ? 0:(float)$day_data->hours[$key_hour]->price):(float)$day_data->hours[$key_hour]->promo;

                                            if ($day_data->hours[$key_hour]->price != '0'){
                                                $price_min = $price < $price_min ? $price:$price_min;
                                                $price_max = $price > $price_max ? $price:$price_max;
                                            }
                                        endforeach;
                                    } else {
                                        $price_min = 0;

                                        if($default_availability != '') {
                                            $price_min = $day_data->promo == '' ? ($day_data->price == '' ? 0:(float)$day_data->price):(float)$day_data->promo;
                                        }
                                        $price_max = $price_min;
                                    }

                                    $control_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                                          $calendar_id, $day));
                                    if ($wpdb->num_rows == 0){
                                        array_push($query_insert_values, '(\''.$calendar_id.'_'.$day.'\', \''.$calendar_id.'\', \''.$day.'\', \''.$year.'\', \''.json_encode($day_data).'\', \''.$price_min.'\', \''.$price_max.'\')');
                                    }
                                }
                            }
//                        }
                    } else {
                        $day = date( 'Y-m-d', $check_in );
                        $year = date( 'Y', $check_in );
                        $price_min  = 1000000000;
                        $price_max  = 0;

                        $control_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                                          $calendar_id, $day));

                        if ($settings_calendar->hours_enabled == 'true'){
                                $availability_data = $default_availability;

                                foreach ($availability_data->hours as $hour):
                                    $price = $hour->promo == '' ? ($hour->price == '' ? 0:(float)$hour->price):(float)$hour->promo;

                                    if ($hour->price != '0'){
                                        $price_min = $price < $price_min ? $price:$price_min;
                                        $price_max = $price > $price_max ? $price:$price_max;
                                    }
                                endforeach;
                        }
                        else{
                            $price_min = $availability_data->promo == '' ? ($availability_data->price == '' ? 0:(float)$availability_data->price):(float)$availability_data->promo;
                            $price_max = $price_min;
                        }

                        if ($wpdb->num_rows != 0){
                                $price_min  = 1000000000;
                                $price_max  = 0;
                                $data_new = '';
                                $day_data = json_decode($control_data->data);

                                if ($settings_calendar->hours_enabled == 'true'){

                                    foreach ($day_data->hours as $key_hour => $hour):
                                        $day_data->hours = (array)$day_data->hours;
                                        $price = $day_data->hours[$key_hour]->promo == '' ? ($day_data->hours[$key_hour]->price == '' ? 0:(float)$day_data->hours[$key_hour]->price):(float)$day_data->hours[$key_hour]->promo;

                                        if ($day_data->hours[$key_hour]->price != '0'){
                                            $price_min = $price < $price_min ? $price:$price_min;
                                            $price_max = $price > $price_max ? $price:$price_max;
                                        }
                                    endforeach;
                                } else {
                                    $price_min = $day_data->promo == '' ? ($day_data->price == '' ? 0:(float)$day_data->price):(float)$day_data->promo;
                                    $price_max = $price_min;
                                }

                                $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($day_data),
                                                                           'price_min' => $price_min,
                                                                           'price_max' => $price_max), 
                                                                     array('calendar_id' => $calendar_id,
                                                                           'day' => $day));
                        }
                        else{
                            if (!array_key_exists($day, $days_data)) {
                                array_push($days, $day);
                                $price_min  = 1000000000;
                                $price_max  = 0;
                                $data_new = '';
                                $day_data = $default_availability;

                                if ($settings_calendar->hours_enabled == 'true'){

                                    foreach ($day_data->hours as $key_hour => $hour):
                                        $day_data->hours = (array)$day_data->hours;
                                        $price = $day_data->hours[$key_hour]->promo == '' ? ($day_data->hours[$key_hour]->price == '' ? 0:(float)$day_data->hours[$key_hour]->price):(float)$day_data->hours[$key_hour]->promo;

                                        if ($day_data->hours[$key_hour]->price != '0'){
                                            $price_min = $price < $price_min ? $price:$price_min;
                                            $price_max = $price > $price_max ? $price:$price_max;
                                        }
                                    endforeach;
                                } else {
                                    $price_min = $day_data->promo == '' ? ($day_data->price == '' ? 0:(float)$day_data->price):(float)$day_data->promo;
                                    $price_max = $price_min;
                                }

                                $control_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND day="%s"',
                                                                          $calendar_id, $day));
                                if ($wpdb->num_rows == 0){
                                    array_push($query_insert_values, '(\''.$calendar_id.'_'.$day.'\', \''.$calendar_id.'\', \''.$day.'\', \''.$year.'\', \''.json_encode($day_data).'\', \''.$price_min.'\', \''.$price_max.'\')');
                                }
                            }
                        }
                    }

                    if (count($query_insert_values) > 0){
                        $wpdb->query('INSERT INTO '.$DOPBSP->tables->days.' (unique_key, calendar_id, day, year, data, price_min, price_max) VALUES '.implode(', ', $query_insert_values));
                    }

                    $DOPBSP->classes->backend_calendar_schedule->clean();
		    
		    $DOT->models->availability->set($calendar_id);

                    /*
                     * Update schedule.
                     */
                    if ($status == 'approved'
                            || ($status == '' 
                                    && ($settings_payment->arrival_with_approval_enabled == 'true'
                                            || ($payment_method != 'none'
                                                    && $payment_method != 'default')))){
                        $DOPBSP->classes->backend_calendar_schedule->setApproved($reservation_id);

                        /*
                         * Update coupons.
                         */
                        if(isset($reservation['coupon'])) {
                            $coupon = $reservation['coupon'];

                            if ($coupon['id'] != 0){
                                $DOPBSP->classes->backend_coupon->update($coupon['id'],
                                                                         'use');
                            }
                        }
                    }
                    return $reservation_id;
                }
            }
            
            /*
             * Approve reservation.
             * 
             * @param reservation_id (integer): reservation ID
             * @post reservation_id (integer): reservation ID
             */
            function approve($reservation_id = 0){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $reservation_id = $DOT->post('reservation_id', 'int') ? $DOT->post('reservation_id', 'int'):$reservation_id;
                
                $reservation = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE id=%d',
                                                             $reservation_id));
                
                /*
                 * Stop approval if status is already approved.
                 */
                if ($reservation->status == 'approved'){
                    if ($DOT->post('reservation_id', 'int') != 0){
                        die();
                    }
                    else{
                        return '';
                    }
                }
                
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                          $reservation->calendar_id));
                
                if($calendar->default_availability != '') {
                    $default_availability = json_decode($calendar->default_availability);
                }
                
                /*
                 * Verify reservations availability.
                 */
                if ($reservation->start_hour == ''){
                    if (!$DOPBSP->classes->backend_calendar_schedule->validateDays($reservation->calendar_id, $reservation->check_in, $reservation->check_out, $reservation->no_items)){
                        echo 'unavailable';
                        die();
                    }
                }
                else{
                    if (!$DOPBSP->classes->backend_calendar_schedule->validateHours($reservation->calendar_id, $reservation->check_in, $reservation->start_hour, $reservation->end_hour, $reservation->no_items)){
                        echo 'unavailable';
                        die();
                    }
                }
                
                /*
                 * Verify coupon.
                 */
                $coupon = json_decode($reservation->coupon);

                if ($coupon->id != 0){
                    if (!$DOPBSP->classes->backend_coupon->validate($coupon->id)){
                        echo 'unavailable-coupon';
                        die();
                    }
                    else{
                        /*
                         * If coupon is valid update.
                         */
                        $DOPBSP->classes->backend_coupon->update($coupon->id,
                                                                 'use');
                    }
                }
                
                /*
                 * Update if period is available.
                 */
                $wpdb->update($DOPBSP->tables->reservations, array('status' => 'approved'), 
                                                             array('id' => $reservation_id));
                
                $DOPBSP->classes->backend_calendar_schedule->setApproved($reservation_id);
                
                $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                          'approved');

                $DOT->post('reservation_id', 'int') != 0 ? die():'';
            }
            
            /*
             * Cancel reservation.
             * 
             * @param reservation_id (integer): reservation ID
             * @post reservation_id (integer): reservation ID
             */
            function cancel($reservation_id = 0){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $reservation_id = $DOT->post('reservation_id', 'int') != 0 ? $DOT->post('reservation_id', 'int'):$reservation_id;
                
                $reservation = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE id=%d',
                                                             $reservation_id));
                
                /*
                 * Stop cancellation if status is already canceled.
                 */
                if ($reservation->status == 'canceled'){
                    if ($DOT->post('reservation_id', 'int') != 0){
                        die();
                    }
                    else{
                        return '';
                    }
                }

                /*
                 * Begin reservation cancellation.
                 */
                $wpdb->update($DOPBSP->tables->reservations, array('status' => 'canceled'), 
                                                             array('id' => $reservation_id));
                
                if($reservation->coupon != '') {
                    $coupon = json_decode($reservation->coupon);

                    if ($coupon->id != 0){
                        $DOPBSP->classes->backend_coupon->update($coupon->id,
                                                                 'restore');
                    }
                }

                $DOPBSP->classes->backend_calendar_schedule->setCanceled($reservation_id);
                    
                $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                          'canceled');
             
/*
 * HOOK (dopbsp_action_cancel_payment) *************************************** Add action for payment gateways refunds. 
 * @param reservation (object): reservation data                
 */
                do_action('dopbsp_action_cancel_payment', $reservation);
                
                $DOT->post('reservation_id', 'int') != 0 ? die():'';
            }
            
            /*
             * Delete reservation.
             * 
             * @param reservation_id (integer): reservation ID
             * @post reservation_id (integer): reservation ID
             */
            function delete($reservation_id = 0){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $reservation_id = $DOT->post('reservation_id', 'int') != 0 ? $DOT->post('reservation_id', 'int'):$reservation_id;
                
                $wpdb->delete($DOPBSP->tables->reservations, array('id' => $reservation_id));
                
                die();
            }
            
            /*
             * Reject reservation.
             * 
             * @param reservation_id (integer): reservation ID
             * @post reservation_id (integer): reservation ID
             */
            function reject($reservation_id = 0){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $reservation_id = $DOT->post('reservation_id', 'int') != 0 ? $DOT->post('reservation_id', 'int'):$reservation_id;
                
                $reservation = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE id=%d',
                                                             $reservation_id));
                
                /*
                 * Stop rejection if status is already rejected.
                 */
                if ($reservation->status == 'rejected'){
                    if ($DOT->post('reservation_id', 'int') != 0){
                        die();
                    }
                    else{
                        return '';
                    }
                }
                
                /*
                 * Begin reservation rejection.
                 */
                $wpdb->update($DOPBSP->tables->reservations, array('status' => 'rejected'), 
                                                             array('id' => $reservation_id));
                
                $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                          'rejected');
                
                die();
            }
            
            /*
             * Get user email for the reservation.
             * 
             * @param form (array): booking form data
             * 
             * @return user email
             */
            function getEmail($form){
                $email = '';
                
                if (isset($form)
                        && $form != ''){
                    foreach ($form as $field){
                        if (array_key_exists('is_email', $field)
                            && $field['is_email'] == 'true'){
                            $email = $field['value'];
                            break;
                        }
                    }
                }
                
                return $email;
            }
            
            /*
             * Get user phone for the reservation.
             * 
             * @param form (array): booking form data
             * 
             * @return user phone
             */
            function getPhone($form){
                $phone = '';
                
                if (isset($form)
                        && $form != ''){
                    foreach ($form as $field){
                        if (array_key_exists('is_phone', $field)
                            && $field['is_phone'] == 'true'){
                            $phone = $field['value'];
                            break;
                        }
                    }
                }
                
                return $phone;
            }
        }
    }