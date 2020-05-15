<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.3.3
* File                    : views/reservations/views-backend-reservation.php
* File Version            : 1.0.2
* Created / Last Modified : 12 October 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservation views class.
*/

    if (!class_exists('DOPBSPViewsBackEndReservation')){
        class DOPBSPViewsBackEndReservation extends DOPBSPViewsBackEndReservations{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Reservation template.
             * 
             * @param args (array): function arguments
             *                      * reservation (object): reservation data
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $reservation = $args['reservation'];
               
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d', 
                                                          $reservation->calendar_id));
                $settings_calendar = $DOPBSP->classes->backend_settings->values($reservation->calendar_id,  
                                                                                'calendar');
                $settings_payment = $DOPBSP->classes->backend_settings->values($reservation->calendar_id,  
                                                                               'payment');
                
                $display_approve_button = false;
                $display_reject_button = false;
                $display_cancel_button = false;
                $display_delete_button = false;
                        
                switch ($reservation->status){
                    case 'pending':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_PENDING');
                        $display_approve_button = true;
                        $display_reject_button = true;
                        break;
                    case 'approved':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_APPROVED');
                        $display_cancel_button = true;
                        break;
                    case 'rejected':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_REJECTED');
                        $display_approve_button = true;
                        $display_delete_button = true;
                        break;
                    case 'canceled':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_CANCELED');
                        $display_approve_button = true;
                        $display_delete_button = true;
                        break;
                    default:
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_EXPIRED');
                        $display_delete_button = true;
                }

                switch ($reservation->payment_method){
                    case 'default':
                        $reservation_payment_method = $DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_ARRIVAL');
                        break;
                    case 'paypal':
                        $reservation_payment_method = $DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PAYPAL');
                        break;
                    default:
                        $reservation_payment_method = $DOPBSP->text('RESERVATIONS_RESERVATIONS_PAYMENT_NONE');
                }

                $dc_hour = substr($reservation->date_created, 11, 5);
                $dc_date = substr($reservation->date_created, 0, 10);
                $reservation_date_created = $DOPBSP->classes->prototypes->setDateToFormat($dc_date, 
                                                                                          $settings_calendar->date_type.' '.($settings_calendar->hours_ampm == 'true' ? $DOPBSP->classes->prototypes->getAMPM($dc_hour):$dc_hour),
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
                                                                                                $DOPBSP->text('MONTH_DECEMBER')));
?>
                    <li id="DOPBSP-reservation<?php echo $reservation->id; ?>">
                        <div class="dopbsp-reservation-head">
                            <div class="dopbsp-icon dopbsp-<?php echo $reservation->status; ?>"></div>
                            <div class="dopbsp-title">
                                <strong>ID: </strong><?php echo $reservation->id; ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS'); ?>: </strong><span class="dopbsp-status-info dopbsp-<?php echo $reservation->status; ?>"><?php echo $reservation_status_label; ?></span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_DATE_CREATED'); ?>: </strong><?php echo $reservation_date_created; ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
<?php
                if ($reservation->check_in >= date('Y-m-d')){
                    $refund_enabled = $reservation->payment_method.'_refund_enabled';
?>
                            <div class="dopbsp-buttons-wrapper">
                                <a href="javascript:DOPBSPBackEnd.confirmation('RESERVATIONS_RESERVATION_APPROVE_CONFIRMATION', 'DOPBSPBackEndReservation.approve(<?php echo $reservation->id; ?>)')" class="dopbsp-button-approve" style="display: <?php echo $display_approve_button ? 'block':'none'; ?>"><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_APPROVE'); ?></a>
                                <a href="javascript:DOPBSPBackEnd.confirmation('RESERVATIONS_RESERVATION_REJECT_CONFIRMATION', 'DOPBSPBackEndReservation.reject(<?php echo $reservation->id; ?>)')" class="dopbsp-button-reject" style="display: <?php echo $display_reject_button ? 'block':'none'; ?>"><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_REJECT'); ?></a>
                                <a href="javascript:DOPBSPBackEnd.confirmation('RESERVATIONS_RESERVATION_CANCEL_CONFIRMATION<?php echo isset($settings_payment->$refund_enabled) && $settings_payment->$refund_enabled == 'true' ? '_REFUND':''; ?>', 'DOPBSPBackEndReservation.cancel(<?php echo $reservation->id; ?>)')" class="dopbsp-button-cancel" style="display: <?php echo $display_cancel_button ? 'block':'none'; ?>"><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_CANCEL'); ?></a>
                                <a href="javascript:DOPBSPBackEnd.confirmation('RESERVATIONS_RESERVATION_DELETE_CONFIRMATION', 'DOPBSPBackEndReservation.delete(<?php echo $reservation->id; ?>)')" class="dopbsp-button-delete" style="display: <?php echo $display_delete_button ? 'block':'none'; ?>"><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_DELETE'); ?></a>
                            </div>
<?php
                }
