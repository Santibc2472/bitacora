<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/discounts/class-backend-discount-items.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discount items PHP class.
*/

    if (!class_exists('DOPBSPBackEndDiscountItems')){
        class DOPBSPBackEndDiscountItems extends DOPBSPBackEndDiscount{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Sort discount items.
             * 
             * @post ids (string): list of items ids in new order
             */
            function sort(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $ids = explode(',', $DOT->post('ids'));
                $i = 0;
                
                foreach ($ids as $id){
                    $i++;
                    $wpdb->update($DOPBSP->tables->discounts_items, array('position' => $i), 
                                                                    array('id' => $id));
                }
                
                die();
            }
        }
    }