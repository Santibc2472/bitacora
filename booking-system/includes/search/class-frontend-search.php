<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : includes/search/class-frontend-search.php
* File Version            : 1.0.1
* Created / Last Modified : 17 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2016 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end search PHP class.
*/

    if (!class_exists('DOPBSPFrontEndSearch')){
        class DOPBSPFrontEndSearch extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function __construct(){
            }
            
            /*
             * Get search.
             * 
             * @param settings (object): calendar settings
             * 
             * @return data array
             */
            function get(){
                global $DOPBSP;
                    
                return array('data' => array(),
                             'text' => array('checkIn' => $DOPBSP->text('SEARCH_FRONT_END_CHECK_IN'),
                                             'checkOut' => $DOPBSP->text('SEARCH_FRONT_END_CHECK_OUT'),
                                             'hourEnd' => $DOPBSP->text('SEARCH_FRONT_END_END_HOUR'),
                                             'hourStart' => $DOPBSP->text('SEARCH_FRONT_END_START_HOUR'),
                                             'noItems' => $DOPBSP->text('SEARCH_FRONT_END_NO_ITEMS'),
                                             'noServices' => $DOPBSP->text('SEARCH_FRONT_END_NO_SERVICES_AVAILABLE'),
                                             'noServicesSplitGroup' => $DOPBSP->text('SEARCH_FRONT_END_NO_SERVICES_AVAILABLE_SPLIT_GROUP'),
                                             'title' => $DOPBSP->text('SEARCH_TITLE')));
            }
        }
    }