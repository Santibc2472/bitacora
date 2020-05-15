<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : addons/woocommerce/includes/class-woocommerce-cart.php
* File Version            : 1.0.1
* Created / Last Modified : 17 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : WooCommerce cart PHP class.
*/

    if (!class_exists('DOPBSPWooCommerceOrder')){
        class DOPBSPWooCommerceOrder{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Add order item meta & save order item ID.
                 */
                add_action('woocommerce_add_order_item_meta', array(&$this, 'set'), 10, 3);
                
                /*
                 * Add reservations to booking system after payment has been completed.
                 */
                add_action('woocommerce_payment_complete', array(&$this, 'book'));
                
                /*
                 * Add reservations to booking system after some payments have been completed.
                 */
                add_action('woocommerce_thankyou', array(&$this, 'book'));
                
                /*
                 * Add reservations to booking system after some delayed payments have been completed.
                 */
                add_action('woocommerce_order_status_completed', array(&$this, 'book'));
                
                /*
                 * Add reservations to booking system after some delayed payments have been completed.
                 */
                add_action('woocommerce_order_status_processing', array(&$this, 'book'));
                
                /*
                 * Add reservations to booking system after a deposit has been made.
                 */
                add_action('woocommerce_order_status_partially-paid', array(&$this, 'book'));
                
                /*
                 * Cancel reservations from booking system if order is cancelled.
                 */
                add_action('woocommerce_order_status_cancelled', array(&$this, 'cancel'));
                
                /*
                 * Cancel reservations from booking system if order is refunded.
                 */
                add_action('woocommerce_order_status_refunded', array(&$this, 'cancel'));
            }
            
            /*
             * Set order item meta (Details, Extras, Discount) & save order item ID.
             * 
             * @param item_id (integer): order item ID
             * @param values (object): order item data (not received from WC)
             * @param cart_item_key (object): cart item key from which the order item is created (not received from WC)
             */
            function set($item_id,
                         $values,
                         $cart_item_key){            
                global $wpdb;
                global $DOPBSP;
                global $DOPBSPWooCommerce;
                
                if (isset($values['dopbsp_token'])){
                    $wpdb->update($DOPBSPWooCommerce->tables->woocommerce, array('order_item_id' => $item_id),
                                                                           array('cart_item_key' => $cart_item_key,
                                                                                 'token' => $values['dopbsp_token'],
                                                                                 'product_id' => $values['product_id']));
                    $reservations_data = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSPWooCommerce->tables->woocommerce.' WHERE cart_item_key="%s" AND token="%s" AND product_id=%d',
                                                                           $cart_item_key, $values['dopbsp_token'], $values['product_id']));
                    
                    foreach ($reservations_data as $reservation_data){
                        $reservation = json_decode($reservation_data->data);
                        $reservation->currency = $reservation_data->currency;
                        $reservation->order_item_id = $item_id;

                        $settings_calendar = $DOPBSP->classes->backend_settings->values($reservation_data->calendar_id,  
                                                                                        'calendar');

                        $DOPBSP->classes->translation->set($reservation_data->language,
                                                           false,
                                                           array('frontend',
                                                                 'calendar',
                                                                 'woocommerce_frontend'));

                        /*
                         * Display details data.
                         */
                        wc_add_order_item_meta($item_id, 
                                               $DOPBSP->text('RESERVATIONS_RESERVATION_ID').' #'.$reservation_data->id,
                                               '');

                        /*
                         * Display reservation data.
                         */
                        wc_add_order_item_meta($item_id, 
                                               $DOPBSP->text('RESERVATIONS_RESERVATION_DETAILS_TITLE'), 
                                               $this->getDetails($reservation,
                                                                 $settings_calendar));

                        /*
                         * Display extra data.
                         */
                        if ((int)$settings_calendar->extra != 0){
                            wc_add_order_item_meta($item_id,
                                                   $DOPBSP->text('EXTRAS_FRONT_END_TITLE'), 
                                                   $this->getExtras($reservation,
                                                                    $settings_calendar));
                        }

                        /*
                         * Display discount data.
                         */
                        if ((int)$settings_calendar->discount != 0){
                            wc_add_order_item_meta($item_id, 
                                                   $DOPBSP->text('DISCOUNTS_FRONT_END_TITLE'), 
                                                   $this->getDiscount($reservation,
                                                                      $settings_calendar));
                        }
                    }
                }
            }

            /*
             * Add reservations to booking system.
             * 
             * @param order_id (integer): order ID
             */
            function book($order_id){
                global $wpdb;
                global $DOPBSP;
                global $DOPBSPWooCommerce;
                
                $reservations = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE transaction_id=%d',
                                                                  $order_id));
                $DOPBSP->classes->translation->set();
                
                if (count($reservations) > 0){
                /*
                 * Approve reservations if ordered status changed. 
                 */    
                    foreach ($reservations as $reservation){
                        $DOPBSP->classes->backend_reservation->approve($reservation->id);
                    }
                }
                else{
                /*
                 * Add reservations to booking system from order.
                 */
                    $order = new WC_Order($order_id);
                    $order_items = $order->get_items();
                    
                    $billing_email = $order->get_billing_email();
                    $billing_first_name = $order->get_billing_first_name();
                    $billing_last_name = $order->get_billing_last_name();
                    $billing_phone = $order->get_billing_phone();
                    
                    foreach ($order_items as $order_item_id => $order_item){
                        $reservations_data = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSPWooCommerce->tables->woocommerce.' WHERE order_item_id=%d',
                                                                               $order_item_id));

                        foreach ($reservations_data as $reservation_data){
                            $DOPBSP->classes->backend_reservation->add($reservation_data->calendar_id,
                                                                       $reservation_data->language,
                                                                       $reservation_data->currency,
                                                                       $reservation_data->currency_code,
                                                                       json_decode($reservation_data->data, true),
                                                                       array(
                                                                            array("id" => 1, "is_email" => "false", "add_to_day_hour_info" => "false", "add_to_day_hour_body" => "false","translation" => $DOPBSP->text('FORMS_DEFAULT_FIRST_NAME'), "value" => $billing_first_name),
                                                                            array("id" => 2, "is_email" => "false", "add_to_day_hour_info" => "false", "add_to_day_hour_body" => "false","translation" => $DOPBSP->text('FORMS_DEFAULT_LAST_NAME'), "value" => $billing_last_name),
                                                                            array("id" => 3, "is_email" => "true", "add_to_day_hour_info" => "false", "add_to_day_hour_body" => "false","translation" => $DOPBSP->text('FORMS_DEFAULT_EMAIL'), "value" => $billing_email),
                                                                            array("id" => 4, "is_email" => "false", "add_to_day_hour_info" => "false", "add_to_day_hour_body" => "false","translation" => $DOPBSP->text('FORMS_DEFAULT_PHONE'), "value" => $billing_phone),
                                                                            array("id" => 5, "is_email" => "false", "add_to_day_hour_info" => "false", "add_to_day_hour_body" => "false","translation" => $DOPBSP->text('FORMS_DEFAULT_MESSAGE'), "value" => $order->get_customer_note())
                                                                       ),
                                                                       '',
                                                                       '',
                                                                       'woocommerce',
                                                                       '',
                                                                       $order_id);
                            /*
                             * Delete reservation from database.
                             */
                            $wpdb->delete($DOPBSPWooCommerce->tables->woocommerce, 
                                          array('order_item_id' => $order_item_id));
                        }
                    }
                    
                    /*
                     * Clean old reservations.
                     */
                    $DOPBSPWooCommerce->clean();
                }
            }

            /*
             * Cancel reservations from booking system.
             * 
             * @param order_id (integer): order ID
             */
            function cancel($order_id){
                global $wpdb;
                global $DOPBSP;
                
                $reservations = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE transaction_id=%d',
                                                                  $order_id));
                
                foreach ($reservations as $reservation){
                    $DOPBSP->classes->backend_reservation->cancel($reservation->id);
                }
            }
            
            /*
             * Get reservation details.
             * 
             * @param reservation (object): reservation data
             * @param settings_calendar (object): calendar settings data
             * 
             * @return details info
             */
            function getDetails($reservation,
                                $settings_calendar){
                global $DOPBSP;
                
                $info = array();
                
                array_push($info, '<table class="dopbsp-wc-cart">');
                array_push($info, '     <tbody>');
                
                /*
                 * Check in data.
                 */
                array_push($info, $this->getInfo($DOPBSP->text('SEARCH_FRONT_END_CHECK_IN'),
                                                 $DOPBSP->classes->prototypes->setDateToFormat($reservation->check_in, 
                                                                                               $settings_calendar->date_type, 
                                                                                               array($DOPBSP->text('MONTH_JANUARY'), 
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
                                                                                                     $DOPBSP->text('MONTH_DECEMBER')))));
                /*
                 * Check out data.
                 */
                if ($reservation->check_out != ''){
                    array_push($info, $this->getInfo($DOPBSP->text('SEARCH_FRONT_END_CHECK_OUT'),
                                                     $DOPBSP->classes->prototypes->setDateToFormat($reservation->check_out, 
                                                                                                   $settings_calendar->date_type, 
                                                                                                   array($DOPBSP->text('MONTH_JANUARY'), 
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
                                                                                                         $DOPBSP->text('MONTH_DECEMBER')))));
                }

                /*
                 * Start hour data.
                 */
                if ($reservation->start_hour != ''){
                    array_push($info, $this->getInfo($DOPBSP->text('SEARCH_FRONT_END_START_HOUR'),
                                                     $settings_calendar->hours_ampm == 'true' ? $DOPBSP->classes->prototypes->getAMPM($reservation->start_hour):$reservation->start_hour));
                }

                /*
                 * End hour data.
                 */
                if ($reservation->end_hour != ''){
                    array_push($info, $this->getInfo($DOPBSP->text('SEARCH_FRONT_END_END_HOUR'),
                                                     $settings_calendar->hours_ampm == 'true' ? $DOPBSP->classes->prototypes->getAMPM($reservation->end_hour):$reservation->end_hour));
                }

                /*
                 * No items data.
                 */
                if ($settings_calendar->sidebar_no_items_enabled == 'true'){
                    array_push($info, $this->getInfo($DOPBSP->text('SEARCH_FRONT_END_NO_ITEMS'),
                                                     $reservation->no_items));
                }

                /*
                 * Reservation price.
                 */
                if ($reservation->price > 0){
                    array_push($info, $this->getInfo($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_PRICE'),
                                                     $DOPBSP->classes->price->set($reservation->price,
                                                                                  $reservation->currency,
                                                                                  $settings_calendar->currency_position),
                                                     'price'));
                }
                
                /*
                 * Fees
                 */
               if ($reservation->fees_price > 0){
                    $fees = $reservation->fees;

                    for ($i=0; $i<count($fees); $i++){
                        $value = array();
                        $fee = $fees[$i];

                        if ($fee->price_type != 'fixed' 
                                || $fee->price_by != 'once'){ 
                            array_push($value, '<span class="dopbsp-info-rule">&#9632;&nbsp;');

                            if ($fee->price_type == 'fixed'){
                                array_push($value, $fee->operation.'&nbsp;'.$DOPBSP->classes->price->set($fee->price,
                                                                                                         $reservation->currency,
                                                                                                         $settings_calendar->currency_position));
                            }
                            else{
                                array_push($value, $fee->operation.'&nbsp;'.$fee->price.'%');
                            }

                            if ($fee->price_by != 'once'){
                                array_push($value, '/'.($settings_calendar->hours_enabled == 'true' ? $DOPBSP->text('FEES_FRONT_END_BY_HOUR'):$DOPBSP->text('FEES_FRONT_END_BY_DAY')));
                            }
                            array_push($value, '<br /></span>');
                        }
                        
                        if ($fee->included == 'true'){
                            array_push($value, '<span class="dopbsp-info-price">'.$DOPBSP->text('FEES_FRONT_END_INCLUDED').'</span>');
                        }
                        else{
                            array_push($value, '<span class="dopbsp-info-price">'.$fee->operation.'&nbsp;');
                            array_push($value, $DOPBSP->classes->price->set($fee->price_total,
                                                                            $reservation->currency,
                                                                            $settings_calendar->currency_position));
                            array_push($value, '</span>');
                        }

                        array_push($info, $this->getInfo($fee->translation,
                                           implode('', $value),
                                           'price'));
                    }
                }
               
                /*
                 * Reservation price total.
                 */
                if ($reservation->price_total > 0){
                    array_push($info, $this->getInfo($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_TOTAL_PRICE'),
                                                     $DOPBSP->classes->price->set($reservation->price_total,
                                                                                  $reservation->currency,
                                                                                  $settings_calendar->currency_position),
                                                     'price'));
                }

                /*
                 * Deposit
                 */
                if ($reservation->deposit_price > 0){
//                    $deposit = json_decode(stripslashes($reservation->deposit));
                    $deposit = $reservation->deposit;
                    
                    array_push($info, $this->getInfo($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT'),
                                       ($deposit->price_type = 'percent' ? '<span class="info-rule">&#9632;&nbsp;'.$deposit->price.'</span><br />':'').
                                        $DOPBSP->classes->price->set($reservation->deposit_price,
                                                                     $reservation->currency,
                                                                     $settings_calendar->currency_position),
                                       'price'));
                    array_push($info, $this->getInfo($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT_LEFT'),
                                       $DOPBSP->classes->price->set($reservation->price_total-$reservation->deposit_price,
                                                                    $reservation->currency,
                                                                    $settings_calendar->currency_position),
                                       'price'));
                }
                
                array_push($info, '     </tbody>');
                array_push($info, '</table>');
                
                return implode('', $info);
            }
            
            /*
             * Get reservation extras.
             * 
             * @param reservation (object): reservation data
             * @param settings_calendar (object): calendar settings data
             * 
             * @return extras info
             */
            function getExtras($reservation,
                               $settings_calendar){
                global $DOPBSP;
                
                $info = array();
                
                if (isset($reservation->extras)
                        && $reservation->extras != ''){
                    $extras = is_string($reservation->extras) ? json_decode($reservation->extras):$reservation->extras;
                
                    for ($i=0; $i<count($extras); $i++){
                        $extras[$i]->displayed = false;
                    }
                    
                    array_push($info, '<table class="dopbsp-wc-cart">');
                    array_push($info, '     <tbody>');

                    for ($i=0; $i<count($extras); $i++){
                        $values = array();

                        if ($extras[$i]->displayed == false){
                            for ($j=0; $j<count($extras); $j++){
                                $value = array();
                                $extra = $extras[$j];

                                if ($extras[$i]->group_id == $extra->group_id){
                                    array_push($value, $extra->translation);

                                    if ($extra->price != 0){
                                        array_push($value, '<br />');


                                        if ($extra->price_type != 'fixed' 
                                                || $extra->price_by != 'once'){ 
                                            array_push($value, '&#9632;&nbsp;');

                                            if ($extra->price_type == 'fixed'){
                                                array_push($value, $extra->operation.'&nbsp;'.$DOPBSP->classes->price->set($extra->price,
                                                                                                                           $reservation->currency,
                                                                                                                           $settings_calendar->currency_position));
                                            }
                                            else{
                                                array_push($value, $extra->operation.'&nbsp;'.$extra->price.'%');
                                            }

                                            if ($extra->price_by != 'once'){
                                                array_push($value, '/'.($settings_calendar->hours_enabled == 'true' ? $DOPBSP->text('EXTRAS_FRONT_END_BY_HOUR'):$DOPBSP->text('EXTRAS_FRONT_END_BY_DAY')));
                                            }
                                            array_push($value, '<br />');
                                        }
                                        array_push($value, '<strong>'.$extra->operation.'&nbsp;');
                                        array_push($value, $DOPBSP->classes->price->set($extra->price_total,
                                                                                        $reservation->currency,
                                                                                        $settings_calendar->currency_position));
                                        array_push($value, '</strong>');
                                    }

                                    if (count($value) != 0){
                                        $extras[$j]->displayed = true;
                                        array_push($values, implode('', $value));
                                    }
                                }
                            }    
                            array_push($info, $this->getInfo($extras[$i]->group_translation,
                                                             implode('<br /><br />', $values)));
                        }
                    }
                    
                    if ($reservation->extras_price != 0){
                        array_push($info, '<br />');
                        array_push($info, $this->getInfo($DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PRICE_CHANGE'),
                                                         ($reservation->extras_price > 0 ? '+':'-').
                                                             '&nbsp;'.
                                                             $DOPBSP->classes->price->set($reservation->extras_price,
                                                                                          $reservation->currency,
                                                                                          $settings_calendar->currency_position),
                                                         'price'));
                    }
                    array_push($info, '     </tbody>');
                    array_push($info, '</table>');
                }
                else{
                    array_push($info, '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_NO_EXTRAS').'</em>');
                }
                
                return implode('', $info);
            }
            
            /*
             * Get reservation discount.
             * 
             * @param reservation (object): reservation data
             * @param settings_calendar (object): calendar settings data
             * 
             * @return discount info
             */
            function getDiscount($reservation,
                                 $settings_calendar){
                global $DOPBSP;
                
                $info = array();
                
                $discount = is_string($reservation->discount) ? json_decode($reservation->discount):$reservation->discount;
                
                if ($discount->id != 0){
                    $value = array();
                
                    array_push($info, '<table class="dopbsp-wc-cart">');
                    array_push($info, '     <tbody>');

                    array_push($value, '&#9632;&nbsp;');

                    if ($discount->price_type == 'fixed'){
                        array_push($value, $discount->operation.'&nbsp;'.$DOPBSP->classes->price->set($discount->price,
                                                                                                      $reservation->currency,
                                                                                                      $settings_calendar->currency_position));
                    }
                    else{
                        array_push($value, $discount->operation.'&nbsp;'.$discount->price.'%');
                    }

                    if ($discount->price_by != 'once'){
                        array_push($value, '/'.($settings_calendar->hours_enabled == 'true' ? $DOPBSP->text('DISCOUNTS_FRONT_END_BY_HOUR'):$DOPBSP->text('DISCOUNTS_FRONT_END_BY_DAY')));
                    }

                    array_push($info, $this->getInfo($discount->translation,
                                                     implode('', $value)));

                    if ($reservation->discount_price != 0){
                        array_push($info, '<br />');
                        array_push($info, $this->getInfo($DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PRICE_CHANGE'),
                                                         ($reservation->discount_price > 0 ? '+':'-').
                                                             '&nbsp;'.
                                                             $DOPBSP->classes->price->set($reservation->discount_price,
                                                                                          $reservation->currency,
                                                                                          $settings_calendar->currency_position),
                                                         'price'));
                    }
                    array_push($info, '     </tbody>');
                    array_push($info, '</table>');
                }
                else{
                    array_push($info, '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_NO_DISCOUNT').'</em>');
                }
                
                return implode('', $info);
            }
            
            /*
             * Get info field.
             * 
             * @param label (string):  data label
             * @param value (string):  data value
             * @param value_type (string):  data value type
             * 
             * @return info field
             */
            function getInfo($label = '',
                             $value = '',
                             $type = ''){
                $info = array();
                
                // $label = stripslashes(utf8_decode($label));
                // $value = stripslashes(utf8_decode($value));
                $label = stripslashes($label);
                $value = stripslashes($value);
                
                switch ($type){
                    case 'no-data':
                        $label = '<strong style="color: #898989;">'.$label.'</strong>';
                        $value = '<em style="color: #acacac;">'.$value.'</em>';
                        break;
                    case 'price':
                        $label = '<strong style="color: #252525;">'.$label.'</strong>';
                        $value = '<strong style="color: #252525;">'.$value.'</strong>';
                        break;
                    case 'price-total':
                        $label = '<strong style="color: #252525;">'.$label.'</strong>';
                        $value = '<strong style="color: #ff6300;">'.$value.'</strong>';
                        break;
                    default:
                        $label = '<strong style="color: #898989;">'.$label.'</strong>';
                        $value = '<span style="color: #666666;">'.$value.'</em>';
                }   
                
                array_push($info, '<tr>');
                array_push($info, '     <td style="vertical-align: top; width: 150px;">'.$label.'</td>');
                array_push($info, '     <td style="vertical-align: top;">'.$value.'</td>');
                array_push($info, '</tr>');
                
                return implode('', $info);
            }
        }
    }