?>
                        </div>
                        <div class="dopbsp-reservation-body">
<?php
                /*
                 * Display details.
                 */
                $DOPBSP->views->backend_reservation_details->template(array('reservation' => $reservation,
                                                                            'calendar' => $calendar,
                                                                            'settings_calendar' => $settings_calendar));
                
                /*
                 * Display form data.
                 */
                $DOPBSP->views->backend_reservation_form->template(array('reservation' => $reservation));
                
                /*
                 * Display extras data.
                 */
                if ((int)$settings_calendar->extra != 0){
                    $DOPBSP->views->backend_reservation_extras->template(array('reservation' => $reservation,
                                                                               'settings_calendar' => $settings_calendar));
                }
                
                /*
                 * Display discount data.
                 */
                if ((int)$settings_calendar->discount != 0){
                    $DOPBSP->views->backend_reservation_discount->template(array('reservation' => $reservation,
                                                                                 'settings_calendar' => $settings_calendar));
                }
                
                /*
                 * Display fees data.
                 */
                if ($settings_calendar->fees != ''){
                    $DOPBSP->views->backend_reservation_fees->template(array('reservation' => $reservation,
                                                                             'settings_calendar' => $settings_calendar));
                }
                
                /*
                 * Display coupon data.
                 */
                if ((int)$settings_calendar->coupon != 0){
                    $DOPBSP->views->backend_reservation_coupon->template(array('reservation' => $reservation,
                                                                               'settings_calendar' => $settings_calendar));
                }
                
                /*
                 * Billing address.
                 */
                if ($settings_payment->address_billing_enabled == 'true'){
                    $DOPBSP->views->backend_reservation_address->template(array('reservation' => $reservation,
                                                                                'settings_payment' => $settings_payment,
                                                                                'type' => 'billing'));
                }
                
                /*
                 * Shipping address.
                 */
                if ($settings_payment->address_shipping_enabled == 'true'){
                    $DOPBSP->views->backend_reservation_address->template(array('reservation' => $reservation,
                                                                                'settings_payment' => $settings_payment,
                                                                                'type' => 'shipping'));
                }
?>
                        </div>
                    </li> 
<?php                
            }
            
            /*
             * Reservation template.
             * 
             * @param args (array): function arguments
             *                      * reservation (object): reservation data
             */
            function templatePrint($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $reservation = $args['reservation'];
               
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d', 
                                                          $reservation->calendar_id));
                $settings_calendar = $DOPBSP->classes->backend_settings->values($reservation->calendar_id,  
                                                                                'calendar');
                $settings_payment = $DOPBSP->classes->backend_settings->values($reservation->calendar_id,  
                                                                               'payment');
                
                $display_approve_button = false;
                $display_reject_button = false;
                $display_cancel_button = false;
                $display_delete_button = false;
                        
                switch ($reservation->status){
                    case 'pending':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_PENDING');
                        $display_approve_button = true;
                        $display_reject_button = true;
                        break;
                    case 'approved':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_APPROVED');
                        $display_cancel_button = true;
                        break;
                    case 'rejected':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_REJECTED');
                        $display_approve_button = true;
                        $display_delete_button = true;
                        break;
                    case 'canceled':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_CANCELED');
                        $display_approve_button = true;
                        $display_delete_button = true;
                        break;
                    default:
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_EXPIRED');
                        $display_delete_button = true;
                }

                switch ($reservation->payment_method){
                    case 'default':
                        $reservation_payment_method = $DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_ARRIVAL');
                        break;
                    case 'paypal':
                        $reservation_payment_method = $DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PAYPAL');
                        break;
                    default:
                        $reservation_payment_method = $DOPBSP->text('RESERVATIONS_RESERVATIONS_PAYMENT_NONE');
                }

                $dc_hour = substr($reservation->date_created, 11, 5);
                $dc_date = substr($reservation->date_created, 0, 10);
                $reservation_date_created = $DOPBSP->classes->prototypes->setDateToFormat($dc_date, 
                                                                                          $settings_calendar->date_type.' '.($settings_calendar->hours_ampm == 'true' ? $DOPBSP->classes->prototypes->getAMPM($dc_hour):$dc_hour),
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
                                                                                                $DOPBSP->text('MONTH_DECEMBER')));
