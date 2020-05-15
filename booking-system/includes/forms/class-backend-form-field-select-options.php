<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/forms/class-backend-form-field-select-options.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end form field select options PHP class.
*/

    if (!class_exists('DOPBSPBackEndFormFieldSelectOptions')){
        class DOPBSPBackEndFormFieldSelectOptions extends DOPBSPBackEndFormField{
            /*
             * Constructor
             */        
            function __construct(){
            }
            
            /*
             * Sort form field select options.
             * 
             * @post positions (string): list of options ids in new order
             */
            function sort(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $ids = explode(',', $DOT->post('ids'));
                $i = 0;
                        
                foreach ($ids as $id){
                    $i++;
                    $wpdb->update($DOPBSP->tables->forms_fields_options, array('position' => $i), 
                                                                         array('id' => $id));
                }
                
                die();
            }
        }
    }