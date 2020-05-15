<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : views/reservations/views-backend-reservation-details.php
* File Version            : 1.0.6
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservation details views class.
*/

    if (!class_exists('DOPBSPViewsBackEndReservationDetails')){
        class DOPBSPViewsBackEndReservationDetails extends DOPBSPViewsBackEndReservation{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * @param args (array): function arguments
             *                      * reservation (object): reservation data
             *                      * calendar (object): calendar data
             *                      * settings_calendar (object): calendar settings data
             */
            function template($args = array()){
                global $DOPBSP;
                
                $reservation = $args['reservation'];
                $calendar = $args['calendar'];
                $settings_calendar = $args['settings_calendar'];
?>
                <div class="dopbsp-data-module">
                    <div class="dopbsp-data-head"> 
                        <h3><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_DETAILS_TITLE'); ?></h3>
                    </div>
                    <div class="dopbsp-data-body"> 
<?php
                /*
                 * Calendar ID.
                 */
                $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_CALENDAR_ID'),
                                   $reservation->calendar_id);
                
                /*
                 * Calendar name.
                 */
                $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_CALENDAR_NAME'),
                                   $calendar->name);
                
                /*
                 * Selected language.
                 */
                $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_LANGUAGE'),
                                   $DOPBSP->classes->languages->get($reservation->language));
?>
                        <br />
<?php
                /*
                 * Check in data.
                 */
                $this->displayData($DOPBSP->text('SEARCH_FRONT_END_CHECK_IN'),
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
                                                                                       $DOPBSP->text('MONTH_DECEMBER'))));
                /*
                 * Check out data.
                 */
                if ($reservation->check_out != ''){
                    $this->displayData($DOPBSP->text('SEARCH_FRONT_END_CHECK_OUT'),
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
                                                                                           $DOPBSP->text('MONTH_DECEMBER'))));
                }

                /*
                 * Start hour data.
                 */
                if ($reservation->start_hour != ''){
                    $this->displayData($DOPBSP->text('SEARCH_FRONT_END_START_HOUR'),
                                       $settings_calendar->hours_ampm == 'true' ? $DOPBSP->classes->prototypes->getAMPM($reservation->start_hour):$reservation->start_hour);
                }

                /*
                 * End hour data.
                 */
                if ($reservation->end_hour != ''){
                    $this->displayData($DOPBSP->text('SEARCH_FRONT_END_END_HOUR'),
                                       $settings_calendar->hours_ampm == 'true' ? $DOPBSP->classes->prototypes->getAMPM($reservation->end_hour):$reservation->end_hour);
                }

                /*
                 * No items data.
                 */
                if ($settings_calendar->sidebar_no_items_enabled == 'true'){
                    $this->displayData($DOPBSP->text('SEARCH_FRONT_END_NO_ITEMS'),
                                       $reservation->no_items);
                }

                /*
                 * IP address.
                 */
                if($reservation->ip != '' && DOPBSP_CONFIG_VIEW_IP_ADDRESS) {
                    $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_IP_ADDRESS'),
                                       $reservation->ip);
                }

                /*
                 * Reservation price.
                 */
                if ($reservation->price > 0){
                    $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_PRICE'),
                                       $DOPBSP->classes->price->set($reservation->price,
                                                                    $reservation->currency,
                                                                    $settings_calendar->currency_position),
                                       'dopbsp-price');
                }
?>
                        <br />
<?php
                /*
                 * Payment method.
                 */
                switch ($reservation->payment_method){
                    case '':
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('ORDER_PAYMENT_METHOD_NONE'));
                        break;
                    case '0':
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('ORDER_PAYMENT_METHOD_NONE'));
                        break;
                    case '1':
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('ORDER_PAYMENT_METHOD_NONE'));
                        break;
                    case 'none':
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('ORDER_PAYMENT_METHOD_NONE'));
                        break;
                    case 'default':
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('ORDER_PAYMENT_METHOD_ARRIVAL'));
                        break;
                    case 'woocommerce':
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('ORDER_PAYMENT_METHOD_WOOCOMMERCE'));
                        
                        /*
                         * Order ID
                         */
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD_WOOCOMMERCE_ORDER_ID'),
                                           '<a href="'.get_edit_post_link($reservation->transaction_id).'" target="_blank">'.$reservation->transaction_id.'</a>');
                        break;
                    default:
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_'.strtoupper($reservation->payment_method)));
                        
                        /*
                         * Transaction ID
                         */
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD_TRANSACTION_ID'),
                                           $reservation->transaction_id);
                }
                        
                /*
                 * Synced from google/airbnb
                 */
                if($reservation->reservation_from != 'pinpoint') {
                    $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_SYNC'),
                                       ucfirst($reservation->reservation_from));
                }

                /*
                 * Reservation total price.
                 */
                if ($reservation->price_total >= 0){
                    $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_TOTAL_PRICE'),
                                       $DOPBSP->classes->price->set($reservation->price_total,
                                                                    $reservation->currency,
                                                                    $settings_calendar->currency_position),
                                       'dopbsp-price-total');
                }

                /*
                 * Deposit
                 */
                if ($reservation->deposit_price > 0){
                    $deposit = json_decode(stripslashes($reservation->deposit));
                    
                    $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT'),
                                       ($deposit->price_type == 'percent' ? '<span class="info-rule">&#9632;&nbsp;'.$deposit->price.'%</span><br />':'').
                                        $DOPBSP->classes->price->set($reservation->deposit_price,
                                                                     $reservation->currency,
                                                                     $settings_calendar->currency_position),
                                       'dopbsp-price');
                    $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT_LEFT'),
                                       $DOPBSP->classes->price->set($reservation->price_total-$reservation->deposit_price,
                                                                    $reservation->currency,
                                                                    $settings_calendar->currency_position),
                                       'dopbsp-price-total');
                }
?>
                    </div>
                </div>
<?php
            }
        }
    }