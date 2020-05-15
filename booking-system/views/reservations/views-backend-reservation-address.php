<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : views/reservations/views-backend-reservation-address.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservation address views class.
*/

    if (!class_exists('DOPBSPViewsBackEndReservationAddress')){
        class DOPBSPViewsBackEndReservationAddress extends DOPBSPViewsBackEndReservation{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * @param args (array): function arguments
             *                      * reservation (object): reservation data
             *                      * settings_payment (object): payment settings data
             *                      * type (string): address type
             */
            function template($args = array()){
                global $DOPBSP;
                
                $fields = array('first_name',
                                'last_name',
                                'company',
                                'email',
                                'phone',
                                'country',
                                'address_first',
                                'address_second',
                                'city',
                                'state',
                                'zip_code');
                
                $reservation = $args['reservation'];
                $settings_payment = $args['settings_payment'];
                $type = isset($args['type']) ? $args['type']:'billing';
                
                $reservation_address = $type == 'billing' ? $reservation->address_billing:$reservation->address_shipping;
?>
                <div class="dopbsp-data-module">
                    <div class="dopbsp-data-head"> 
                        <h3><?php echo $DOPBSP->text('ORDER_ADDRESS_'.strtoupper($type)); ?></h3>
                    </div>
                    <div class="dopbsp-data-body"> 
<?php
                if ($type == 'shipping'
                        && $reservation_address == 'billing_address'){
                    echo '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_ADDRESS_SHIPPING_COPY').'</em>';
                }
                elseif ($reservation_address != ''){
                    $address = json_decode(utf8_decode($reservation_address));
                    
                    foreach ($fields as $field){
                        $settings_field = 'address_'.$type.'_'.$field.'_enabled';
                        
                        if ($settings_payment->$settings_field == 'true'){
                            $this->displayData($DOPBSP->text('ORDER_ADDRESS_'.strtoupper($field)),
                                               $address->$field != '' ? ($field == 'email' ? '<a href="mailto:'.$address->$field.'">'.$address->$field.'</a>':
                                                                                             $address->$field):
                                                                        $DOPBSP->text('RESERVATIONS_RESERVATION_NO_FORM_FIELD'),
                                               $address->$field != '' ? '':'dopbsp-no-data');
                        }
                    }
                }
                else{
                    echo '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_NO_ADDRESS_'.strtoupper($type)).'</em>';
                }
?>
                    </div>
                </div>
<?php
            }
        }
    }