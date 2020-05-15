<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : views/reservations/views-backend-reservation-fees.php
* File Version            : 1.0.5
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservation fees views class.
*/

    if (!class_exists('DOPBSPViewsBackEndReservationFees')){
        class DOPBSPViewsBackEndReservationFees extends DOPBSPViewsBackEndReservation{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * @param args (array): function arguments
             *                      * reservation (object): reservation data
             *                      * settings_calendar (object): calendar settings data
             */
            function template($args = array()){
                global $DOPBSP;
                
                $reservation = $args['reservation'];
                $settings_calendar = $args['settings_calendar'];
?>
                <div class="dopbsp-data-module">
                    <div class="dopbsp-data-head"> 
                        <h3><?php echo $DOPBSP->text('FEES_FRONT_END_TITLE'); ?></h3>
                    </div>
                    <div class="dopbsp-data-body"> 
<?php           
                if ($reservation->fees != ''){
                    $fees = json_decode(utf8_decode($reservation->fees));

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

                        $this->displayData($fee->translation,
                                           implode('', $value));
                    }
                    
                    if ($reservation->fees_price != 0){
                        echo '<br />';
                        $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PRICE_CHANGE'),
                                           ($reservation->fees_price > 0 ? '+':'-').
                                                '&nbsp;'.
                                                $DOPBSP->classes->price->set($reservation->fees_price,
                                                                             $reservation->currency,
                                                                             $settings_calendar->currency_position),
                                           'dopbsp-price');
                    }
                }
                else{
                    echo '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_NO_FEES').'</em>';
                }
?>
                    </div>
                </div>
<?php
            }
        }
    }