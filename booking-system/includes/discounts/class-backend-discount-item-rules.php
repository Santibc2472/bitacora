<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/discounts/class-backend-discount-item-rules.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discount item rules PHP class.
*/

    if (!class_exists('DOPBSPBackEndDiscountItemRules')){
        class DOPBSPBackEndDiscountItemRules extends DOPBSPBackEndDiscountItem{
            /*
             * Constructor
             */        
            function __construct(){
            }
            
            /*
             * Sort discount item rules.
             * 
             * @post ids (string): list of rules ids in new order
             */
            function sort(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $ids = explode(',', $DOT->post('ids'));
                $i = 0;
                        
                foreach ($ids as $id){
                    $i++;
                    $wpdb->update($DOPBSP->tables->discounts_items_rules, array('position' => $i), 
                                                                          array('id' => $id));
                }
                
                die();
            }
        }
    }