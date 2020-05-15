<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/extras/class-backend-extra-group-items.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end extra group items PHP class.
*/

    if (!class_exists('DOPBSPBackEndExtraGroupItems')){
        class DOPBSPBackEndExtraGroupItems extends DOPBSPBackEndExtraGroup{
            /*
             * Constructor
             */        
            function __construct(){
            }
            
            /*
             * Sort extra group items.
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
                    $wpdb->update($DOPBSP->tables->extras_groups_items, array('position' => $i), 
                                                                        array('id' => $id));
                }
                
                die();
            }
        }
    }