?>
                    <li id="DOPBSP-reservation<?php echo $reservation->id; ?>">
                        <div class="dopbsp-reservation-head">
                            <div class="dopbsp-icon dopbsp-<?php echo $reservation->status; ?>"></div>
                            <div class="dopbsp-title">
                                <strong>ID: </strong><?php echo $reservation->id; ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS'); ?>: </strong><span class="dopbsp-status-info dopbsp-<?php echo $reservation->status; ?>"><?php echo $reservation_status_label; ?></span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_DATE_CREATED'); ?>: </strong><?php echo $reservation_date_created; ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                        </div>
                        <div class="dopbsp-reservation-body">
<?php
                /*
                 * Display details.
                 */
                $DOPBSP->views->backend_reservation_details->template(array('reservation' => $reservation,
                                                                            'calendar' => $calendar,
                                                                            'settings_calendar' => $settings_calendar));
                
                /*
                 * Display form data.
                 */
                $DOPBSP->views->backend_reservation_form->templatePrint(array('reservation' => $reservation));
                
                /*
                 * Display extras data.
                 */
                if ((int)$settings_calendar->extra != 0){
                    $DOPBSP->views->backend_reservation_extras->template(array('reservation' => $reservation,
                                                                               'settings_calendar' => $settings_calendar));
                }
                
                /*
                 * Display discount data.
                 */
                if ((int)$settings_calendar->discount != 0){
                    $DOPBSP->views->backend_reservation_discount->template(array('reservation' => $reservation,
                                                                                 'settings_calendar' => $settings_calendar));
                }
                
                /*
                 * Display fees data.
                 */
                if ($settings_calendar->fees != ''){
                    $DOPBSP->views->backend_reservation_fees->template(array('reservation' => $reservation,
                                                                             'settings_calendar' => $settings_calendar));
                }
                
                /*
                 * Display coupon data.
                 */
                if ((int)$settings_calendar->coupon != 0){
                    $DOPBSP->views->backend_reservation_coupon->template(array('reservation' => $reservation,
                                                                               'settings_calendar' => $settings_calendar));
                }
                
                /*
                 * Billing address.
                 */
                if ($settings_payment->address_billing_enabled == 'true'){
                    $DOPBSP->views->backend_reservation_address->template(array('reservation' => $reservation,
                                                                                'settings_payment' => $settings_payment,
                                                                                'type' => 'billing'));
                }
                
                /*
                 * Shipping address.
                 */
                if ($settings_payment->address_shipping_enabled == 'true'){
                    $DOPBSP->views->backend_reservation_address->template(array('reservation' => $reservation,
                                                                                'settings_payment' => $settings_payment,
                                                                                'type' => 'shipping'));
                }
?>
                        </div>
                    </li> 
<?php                
            }
            
            /*
             * Create a reservation data field.
             * 
             * @param label (string):  data label
             * @param value (string):  data value
             * @param class (string):  data class
             * 
             * @return calendars list
             */
            function displayData($label = '',
                                 $value = '',
                                 $class = '',
                                 $id = 0,
                                 $reservation_id = 0,
                                 $is_email = false){
                $html = array();
                
                $label = stripslashes($label);
                $value = stripslashes($value);
                $value_display = $value;
                
                if($is_email) {
                    $value_display = '<a href="mailto:'.$value.'">'.$value.'</a>';
                }
                
                array_push($html, '<div class="dopbsp-data-field dopbsp-input-wrapper '.$class.'">');
                array_push($html, ' <label>'.$label.'</label>');
                
                if($id != 0) {
                    array_push($html, ' <div id="dopbsp-reservation-form-field-value-'.$reservation_id.'-'.$id.'" class="dopbsp-reservation-form-'.$reservation_id.' dopbsp-data-value">'.$value_display.'</div>');
                    array_push($html, ' <input id="dopbsp-reservation-form-field-edit-'.$reservation_id.'-'.$id.'"  data-reservation-id="'.$reservation_id.'"  class="dopbsp-reservation-form-'.$reservation_id.'-edit dopbsp-reservation-form-edit dopbsp-hidden" value="'.$value.'" />');
                } else {
                    array_push($html, ' <div class="dopbsp-data-value">'.$value.'</div>');
                }
                
                array_push($html, '</div>');
                
                echo implode('', $html);
            }
            
            /*
             * Create a reservation data field.
             * 
             * @param label (string):  data label
             * @param value (string):  data value
             * @param class (string):  data class
             * 
             * @return calendars list
             */
            function printData($label = '',
                               $value = '',
                               $class = ''){
                $html = array();
                
                $label = stripslashes($label);
                $value = stripslashes($value);
                $value_display = $value;
                
                array_push($html, '<div class="dopbsp-data-field dopbsp-input-wrapper '.$class.'">');
                array_push($html, ' <label>'.$label.'</label>');
                array_push($html, ' <div class="dopbsp-data-value">'.$value.'</div>');
                array_push($html, '</div>');
                
                echo implode('', $html);
            } // to add
        }
    }