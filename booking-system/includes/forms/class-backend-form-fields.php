<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/forms/class-backend-form-fields.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end form fields PHP class.
*/

    if (!class_exists('DOPBSPBackEndFormFields')){
        class DOPBSPBackEndFormFields extends DOPBSPBackEndForm{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Sort form fields.
             * 
             * @post ids (string): list of fields ids in new order
             */
            function sort(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $ids = explode(',', $DOT->post('ids'));
                $i = 0;
                
                foreach ($ids as $id){
                    $i++;
                    $wpdb->update($DOPBSP->tables->forms_fields, array('position' => $i), 
                                                                 array('id' => $id));
                }
                
                die();
            }
        }
    }