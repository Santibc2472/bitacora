<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/extras/class-backend-extra-groups.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end extra groups PHP class.
*/

    if (!class_exists('DOPBSPBackEndExtraGroups')){
        class DOPBSPBackEndExtraGroups extends DOPBSPBackEndExtra{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Sort extra groups.
             * 
             * @post ids (string): list of groups ids in new order
             */
            function sort(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $ids = explode(',', $DOT->post('ids'));
                $i = 0;
                
                foreach ($ids as $id){
                    $i++;
                    $wpdb->update($DOPBSP->tables->extras_groups, array('position' => $i), 
                                                                  array('id' => $id));
                }
                
                die();
            }
        }
    }