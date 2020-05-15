<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.3.3
* File                    : views/reservations/views-backend-reservation-form.php
* File Version            : 1.0
* Created / Last Modified : 12 October 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end reservation form views class.
*/

    if (!class_exists('DOPBSPViewsBackEndReservationForm')){
        class DOPBSPViewsBackEndReservationForm extends DOPBSPViewsBackEndReservation{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * @param args (array): function arguments
             *                      * reservation (object): reservation data
             */
            function template($args = array()){
                global $DOPBSP;
                
                $reservation = $args['reservation'];
?>
                <div class="dopbsp-data-module">
                    <div class="dopbsp-reservation-form dopbsp-data-head"> 
                        <h3><?php echo $DOPBSP->text('FORMS_FRONT_END_TITLE'); ?></h3>
                        <span id="dopbsp-reservation-form-<?php echo $reservation->id; ?>">Edit</span>
                        <span id="dopbsp-reservation-form-<?php echo $reservation->id; ?>-save" class="dopbsp-hidden">Save</span>
                    </div>
                    <div class="dopbsp-data-body"> 
<?php
                if ($reservation->form != ''){
                    $reservation->form = str_replace("'", "&#39;", $reservation->form);
                    $reservation->form = str_replace('\"', "&#39;", $reservation->form); 
                    $reservation->form = utf8_decode($reservation->form);
?>
                        <input type="hidden" id="dopbsp-reservation-form-<?php echo $reservation->id; ?>-data" value='<?php echo $reservation->form; ?>'/>
<?php 
                    $form = json_decode($reservation->form);

                    for ($i=0; $i<count($form); $i++){
                        $is_email = false;
                        
                        if (!is_array($form[$i])){
                            $form_item = get_object_vars($form[$i]);
                        }
                        else{
                            $form_item = $form[$i];
                        }

                        if (is_array($form_item['value'])){
                            $values = array();

                            foreach ($form_item['value'] as $value){
                                array_push($values, $value->translation);
                            }
                            $this->displayData($form_item['translation'],
                                               implode('<br />', $values));
                        }
                        else{
                            if ($form_item['value'] == 'true'){
                                $value = $DOPBSP->text('FORMS_FORM_FIELD_TYPE_CHECKBOX_CHECKED_LABEL');
                            }
                            elseif ($form_item['value'] == 'false'){
                                $value = $DOPBSP->text('FORMS_FORM_FIELD_TYPE_CHECKBOX_UNCHECKED_LABEL');
                            }
                            else{
                                $value = $form_item['value'];
                                
                                if(isset($form_item['is_email']) && $form_item['is_email'] == 'true') {
                                    $is_email = true;
                                }
                            }
                            
                            $this->displayData($form_item['translation'],
                                               $value != '' ? $value:$DOPBSP->text('RESERVATIONS_RESERVATION_NO_FORM_FIELD'),
                                               $value != '' ? '':'dopbsp-no-data',
                                               $form_item['id'],
                                               $reservation->id,
                                               $is_email);
                        }
                    }
                }
                else{
                    echo '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_NO_FORM').'</em>';
                }
?>
                    </div>
                </div>
<?php
            }
            
            /*
             * @param args (array): function arguments
             *                      * reservation (object): reservation data
             */
            function templatePrint($args = array()){
                global $DOPBSP;
                
                $reservation = $args['reservation'];
?>
                <div class="dopbsp-data-module">
                    <div class="dopbsp-reservation-form dopbsp-data-head"> 
                        <h3><?php echo $DOPBSP->text('FORMS_FRONT_END_TITLE'); ?></h3>
                    </div>
                    <div class="dopbsp-data-body"> 
<?php
                if ($reservation->form != ''){
                    $reservation->form = utf8_decode($reservation->form);
?>
                        <input type="hidden" id="dopbsp-reservation-form-<?php echo $reservation->id; ?>-data" value='<?php echo $reservation->form; ?>'/>
<?php 
                    $form = json_decode($reservation->form);

                    for ($i=0; $i<count($form); $i++){
                        $is_email = false;
                        
                        if (!is_array($form[$i])){
                            $form_item = get_object_vars($form[$i]);
                        }
                        else{
                            $form_item = $form[$i];
                        }

                        if (is_array($form_item['value'])){
                            $values = array();

                            foreach ($form_item['value'] as $value){
                                array_push($values, $value->translation);
                            }
                            $this->displayData($form_item['translation'],
                                               implode('<br />', $values));
                        }
                        else{
                            if ($form_item['value'] == 'true'){
                                $value = $DOPBSP->text('FORMS_FORM_FIELD_TYPE_CHECKBOX_CHECKED_LABEL');
                            }
                            elseif ($form_item['value'] == 'false'){
                                $value = $DOPBSP->text('FORMS_FORM_FIELD_TYPE_CHECKBOX_UNCHECKED_LABEL');
                            }
                            else{
                                $value = $form_item['value'];
                            }
                            
                            $this->printData($form_item['translation'],
                                             $value != '' ? $value:$DOPBSP->text('RESERVATIONS_RESERVATION_NO_FORM_FIELD'),
                                             $value != '' ? '':'dopbsp-no-data');
                        }
                    }
                }
                else{
                    echo '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_NO_FORM').'</em>';
                }
?>
                    </div>
                </div>
<?php
            } // to add
        }
    }